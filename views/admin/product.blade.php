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
        border: 3px solid green;

    }
    label{
        display: inline-block;
        width: 200px;
    }
    .div_design{
        padding-bottom: 15px;
    }
    .text_color{
        color:black;
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
<div class="div_center ">
    <h2 class="h2font"> Add Product</h2>

    <form action="{{url('/add_product')}}" method='post' enctype='multipart/form-data'>
        @csrf
        <div class='div_design'>
        <label>Product Title : </label>
        <input class="input input_color" type="text" name="Name" placeholder="Product Name" required>
        </div>
<br>
        <div class='div_design'>
            <label>Product Description : </label>
            <input class="input input_color" type="text" name="Description" placeholder="Product Description" required>
            </div>
<br>
<div class='div_design'>
    <label>Product Quantity : </label>
    <input class="input input_color" type="number" name="Quantity" placeholder="Product Quantity" required>
    </div>
<br>
        <div class='div_design'>
                <label>Product Price : </label>
                <input class="input input_color" type="number" name="Price" placeholder="Product Price" required>
                </div>
 <br>

        <div class='div_design'>
        <label>Discounted Price : </label>
        <input class="input input_color" type="text" name="DP" placeholder="Product Discounted Price" required>
        </div>

<br>
        <div class='div_design'>
        <label>Product Category : </label>
       <select class="text_color" name="Category"  required>
        <option value="" selected="">Add a Category here</option>
        @foreach ($category as $category)
        <option class="input_color">{{$category->category_name}}</option>
        @endforeach

       </select>
        </div>
 <br>
        <div class='div_design'>
        <label>Product Image : </label>
            <input type="file" name="image" >
            </div>
     <br>
        <input class="btn btn-primary input_color" type="submit" name="submit" value="Add Product">
    </form>

</div>

        </div>
    </div>

    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>


