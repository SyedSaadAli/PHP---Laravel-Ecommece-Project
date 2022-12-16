<!DOCTYPE html>
<html>
    <head>
    @include('home.head')
    </head>
   <body>
      <div class="hero_area">
         <!-- header section strats -->
        @include('home.header')

         <!-- end header section -->

      <!-- product section -->
      <section class="product_section layout_padding">
        <div class="container">
           <div class="heading_container heading_center">
              <h2>
                 Our <span>products</span>
              </h2>
           </div>
           @if (session()->has('message'))

           <div class="alert alert-success">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                   <h2> {{session('message')}} </h2>
           </div>
               @endif
           <div>
            <form action="{{url('product_search1')}}" method="get">
                @csrf
               <center> <input style="width:500px; " type="text" name="search" placeholder="Search for something"></center>
                <input type="submit" value="search">
            </form>
           </div>
           <div class="row">
          @foreach ($product as $products)

              <div class="col-sm-6 col-md-4 col-lg-4">
                 <div class="box">
                    <div class="option_container">
                       <div class="options">
                        <a href="{{url('/product_details',$products->id)}}" class="option1">
                            Product Details
                            </a>
                         <form action="{{url('/add_cart',$products->id)}}" method="post">
                          @csrf
                          <div class="row">
                            <div class="col-md-4">
                                <input type="number" name="quantity" value="1" min="1" style="width: 100px">
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Add To Cart">
                            </div>

                        </div>
                         </form>
                       </div>
                    </div>
                    <div class="img-box">
                       <img src="/product/{{$products->image}}" alt="">
                    </div>
                    <div class="detail-box">
                       <h5>
                         {{$products->title}}
                       </h5>
                       @if($products->discount_price!=null)

                       <h6 style="color:red;">
                        Discount Price
                        <br>
                        ${{$products->discount_price}}
                       </h6>
                       <h6 style="text-decoration: line-through; color:blue;">
                        Price
                        <br>
                        ${{$products->price}}
                       </h6>
                       @else
                       <h6 style="color:blue;">
                        Price
                        <br>
                        ${{$products->price}}
                       </h6>
                       @endif

                    </div>
                 </div>
              </div>

           @endforeach
        </div>
        <br>
           <span style="padding-top: 20px;">
            {!!$product->withQueryString()->links('pagination::bootstrap-5')!!}
           </span>

     </section>

      <!-- end product section -->


      <!-- footer start -->
      @include('home.footer')
      <!-- footer end -->
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>

            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

         </p>
      </div>
      <!-- script start -->
      @include('home.script')
       <!-- script end -->
   </body>
</html>
