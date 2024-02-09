<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Billet;
use App\Models\Order\Coupon;
use App\Models\Order\Order;
use App\Models\Product\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $page = (int) $request->input('page') ?? 1;
        $pageSize = (int) $request->input('pageSize') ?? env('API_ITEMS_PER_PAGE');

        $orders = Order::with(['status', 'coupon', 'paymentMethod', 'shippingMethod', 'customer', 'products', 'billets'])
                        ->paginate($pageSize, ['*'], 'page', $page);

        return [
            'page' => $orders->currentPage(),
            'pageSize' => $orders->perPage(),
            'total' => $orders->total(),
            'items' => $orders->items(),
        ];
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'number' => ['nullable', 'string', 'max:255', 'unique:orders'],
            'shipping_amount' => ['required', 'decimal:2', 'max:99999999.99'],
            'gratuity_amount' => ['required', 'decimal:2', 'max:99999999.99'],
            'coupon_id' => ['nullable', 'integer', 'exists:coupons,id'],
            'shipping_method_id' => ['nullable', 'integer', 'exists:shipping_methods,id'],
            'payment_method_id' => ['nullable', 'integer', 'exists:payment_methods,id'],
            'status_id' => ['nullable', 'integer', 'exists:order_statuses,id'],
            'customer_id' => ['nullable', 'integer', 'exists:customers,id'],
            
            'products' => ['nullable', 'array'],
            'products.*' => ['required', 'integer', 'exists:products,id'],
            'products_quantity' => ['nullable', 'array'],
            'products_quantity.*' => ['required', 'integer'],
            
            'billets' => ['nullable', 'array'],
            'billets.*' => ['required', 'integer', 'exists:products,id'],
            'billets_quantity' => ['nullable', 'array'],
            'billets_quantity.*' => ['required', 'integer'],
        ]);

        $productModels = Product::select(['id', 'name', 'photo', 'price', 'sale_price', 'onsale'])
                            ->whereIn('id', $validatedData['products'])
                            ->get();
        $billetModels = Product::select(['id', 'name', 'photo', 'price', 'sale_price', 'onsale'])
                            ->whereIn('id', $validatedData['products'])
                            ->get();
        if ($validatedData['coupon_id']) {
            $coupon = Coupon::findOrFail($validatedData['coupon_id']);
        }

        $products = [];
        foreach ($validatedData['products'] as $key => $productId) {
            $product = $productModels->find($productId);

            $productQuantity = $validatedData['products_quantity'][$key];
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
        foreach ($validatedData['billets'] as $key => $billetId) {
            $billet = $billetModels->find($billetId);

            $billetQuantity = $validatedData['billets_quantity'][$key];
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
        $totalAmount = $cost - $discountAmount + $validatedData['shipping_amount'] + $validatedData['gratuity_amount'];
        
        $order = Order::create([
            ...$validatedData,
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

        return $order->load(['status', 'coupon', 'paymentMethod', 'shippingMethod', 'customer', 'products', 'billets']);
    }

    public function show(Request $request, string $id)
    {
        return Order::with(['status', 'coupon', 'paymentMethod', 'shippingMethod', 'customer', 'products', 'billets'])
                    ->findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $validatedData = $request->validate([
            'shipping_amount' => ['required', 'decimal:2', 'min: 0.00', 'max:99999999.99'],
            'gratuity_amount' => ['required', 'decimal:2', 'min: 0.00', 'max:99999999.99'],
            'coupon_id' => ['nullable', 'integer', 'exists:coupons,id'],
            'shipping_method_id' => ['nullable', 'integer', 'exists:shipping_methods,id'],
            'payment_method_id' => ['nullable', 'integer', 'exists:payment_methods,id'],
            'status_id' => ['nullable', 'integer', 'exists:order_statuses,id'],
            'customer_id' => ['nullable', 'integer', 'exists:customers,id'],
                        
            'products' => ['nullable', 'array'],
            'products.*' => ['required', 'integer', 'exists:products,id'],
            'products_quantity' => ['nullable', 'array'],
            'products_quantity.*' => ['required', 'integer'],
            
            'billets' => ['nullable', 'array'],
            'billets.*' => ['required', 'integer', 'exists:products,id'],
            'billets_quantity' => ['nullable', 'array'],
            'billets_quantity.*' => ['required', 'integer'],
        ]);

        $productModels = Product::select(['id', 'name', 'photo', 'price', 'sale_price', 'onsale'])
                            ->whereIn('id', $validatedData['products'])
                            ->get();
        $billetModels = Product::select(['id', 'name', 'photo', 'price', 'sale_price', 'onsale'])
                            ->whereIn('id', $validatedData['products'])
                            ->get();
        if ($validatedData['coupon_id']) {
            $coupon = Coupon::findOrFail($validatedData['coupon_id']);
        }

        $products = [];
        foreach ($validatedData['products'] as $key => $productId) {
            $product = $productModels->find($productId);

            $productQuantity = $validatedData['products_quantity'][$key];
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
        foreach ($validatedData['billets'] as $key => $billetId) {
            $billet = $billetModels->find($billetId);

            $billetQuantity = $validatedData['billets_quantity'][$key];
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
        $totalAmount = $cost - $discountAmount + $validatedData['shipping_amount'] + $validatedData['gratuity_amount'];

        $order->update([
            ...$validatedData,
            'price_amount' => $cost,
            'price_discount' => $costDiscount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
        ]);

        $order->products()->sync($products);
        $order->billets()->sync($billets);

        return $order->load(['status', 'coupon', 'paymentMethod', 'shippingMethod', 'customer', 'products', 'billets']);
    }

    public function destroy(string $id)
    {
        if ( ! $order = Order::find($id) ) {
            return response()->json([], 204);
        };

        $order->delete();
        return response()->json([], 204);
    }
}

function getArrForAttach(array $itemsIds, array $itemsQuantities, Collection $itemsModels): array
{
    $pivots = [];
    foreach ($itemsIds as $key => $productId) {
        $product = $itemsModels->find($productId);
        $pivots[$productId] = [
            'name' => $product->name, 
            'photo' => $product->photo,
            'price' => $product->price, 
            'sale_price' => $product->sale_price,
            'onsale' => $product->onsale,
            'quantity' => $itemsQuantities[$key],
        ];
    }
    return $pivots;
}