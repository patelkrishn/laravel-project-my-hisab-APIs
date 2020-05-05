<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print invoice | Asatine Store</title>
    <style type="text/css">
        table {
border-collapse: collapse;
margin-bottom: 10px;

}
tr{
height: 22px;
}
.single{
text-align: left;
}
    </style>
</head>
<body>
    <table border="1" style="width: 100%">
        <thead>
            <th>Product name</th>
            <th>Product price</th>
            <th>Quantity</th>
            <th>Total</th>
        </thead>
        <tbody>
            @foreach ($invoices as $item)
              <tr>
                <td>{{$item->product_name}}</td>
                <td>{{$item->product_price}}</td>
                <td>{{$item->invoice_quantity}}</td>
                <td>{{$item->total_amount}}</td>
            </tr>  
            @endforeach
            
        </tbody>
    </table>
</body>
</html>