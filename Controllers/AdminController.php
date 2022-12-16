<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Order;
use App\Models\Category;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\SendEmailNotification;
use RealRashid\SweetAlert\Facades\Alert;
use Notification;

class AdminController extends Controller
{
   public function view_category(){
    // $data = category::all();
    $data = DB::table('categories')->get();

    return view('admin.category',['data'=>$data]);

   }

   public function add_category(Request $req){

    $data = new Category;
    $data->category_name = $req->category;
    $data->save();
    session()->flash('message','New Category Is Added Successfully !');
    // return redirect('category');
    //  return redirect()->back()->with('message','New Category Is Added Successfully !');
     return redirect()->back();
   }

   public function delete_category($id){

    Category::where('id', $id)->delete();

    session()->flash('message','Category DELETED Successfully !');
    return redirect()->back();
   }

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------

public function view_product(){
    $data = Category::all();
    // $data = DB::table('categories')->get();

    return view('admin.product',['category'=>$data]);

   }

   public function add_product(Request $req){

    $product = new products;
    $product->title = $req->Name;
    $product->description = $req->Description;

    $product->category = $req->Category;
    $product->quantity = $req->Quantity;
    $product->price = $req->Price;
    $product->discount_price = $req->DP;

    $image = $req->image;

    $imagename = time().'.'.$image->getClientOriginalExtension();
    $req->image->move('product',$imagename);

    $product->image = $imagename;

    $product->save();
    session()->flash('message','New Product Is Added Successfully !');
    // return redirect('category');
    //  return redirect()->back()->with('message','New Category Is Added Successfully !');
     return redirect()->back();
   }

   public function show_product(){
    $product = products::all();
    // $data = DB::table('categories')->get();

    return view('admin.show_product',['product'=>$product]);

   }


   public function delete_product($id){

    products::where('id', $id)->delete();

    session()->flash('message','Product DELETED Successfully !');
    return redirect()->back();
   }

   public function edit_product($id){
    $category = Category::all();
    $product = products::find($id);

     return view('admin.edit_product',['product'=>$product,'category'=>$category]);
   }

   public function edit_product_confirm(Request $req ,$id){

    $product = products::find($id);
    $product->title = $req->Edit_Name;
    $product->description = $req->Edit_Description;

    $product->category = $req->Edit_Category;
    $product->quantity = $req->Edit_Quantity;
    $product->price = $req->Edit_Price;
    $product->discount_price = $req->Edit_DP;

    $image = $req->Edit_image;
if($image){
    $imagename = time().'.'.$image->getClientOriginalExtension();

    $req->Edit_image->move('product',$imagename);

    $product->image = $imagename;
}
    $product->save();
    session()->flash('message','Product Is Updated Successfully !');
    // return redirect('category');
    //  return redirect()->back()->with('message','New Category Is Added Successfully !');
    return redirect('show_product');
   }




//--------------------------------------------------------------------------------------------------------------------------------------------------------------------


public function order(){
    $order = Order::all();

    return view('admin.order',['order'=>$order]);

   }



public function Delivered($id){

    $order = Order::find($id);
    $order->delivery_status = 'Delivered';
    $order->payment_status = 'Paid';

    $order->save();
    session()->flash('message',$order->product_title.' Is Delivered Successfully !');
    // return redirect('category');
    //  return redirect()->back()->with('message','New Category Is Added Successfully !');
    return back();
   }


   public function print_pdf($id){

    $order = Order::find($id);
    $pdf = PDF::loadView('admin.pdf',['order'=>$order]);

    return $pdf->download('order_details.pdf');
   }


   //--------------------------------------------------------------------------------------------------------------------------------------------------------------------


   public function send_email($id){

    $order = Order::find($id);
    return view('admin.email_info',['order'=>$order]);
   }

   public function send_user_email(Request $req, $id){

    $order = Order::find($id);

    $details=[
     'Email_Greeting' => $req->Email_Greeting,
     'Email_FirstLine' => $req->Email_FirstLine,
     'Email_Body' => $req->Email_Body,
     'Email_ButtonName' => $req->Email_ButtonName,
     'Email_Url' => $req->Email_Url,
     'Email_LastLine' => $req->Email_LastLine,

    ];

    Notification::send($order, new SendEmailNotification($details));

    return back();
   }

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------

public function searchdata(Request $req){

    $searchText = $req->search;

    $order = order::where('name','LIKE',"%$searchText%")
    ->orWhere('phone','LIKE',"%$searchText%")
    ->orWhere('email','LIKE',"%$searchText%")
    ->orWhere('address','LIKE',"%$searchText%")
    ->orWhere('product_title','LIKE',"%$searchText%")
    ->orWhere('price','LIKE',"%$searchText%")
    ->orWhere('payment_status','LIKE',"%$searchText%")
    ->orWhere('delivery_status','LIKE',"%$searchText%")->get();


    return view('admin.order',['order'=>$order]);
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------


}
