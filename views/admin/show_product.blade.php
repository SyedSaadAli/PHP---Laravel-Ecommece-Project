<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin.css')

    <style type='text/css'>
    .div_center{
        text-align: center;
        padding-top: 40px;
    }
    .h2font
    {
        font-size: 40px;
        padding-bottom: 40px;
    }
    .input_color{
      color:black;
    }
    .center{
        margin: auto;
        width: 50%;
        text-align: center;
        margin-top: 30px;
        border: 3px solid whitesmoke;

    }
    .image_size{
        width:250px;
        height:100px;
    }
    .th_color{
         background:skyblue;
    }
    .th_design{
      padding: 30px;
    }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      @include('admin.header')

      <div class="main-panel">
        <div class="content-wrapper">
            @if (session()->has('message'))

            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                    <h2> {{session('message')}} </h2>
            </div>
                @endif
<div class="div_center">
    <h2 class="h2font"> Products</h2>

    <table class='center'>
        <tr class="th_color">
            <td class="th_design">Title</td>
            <td class="th_design">Description</td>
            <td class="th_design">Quantity</td>
            <td class="th_design">Category</td>
            <td class="th_design">Price</td>
            <td class="th_design">Discount Price</td>
            <td class="th_design">Image</td>
            <td>DELETE</td>
            <td>EDIT</td>

        </tr>
        @foreach ($product as $product)
        <tr>
            <td>{{$product->title}}</td>
            <td>{{$product->description}}</td>
            <td>{{$product->quantity}}</td>
            <td>{{$product->category}}</td>
            <td>{{$product->price}}</td>
            <td>{{$product->discount_price}}</td>
            <td><img class="image_size" src="/product/{{$product->image}}"></td>
            <td><a onclick="return confirm('Are you sure you want to DELETE this product')" class="btn btn-danger" href="{{url('/delete_product',$product->id)}}">Delete</a></td>
            <td><a onclick="return confirm('Are you sure you want to EDIT this product')" class="btn btn-success" href="{{url('/edit_product',$product->id)}}">Edit</a></td>
        </tr>
        @endforeach
    </table>
</div>

        </div>
    </div>


    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>
