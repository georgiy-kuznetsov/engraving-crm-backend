<?php
namespace App\Service\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreRequest;
use App\Models\Coupon;
use App\Models\Order\Order;
use App\Models\Product\Product;
use Carbon\Carbon;

class StoreService extends Controller {
    public function __invoke(StoreRequest $request, array $data): Order
    {
        $productModels = Product::select(['id', 'name', 'photo', 'price', 'sale_price', 'onsale'])
                            ->whereIn('id', $data['products'])
                            ->get();
        $billetModels = Product::select(['id', 'name', 'photo', 'price', 'sale_price', 'onsale'])
                            ->whereIn('id', $data['products'])
                            ->get();
        if ($data['coupon_id']) {
            $coupon = Coupon::findOrFail($data['coupon_id']);
        }

        $products = [];
        foreach ($data['products'] as $key => $productId) {
            $product = $productModels->find($productId);

            $productQuantity = $data['products_quantity'][$key];
            $amount = ($product->onsale)
                        ? $product->sale_price * $productQuantity
                        : $product->price * $productQuantity;
            $products[$productId] = [
                'name' => $product->name,
                'photo' => $product->photo,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'onsale' => $product->onsale,
                'quantity' => $productQuantity,
                'amount' => $amount,
            ];
        }

        $billets = [];
        foreach ($data['billets'] as $key => $billetId) {
            $billet = $billetModels->find($billetId);

            $billetQuantity = $data['billets_quantity'][$key];
            $amount = ($billet->onsale)
                        ? $billet->sale_price * $billetQuantity
                        : $billet->price * $billetQuantity;
            $billets[$billetId] = [
                'name' => $billet->name,
                'photo' => $billet->photo,
                'price' => $billet->price,
                'onsale' => $billet->onsale,
                'quantity' => $billetQuantity,
                'amount' => $amount,
            ];
        }

        $cost = array_reduce($products, function($carry, $item) {
            $carry += $item['price'] * $item['quantity'];
            return  $carry;
        }, 0);

        $costDiscount = array_reduce($products, function($carry, $item) {
            if ($item['onsale']) {
                $carry += ($item['price'] - $item['sale_price']) * $item['quantity'];
            }
            return  $carry;
        }, 0);
        $costRemainder = $cost - $costDiscount;

        if ( isset($coupon) && Carbon::createFromTimestamp($coupon->expires_at)->isPast() ) {
            if ($coupon->type === 'percent') {
                $couponDiscount = ($costRemainder) * ((double) $coupon->discount_size / 100);
            } else {
                $couponDiscount = ( $coupon->discount_size >= ($costRemainder) )
                                    ? $costRemainder
                                    : $coupon->discount_size;
            }
        } else {
            $couponDiscount = 0;
        }

        $discountAmount = $costDiscount + $couponDiscount;
        $totalAmount = $cost - $discountAmount + $data['shipping_amount'] + $data['gratuity_amount'];

        $order = Order::create([
            ...$data,
            'price_amount' => $cost,
            'price_discount' => $costDiscount,
            'discount_amount' => $discountAmount,
            'amount' => $totalAmount,
            'user_id' => $request->user()->id,
        ]);

        $order->products()->attach($products);
        $order->billets()->attach($billets);

        if ( ! $order->number) {
            $order->number = $order->getNumber();
            $order->save();
        }

        return $order->load([
                    'status',
                    'paymentStatus',
                    'coupon',
                    'paymentMethod',
                    'shippingMethod',
                    'customer',
                    'products',
                    'billets',
                    'source'
                ]);
    }
}
