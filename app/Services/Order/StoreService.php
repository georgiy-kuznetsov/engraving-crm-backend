<?php
namespace App\Services\Order;

use App\Models\Order\Order;

class StoreService extends BaseService {
    public function store(array $data): Order
    {
        $products = $this->getProductArrToAttach($data['products']);
        $billets = $this->getBilletArrToAttach($data['billets']);

        $order = Order::create([
            ...$this->getOrderData($data, $products),
            'user_id' => auth()->user()->id,
        ]);

        $order->products()->attach($products);
        $order->billets()->attach($billets);

        if ( ! $order->number) {
            $order->number = $order->getNumber();
            $order->save();
        }

        return $order->load([ 'status', 'paymentStatus', 'coupon', 'paymentMethod', 'shippingMethod', 'customer', 'products', 'billets', 'source' ]);
    }
}
