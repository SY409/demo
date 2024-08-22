<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div>
        @if(Session::has('error'))
        <div class="w3-panel w3-red" role="alert">
            {{ Session::get('error') }}
        </div>
        @endif
        @if(Session::has('success'))
        <div class="w3-panel w3-green" role="alert">
            {{ Session::get('success') }}
        </div>
        @endif

    </div>
    <form action="{{url('forget-password')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter Your Email ID">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div>
        <a href="/login">For Login || Click Here</a>
    </div>
</body>

</html>