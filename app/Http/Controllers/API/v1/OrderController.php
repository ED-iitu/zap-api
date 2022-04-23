<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 23.04.2022
 * Time: 15:26
 */

namespace App\Http\Controllers\API\v1;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $order = new Order();

        $order->order_number = uniqid('ORD.');
        $order->user_id      = request()->user()->id;
        $order->items_count  = $request->items_count;
        $order->grand_total  = $request->grand_total;
        $order->address_id   = $request->address_id;
        $order->time         = $request->time;
        $order->notes        = $request->notes ?? null;

        $order->save();

        $orderItems = $request->order_items;


        foreach ($orderItems as $orderItem) {
            $item = new OrderItem();

            $item->order_id = $order->id;
            $item->product_id = $orderItem['product_id'];
            $item->quantity = $orderItem['quantity'];
            $item->price = $orderItem['price'];

            $item->save();
        }

        return [
            'code' => 200,
            'result' => [
                'order' => $order->setRelation('address', $order->address)->setRelation('user', $order->user),
                'orderItems' => $orderItems,
            ]
        ];
    }

    public function getAll()
    {
        $orders = Order::where('user_id', request()->user()->id)->with('items.product')->paginate(15);

        if (empty($orders)) {
            return [
                'code' => 404,
                'result' => null
            ];
        }

        return [
            'code' => 200,
            'result' => $orders
        ];

    }

    public function getOne(int $id)
    {
        $order = Order::where('id', $id)->with('items.product')->first();

        if (empty($order)) {
            return \response(['code' => 404, 'result' => null])->setStatusCode(404);
        }

        return [
            'code' => 200,
            'result' => $order
        ];
    }
}