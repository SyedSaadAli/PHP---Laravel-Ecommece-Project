<?php

namespace App\Http\Controllers;


use Stripe;
use Session;
use App\Models\Cart;
use App\Models\User;

use App\Models\Order;
use App\Models\reply;
use App\Models\comment;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
// use Illuminate\Support\Facades\Session;

class Homecontroller extends Controller
{

    public function redirect(){
        $usertype=Auth::user()->usertype;

        if($usertype=='1'){
         $totalorder = Order::all()->count();
         $order = Order::all();
         $totalproducts = products::all()->count();
         $totaluser = User::where('usertype','0')->count();
         $order_delivered = Order::where('delivery_status','Delivered')->count();
         $order_processing = Order::where('delivery_status','processing')->count();

        $totalrevenue=0;

        foreach($order as $order){
            $totalrevenue = $totalrevenue + $order->price;

        }

         return view('admin.home',['totalorder'=>$totalorder,
         'totalproducts'=>$totalproducts,
         'totalrevenue'=>$totalrevenue,
         'totaluser'=>$totaluser,
         'order_delivered'=>$order_delivered,
         'order_processing'=>$order_processing,
         ]);
        }
        else{
         $product=products::paginate(3);
         return view('home.userpage',['product'=>$product]);
        }
     }



//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------



    function index(){
        $product=products::paginate(3);
        $comment=comment::orderby('id','desc')->get();
        $reply=reply::all();
        return view('home.userpage',['product'=>$product,'comment'=>$comment,'reply'=>$reply]);
    }
    function product_details($id){
        $comment=comment::orderby('id','desc')->get();
        $reply=reply::all();
        $product=products::find($id);
        return view('home.product_details',['product'=>$product,'comment'=>$comment,'reply'=>$reply]);
    }

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


    function add_cart(Request $req, $id){
        if(Auth::id()){
          $user=Auth::user();
          $product=products::find($id);

          $cart=new Cart;

          $cart=new Cart;
          $cart1 = Cart::where('Product_id',$product->id)->where('User_id',$user->id)->get('id')->first();

          if($cart1){
            $cart2=Cart::find($cart1)->first();
            // echo $cart2->quantity ;
            $cart2->quantity =  $cart2->quantity + $req->quantity;
            // echo $cart2->quantity ;
            if($product->discount_price!=null){
            $cart2->price =  $cart2->quantity * $product->discount_price;
            }else{
                $cart2->price =  $cart2->quantity * $product->price;
            }
            $cart2->save();
            // session()->flash('message','Your Product is ADDED to cart successfully !');
            Alert::Success('Product Added Successfully','We have added product successfully');
            return redirect()->back();
          }else{



          $cart->name=$user->name;
          $cart->email=$user->email;
          $cart->phone=$user->phone;
          $cart->address=$user->address;
          $cart->product_title=$product->title;
          if($product->discount_price!=null){
            $cart->price=$product->discount_price * $req->quantity;
          }else{
            $cart->price=$product->price * $req->quantity;
          }

          $cart->quantity=$req->quantity;
          $cart->image=$product->image;
          $cart->Product_id=$product->id;
          $cart->User_id=$user->id;

          $cart->save();
        //   session()->flash('message','Your Product is ADDED to cart successfully !');
        Alert::Success('Product Added Successfully','We have added product successfully');
          return redirect()->back();
          }

        }
        else{
            return redirect('login');
        }
        // $product=products::find($id);
        // return view('home.product_details',['product'=>$product]);
    }



//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------



    public function show_cart(){
        if(Auth::id()){
            $id=Auth::user()->id;
            $cart = Cart::where('user_id',$id)->get();
            return view('home.show_cart',['cart'=>$cart]);
        }else{
            return view('login');
        }
    }

    public function remove_product($id){

        Cart::where('id', $id)->delete();

        Alert::Success('Product Removed Successfully','We have removed product from the cart');
        return redirect()->back();
       }



//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function cash_order(){
        $user = Auth::user();
        $userid = $user->id;
        $data = Cart::where('User_id',$userid)->get();

