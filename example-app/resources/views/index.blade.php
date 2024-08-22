<!DOCTYPE html>
<html lang="en">

<head>
    <title>Index</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        .data-table {
            margin: auto;
            width: 50%;
            padding-top: 80px;
            border: 3px solid #ddd;
        }
    </style>

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

    <div class="data-table">
        <table class="table table-hover">
            <thead>
                <a href="user/create"> Add user</a>

                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col" colspan="2">Action</th>

                </tr>
            </thead>
            <tbody>
                @php
                $user = $user ?? [];
                @endphp

                @if(count($user) > 0)
                @foreach($user as $user)
                <tr>
                    <th></th>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <!-- <td><button type="button" class="btn btn-warning">Edit</button></td> -->
                    <td><a href="{{ route('user.edit', $user->id) }}">Edit</a></td>
                    <td>
                        <form action="{{ route('user.destroy',$user->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger">DELETE</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="4">
                        <div>
                            <h1>Index is empty</h1>
                        </div>
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>

</body>

</html>