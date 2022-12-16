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
    <h2 class="h2font"> All Orders</h2>
<div style="margin: auto; padding-bottom: 30px;">
    <form action="{{url('/search')}}" method="post">
        @csrf
        <input class="input_color" type="text" name="search" placeholder="Search For Something">
        <input type="submit" value="Search" class="btn btn-outline-primary">
    </form>
</div>
    <table class='center'>
        <tr class="th_color">
            <td class="th_design">Name</td>
            <td class="th_design">Email</td>
            <td class="th_design">Address</td>
            <td class="th_design">Phone</td>
            <td class="th_design">Title</td>
            <td class="th_design">Quantity</td>
            <td class="th_design">Price</td>
            <td class="th_design">Payment</td>
            <td class="th_design">Delivery</td>
            <td class="th_design">Image</td>
            <td class="th_design">Delivered</td>
            <td class="th_design">Print PDF</td>
            <td class="th_design">Send Email</td>


        </tr>



        @forelse ($order as $order)
        <tr>
            <td>{{$order->name}}</td>
            <td>{{$order->email}}</td>
            <td>{{$order->address}}</td>
            <td>{{$order->phone}}</td>
            <td>{{$order->product_title}}</td>
            <td>{{$order->quantity}}</td>
            <td>{{$order->price}}</td>
            <td>{{$order->payment_status}}</td>
            <td>{{$order->delivery_status}}</td>

            <td><img class="image_size" src="/product/{{$order->image}}"></td>
            @if ($order->delivery_status=='processing')
            <td><a class="btn btn-primary" onclick="return confirm('Are you sure this Product is Delivered ..!')" href="{{url('/Delivered',$order->id)}}">Delivered</a></td>

            @else

            <td><p style="color:green;">Delivered</p></td>


            @endif
            <td><a class="btn btn-secondary" href="{{url('/print_pdf',$order->id)}}">Print PDF</a></td>
            <td><a class="btn btn-info" href="{{url('/send_email',$order->id)}}">Email</a></td>


        </tr>
        @empty
           <tr>
               <td colspan="16">No Data Found</td>
            </tr>
        @endforelse
    </table>
</div>

        </div>
    </div>


    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>
