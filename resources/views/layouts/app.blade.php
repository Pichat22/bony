<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

@include('header')
@include('nav')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('sidebar')
        </div>
        <div class="col-md-9">
        @yield('content')
        </div>
    </div>
</div>

</body>
</html>

