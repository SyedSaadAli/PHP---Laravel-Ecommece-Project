<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/public">
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
        font-size: 15px;
        font-weight: bold;
    }
    .div_design{
        padding-bottom: 15px;
    }
    .text_color{
        color:black;
    }
    .pading{
        /* padding-left: 35%; */
        padding-top: 30px;
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
    <h2 class="h2font"> Send Email To : {{$order->email}}</h2>

    <form action="{{url('/send_user_email',$order->id)}}" method='post' >
        @csrf
        <div class='div_design pading'>
        <label>Email Greeting : </label>
        <input class="input input_color" type="text" name="Email_Greeting" placeholder="Email Greeting" >
        </div>
<br>
        <div class='div_design pading'>
            <label>Email First Line : </label>
            <input class="input input_color" type="text" name="Email_FirstLine" placeholder="Email First Line" >
            </div>
<br>
<div class='div_design pading'>
    <label>Email Body : </label>
    <textarea class="input input_color" aria-colspan="6" name="Email_Body" placeholder="Email Body"></textarea>

    </div>
<br>
        <div class='div_design pading'>
                <label>Email Button Name : </label>
                <input class="input input_color" type="text" name="Email_ButtonName" placeholder="Email Button Name" required>
                </div>
 <br>

        <div class='div_design pading' >
        <label>Email Url : </label>
        <input class="input input_color" type="text" name="Email_Url" placeholder="Email Url" required>
        </div>

<br>
<div class='div_design pading'>
    <label>Email Last Line : </label>
    <input class="input input_color" type="text" name="Email_LastLine" placeholder="Email Last Line" required>
    </div>

<br>

        <input class="btn btn-primary input_color" type="submit" name="submit" value="Send Email">
    </form>

</div>

        </div>
    </div>

    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>


