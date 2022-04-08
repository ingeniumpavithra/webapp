<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Bill</title>
</head>
<body>
    <h2>New Quote Details</h2>
    <p>Customer Name : <b>{{$details['name']}}</b></p>
    <p>Mobile number : <b>{{$details['mobile']}}</b></p>
    <p>Trip Type : <b>{{$details['type']}}</b></p>
    <h3>Trip Payment : Rs. <b>{{$details['amount']}}</b></h3>
</body>
</html>