<?php


namespace App\Http\Controllers;


use App\Classes\Basket;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BasketController extends Controller
{

    public function basket()
    {
        $order=(new Basket())->getOrder();

        return view('basket',compact('order'));
    }
       public function basketConfirm(Request $request){

            $email=Auth::check() ? Auth::user()->email : $request->email;
           $success=(new Basket())->SaveOrder($request->name,$request->phone, $email);
            if($success){
                session()->flash('success','Ваш заказ принят в обработку!');
            }
            else{
                session()->flash('warning','Товар не доступен для заказа в полном обьеме');
            }
            Order::eraseOrdersSum();


        return redirect()->route('index');
     }

    public function basketPlace()
    {
        $basket=new Basket();
        $order=$basket->getOrder();
         if(!$basket->countAvailable()){
             session()->flash('warning','Товар не доступен для заказа в полном обьеме');
             return redirect()->route('basket');
         }
        return view('order',compact('order'));
    }

    public function basketAdd( $productId)
    {
        $product=Product::find($productId);
        $result=(new Basket(true))->addProduct($product);
        if($result){
            session()->flash('success','Добавлен товар '.$product->name);
        }
        else{
            session()->flash('warning','Товар '.$product->name.' в большем количестве не доступен,для заказа');
        }

        return redirect()->route('basket');
    }

    public function basketRemove($productId){
        $product=Product::find($productId);
        (new Basket())->removeProduct($product);

        session()->flash('warning','Удален товар '.$product->name);
        return redirect()->route('basket');
     }



}
