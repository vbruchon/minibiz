<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome to MiniBiz</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #f0f4f8;
            color: #333;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 20px;
            top: 20px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 64px;
            margin-bottom: 30px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 20px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="top-right links">
            <a href="#">Login</a>
            <a href="#">Register</a>
        </div>

        <div class="content">
            <div class="title m-b-md">
                Welcome to MiniBiz
            </div>

            <div class="links">
                <a href="#">Dashboard</a>
                <a href="{{ route('customers.index') }}">Customers</a>
                <a href="#">Products</a>
                <a href="#">Orders</a>
                <a href="#">Reports</a>
            </div>
        </div>
    </div>
</body>

</html>