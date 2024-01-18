<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Order;
use App\Models\Order_Item;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orders=Order::with('user')->paginate(10);

        if ($orders){
           foreach($orders as $order){
            foreach( $order as $order_items){
                $product=Product::where('id',$order_items->product_id)->pluck('name');
                $order_items->product_name=$product['0'];
            }
           }
            return response()->json([
                'status'=>200,
                'orders'=>$orders,
            ]);
        }else return response()->json("There is no order");
       
    }

    public function show($id)
    {
        $order=Order::find($id);
        if (!$order){
            return response()->json('Order not found');
        }
        return response()->json([
            'status'=>200,
            'orders'=>$order,
        ]);
    }

    public function store(Request $request)
    {
       try{ $location=Location::where('user_id',Auth::id())->first();

        $validator=Validator::make($request->all(),[
            'order_items'=>'required',
            'user_id'=>'required',
            'total'=>'required',
            'date_of_deliver'=>'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(),
            ]);
        }

        $order=new Order;

        $order->user_id=Auth::id();
        $order->location_id=$location->id;
        $order->total=$request->total;
        $order->date_of_deliver=$request->date_of_deliver;
        $order->save();

        foreach ($request->order_items as $order_item){
            $item=new Order_Item();
            $item->order_id=$order->id;
            $item->price=$$order_item['price'];
            $item->quantity=$$order_item['quantity'];
            $item->product_id=$$order_item['product_id'];
            $item->save();

            $product=Product::where('product_id',$order_item['product_id'])->first();
            $product->amount-=$order_item['quantity'];
            $product->save();

        }
        return response()->json("Order is added",201);
    }catch(Exception $e){
        return response()->json($e);
}
}

public function get_order_item($id)
{
    $order_items=Order_Item::where('order_id',$id)->get();
    if ($order_items){
        foreach($order_items as $order_item){
            $product=Product::where('id',$order_item->product_id)->pluck('name');
            $order_item->product_name=$product['0'];
        }
        return response()->json($order_item);
    }else return response()->json(" order item not found");
    
}

public function get_user_order($id)
{
    $orders=Order::where('user_id',$id)::with('items',function ($query){
        $query->OrderBy('created_at','desc');
    })->get();

    if ($orders){
        foreach ($orders as $order){
            foreach ($order->items as $order_item){
            $product=Product::where('id',$order_item->product_id)->pluck('name');
            $order_item->product_name=$product['0'];
            }
        }
        return response()->json($order);
    }else return response()->json(" No order found for this user");
}
}