        foreach($data as $data){
            $order = new Order;

            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->User_id;
            $order->product_title = $data->product_title;
            $order->price = $data->price;
            $order->quantity = $data->quantity;
            $order->image = $data->image;
            $order->product_id = $data->Product_id;
            $order->payment_status = 'Cash on delivery';
            $order->delivery_status = 'processing';

            $order->save();

            $cart_id = $data->id;

            Cart::where('id', $cart_id)->delete();

        }
        // session()->flash('message','We have Received your Order. We will connect with you soon...');
        Alert::Success('We have Received your Order','We will connect with you soon...');
        return redirect()->back();
    }


//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


    public function stripe($totalprice){
        return view('home.stripe',['totalprice'=>$totalprice]);
    }

    public function stripePost(Request $request,$totalprice)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([
                "amount" => $totalprice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thanks for payment."
        ]);

        $user = Auth::user();
        $userid = $user->id;
        $data = Cart::where('User_id',$userid)->get();

        foreach($data as $data){
            $order = new Order;

            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->User_id;
            $order->product_title = $data->product_title;
            $order->price = $data->price;
            $order->quantity = $data->quantity;
            $order->image = $data->image;
            $order->product_id = $data->Product_id;
            $order->payment_status = 'Paid';
            $order->delivery_status = 'processing';

            $order->save();

            $cart_id = $data->id;

            Cart::where('id', $cart_id)->delete();
        }
        Session::flash('success', 'Payment successful!');

        return back();
    }


//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function show_order(){
        if(Auth::id()){
            $id=Auth::user()->id;
            $order = Order::where('user_id',$id)->get();
            return view('home.show_order',['order'=>$order]);
        }else{
            return view('login');
        }
    }




//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

public function cancel_order($id){
   $order = Order::find($id);
   $order->delivery_status="Your order is cancelled.";
   $order->save();
   Alert::Warning('Order Cancelled','You have cancelled your order...');
   return back();
}


//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


public function product_search(Request $req){
    $comment=comment::orderby('id','desc')->get();
    $reply=reply::all();
    $searchText = $req->search;

    $product = products::where('title','LIKE',"%$searchText%")
    ->orWhere('description','LIKE',"%$searchText%")
    ->orWhere('category','LIKE',"%$searchText%")
    ->orWhere('price','LIKE',"%$searchText%")->paginate(3);
    return view('home.userpage',['product'=>$product,'comment'=>$comment,'reply'=>$reply]);
 }

 public function product_search1(Request $req){
    $comment=comment::orderby('id','desc')->get();
    $reply=reply::all();
    $searchText = $req->search;

    $product = products::where('title','LIKE',"%$searchText%")
    ->orWhere('description','LIKE',"%$searchText%")
    ->orWhere('category','LIKE',"%$searchText%")
    ->orWhere('price','LIKE',"%$searchText%")->paginate(3);
    return view('home.All_products',['product'=>$product,'comment'=>$comment,'reply'=>$reply]);
 }



//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------



public function products(){
    if(Auth::id()){
        $id=Auth::user()->id;
        $product=products::paginate(12);
        $comment=comment::orderby('id','desc')->get();
        $reply=reply::all();

         return view('home.All_products',['product'=>$product,'comment'=>$comment,'reply'=>$reply]);
    }else{
        return view('login');
    }
}



//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

public function add_comment(Request $req){
    if(Auth::id()){
        $comment=new comment;
        $comment->name=Auth::user()->name;
        $comment->user_id=Auth::user()->id;
        $comment->comment=$req->comment;
        $comment->save();

         return back();
    }else{
        return view('login');
    }
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

public function add_reply_comment(Request $req){
    if(Auth::id()){
        $reply=new reply;
        $reply->name=Auth::user()->name;
        $reply->user_id=Auth::user()->id;
        $reply->comment=$req->commentId;
        $reply->reply=$req->reply;
        $reply->save();

         return back();
    }else{
        return view('login');
    }
}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------




}
