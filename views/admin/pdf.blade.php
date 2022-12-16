<h1 style="text-align: center;">Order Details</h1>
<br>
<h3>Customer Name :</h3>  <h4>{{$order->name}}</h4>
<h3>Customer Email :</h3>  <h4>{{$order->email}}</h4>
<h3>Customer Phone :</h3>  <h4>{{$order->phone}}</h4>
<h3>Customer Address :</h3>  <h4>{{$order->address}}</h4>
<h3>Customer ID :</h3>  <h4>{{$order->user_id}}</h4>

<h3>Product Name :</h3>  <h4>{{$order->product_title}}</h4>
<h3>Product Price :</h3>  <h4>{{$order->price}}</h4>
<h3>Product Quantity :</h3>  <h4>{{$order->quantity}}</h4>
<h3>Payment Status :</h3>  <h4>{{$order->payment_status}}</h4>
<h3>Delivery Status :</h3>  <h4>{{$order->delivery_status}}</h4>
<h3>Product Id :</h3>  <h4>{{$order->product_id}}</h4>
<h3>Product Image :</h3>
<img height="250" width="450" src="product/{{$order->image}}">
