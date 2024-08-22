<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
    @if(Session::has('error'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
    </div>
    @endif
    @if(Session::has('success'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div id="edit-form">
        <form id="edit-form" action="{{ route('user.update', $data->id) }}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="id" value="{{ old('id', $data->id) }}">

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" maxlength="30" value="{{ old('name', $data->name) }}" placeholder="Enter Your Name" required>
                <span id="name-error" class="text-danger"></span>
            </div>

            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $data->email) }}" maxlength="30" placeholder="Enter email" required>
                <span id="email-error" class="text-danger"></span>
            </div>

            <div class="form-group">
                <label for="phoneNumber">Phone</label>
                <input type="tel" class="form-control" id="phoneNumber" name="phone" value="{{ old('phone', $data->phone) }}" placeholder="Enter phone number" maxlength="10" title="Please enter a 10-digit phone number" required>
                <span id="phone-error" class="text-danger"></span>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>


</body>

</html>