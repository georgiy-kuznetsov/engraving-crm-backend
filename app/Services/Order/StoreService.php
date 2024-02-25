<?php
namespace App\Services\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreRequest;
use App\Models\Billet;
use App\Models\Coupon;
use App\Models\Order\Order;
use App\Models\Product\Product;

class StoreService extends Controller {
    public function store(StoreRequest $request, array $data): Order
    {
        $products = $this->getProductArrToAttach($data['products']);
        $billets = $this->getBilletArrToAttach($data['billets']);

        $cost = $this->getCost($products);
        $costDiscount = $this->getCostDiscount($products);

        $couponDiscount = ($data['coupon'])
                            ? $this->getCouponDiscount($data['coupon'], $cost - $costDiscount)
                            : 0;

        $totalAmount = $this->getTotalAmount([
            'cost' => $cost,
            'costDiscount' => $costDiscount,
            'couponDiscount' => $couponDiscount,
            'shippingAmount' => $data['shipping_amount'],
            'gratuityAmount' => $data['gratuity_amount'],
        ]);

        $order = Order::create([
            ...$data,
            'price_amount' => $cost,
            'price_discount' => $costDiscount,
            'discount_amount' => $costDiscount + $couponDiscount,
            'amount' => $totalAmount,
            'user_id' => $request->user()->id,
        ]);

        $order->products()->attach($products);
        $order->billets()->attach($billets);

        if ( ! $order->number) {
            $order->number = $order->getNumber();
            $order->save();
        }

        return $order->load([ 'status', 'paymentStatus', 'coupon', 'paymentMethod', 'shippingMethod', 'customer', 'products', 'billets', 'source' ]);
    }

    private function getProductArrToAttach(array $data): array
    {
        $ids = array_map( function($item) {
            return $item['id'];
        }, $data);

        $products = Product::whereIn('id', $ids)->get();

        $arrayToAttach = [];
        foreach ($data as $item) {
            $id = $item['id'];
            $product = $products->find($id);
            $productQtty = $item['quantity'];

            $amount = ($product->onsale)
                            ? $product->sale_price * $productQtty
                            : $product->price * $productQtty;

            $arrayToAttach[$id] = [
                'name' => $product->name,
                'photo' => $product->photo,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'onsale' => $product->onsale,
                'quantity' => $productQtty,
                'amount' => $amount,
            ];
        }

        return $arrayToAttach;
    }

    private function getBilletArrToAttach(array $data): array
    {
        $ids = array_map( function($item) {
            return $item['id'];
        }, $data);

        $billets = Billet::whereIn('id', $ids)->get();

        $arrayToAttach = [];
        foreach ($data as $item) {
            $id = $item['id'];
            $billet = $billets->find($id);
            $qtty = $item['quantity'];

            $arrayToAttach[$id] = [
                'name' => $billet->name,
                'photo' => $billet->photo,
                'price' => $billet->price,
                'onsale' => $billet->onsale,
                'quantity' => $qtty,
                'amount' => $billet->price * $qtty,
            ];
        }

        return $arrayToAttach;
    }

    private function getCouponDiscount(string $promocode, float $cost) {
        $coupon = Coupon::where('promocode', $promocode)->first();

        if ( $coupon->expires_at->isPast() ) {
            Throw new \Exception('Купон недействителен');
        }

        if ($coupon->type === 'percent') {
            return ($cost) * ((double) $coupon->discount_size / 100);
        } else {
            return ($coupon->discount_size < ($cost))
                        ? $coupon->discount_size
                        : $cost;
        }
    }

    private function getCost(array $products) {
        return array_reduce($products, function($carry, $item) {
            $carry += $item['price'] * $item['quantity'];
            return  $carry;
        }, 0);
    }

    private function getCostDiscount(array $products) {
        return array_reduce($products, function($carry, $item) {
            if ($item['onsale']) {
                $carry += ($item['price'] - $item['sale_price']) * $item['quantity'];
            }
            return  $carry;
        }, 0);
    }

    private function getTotalAmount(array $data) {
        return ($data['cost'] + $data['shippingAmount'] + $data['gratuityAmount']) - ($data['costDiscount'] + $data['couponDiscount']);
    }

    private function calculateOrderAmount(): int
    {
        return 0;
    }
}
