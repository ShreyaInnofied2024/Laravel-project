<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #d4edda; /* Light green background for success */
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
            background-color: #28a745; /* Bootstrap success color */
            color: #fff;
            font-size: 1.8rem;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }
        .btn-back {
            margin-top: 20px;
            width: 100%;
        }
        .success-icon {
            font-size: 3rem;
            color: #28a745;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-header">
            Payment Successful
        </div>
        <div class="card-body">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <p class="text-muted">Your payment was successful, and a confirmation email has been sent to your registered email address.</p>
            <a href="{{route('home')}}" class="btn btn-outline-success btn-back">
                Back to Home
            </a>
        </div>
    </div>
</div>

<!-- Font Awesome for Icons -->
<script src="https://kit.fontawesome.com/155c5ab2ca.js" crossorigin="anonymous"></script>

</body>
</html>