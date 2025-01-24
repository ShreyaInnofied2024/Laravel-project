@include('inc.header')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8d7da; /* Light red background */
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 10%;
            text-align: center;
        }
        .card {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            background-color: #fff;
        }
        .card-header {
            background-color: #dc3545; /* Bootstrap danger color */
            color: #fff;
            font-size: 1.8rem;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }
        .btn-back {
            margin-top: 20px;
            width: 100%;
        }
    </style>
</head>
<body>
    

<div class="container">
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-header">
            Payment Cancelled
        </div>
        <div class="card-body">
            <p class="text-muted">Your payment was cancelled. You can return to your cart to try again.</p>
            <a href="{{route('home')}}" class="btn btn-outline-danger btn-back">
                Back to Home
            </a>
        </div>
    </div>
</div>

</body>
</html>