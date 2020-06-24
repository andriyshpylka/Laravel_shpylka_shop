<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProductsFilterRequest;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Category;
use App\Models\Product;


use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class MainController extends Controller
{
    //
    public function index(ProductsFilterRequest $request){

        $productsQuery = Product::query();
        if ($request->filled('price_from')) {
            $productsQuery->where('price', '>=', $request->price_from);
        }
        if ($request->filled('price_to')) {
            $productsQuery->where('price', '<=', $request->price_to);
        }
        foreach (['new', 'hit', 'recommend'] as $field) {
            if ($request->has($field)) {
                $productsQuery->$field();
            }
        }
        $products = $productsQuery->paginate(6)->withPath("?" . request()->getQueryString());
        return view('index', compact('products'));
    }

    public function product($category_id=null,$product_code){
        $product=Product::withTrashed()->where('code',$product_code)->first();
    	return view('product',compact('product'));
    }

    public function categories(){
        $categories=Category::get();
    	 return view('categories',compact('categories'));
    }

    public function category($code)
    {
        $category = Category::where('code', $code)->first();
        $products = Product::where('category_id', $category->id)->get();
        return view('category', compact('category', 'products'));
    }

    public function subscribe(SubscriptionRequest $request,Product $product){
        Subscription::create([
                'email' => $request->email ,
                'product_id' =>$product->id,
            ]
        );
        return redirect()->back()->with('success','Спасибо, мы сообщим вам при поступлении товара.');
    }

    public function changeLocale($locale){
        session(['locale'=>$locale]);
        App::setLocale($locale);
        return redirect()->back();
    }





}
