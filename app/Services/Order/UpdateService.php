<?php
namespace App\Services\Order;

use App\Models\Order\Order;

class UpdateService extends BaseService {
    public function __invoke(Order $order, array $data): Order
    {
        $products = $this->getProductArrToAttach($data['products']);
        $billets = $this->getBilletArrToAttach($data['billets']);

        $order->update( $this->getOrderData($data, $products) );

        $order->products()->sync($products);
        $order->billets()->sync($billets);

        return $order->load([ 'status', 'paymentStatus', 'coupon', 'paymentMethod', 'shippingMethod', 'customer', 'products', 'billets', 'source' ]);
    }

}
