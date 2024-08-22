<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">


    <style>
        .form-div {
            text-align: center;
            width: 50%;
            height: 50%;
            margin: auto;
            padding: 50px;
            border: 3px solid #ddd;
        }

        .table {
            text-align: center;
            width: 70%;
            height: 70%;
            margin: auto;
            padding: 50px;
            border: 3px solid #ddd;
        }


        #edit-view {
            text-align: center;
            width: 50%;
            height: 50%;
            margin: auto;
            padding: 50px;
            border: 3px solid #ddd;

        }

        .error {
            color: red;
            font-size: 0.875em;
        }
    </style>

</head>

<body>
    <div>
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
        @if(Session::has('message'))
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

    </div>
    <div class="form-div">
        <form id="login-form" action="{{url('authLogin')}}" method="POST">
            <!-- <form id="login-form" action="" onsubmit="return validateForm()"> -->
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email" required>
                <span class="error"></span>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password" required>
                <span class="error"></span>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <!-- <button type="button" onclick="return submitHandler()" class="btn btn-primary">Submit</button> -->
        </form>
        <div id="forget">
            <a href="/forget">Forget Password || Click here</a>
        </div>
        <div id="json-response"></div>
    </div>
    <div class="table" style="display: none;">
        <table id="ajax-table">

            <thead>
                <tr>
                    <th class="sort">ID</th>
                    <th class="sort">Name</th>
                    <th class="sort">Email</th>
                    <th class="sort">Phone Number</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div id="edit-view" style="display:none;">
    </div>

</body>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script>
    // $(document).ready(() => {
    //     $('#login').submit(function(e) {
    //         e.preventDefault();
    //         const formData = new FormData(this);

    //         $.ajax({
    //             type: 'POST',
    //             url: 'authLogin',
    //             data: formData,
    //             processData: false,
    //             contentType: false,
    //             dataType: 'json',
    //             success: function(response) {
    //                 $('#json-response').text(response.message);
    //                 console.log(1);
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error(xhr.responseText);
    //             }
    //         });
    //     });
    // });


    const submitHandler = () => {
        const email = document.querySelector('#login-form input[name="email"]');
        const password = document.querySelector('#login-form input[name="password"]');
        const errorElements = document.querySelectorAll('.error');
        errorElements.forEach(element => element.textContent = '');
        let isValid = true;
        if (!email.value) {
            isValid = false;
            email.nextElementSibling.textContent = 'Email is required.';
        } else if (!/\S+@\S+\.\S+/.test(email.value)) {
            isValid = false;
            email.nextElementSibling.textContent = 'Invalid email format.';
        }

        if (!password.value) {
            isValid = false;
            password.nextElementSibling.textContent = 'Password is required.';
        }

        if (!isValid) {
            return false;
        }

        $.ajax({
            url: '{{url("ajaxLogin")}}',
            data: $("#login-form").serialize(),
            type: "POST",
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            success: function(data) {
                alert("okay");
                console.log(data);
                document.getElementById('login-form').style.display = 'none';
                document.getElementById('forget').style.display = 'none';
                $('#ajax-table').show();

                const tableBody = document.querySelector('#ajax-table tbody');
                tableBody.innerHTML = '';

                data.forEach(item => {
                    const row = document.createElement('tr');
                    Object.values(item).forEach(value => {
                        const cell = document.createElement('td');
                        cell.textContent = value;
                        row.appendChild(cell);
                    });
                    tableBody.appendChild(row);
                });
                $('#ajax-table').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    lengthChange: true,
                    pageLength: 10,
                    data: data,
                    columns: [{
                            data: 'id'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'email'
                        },
                        {
                            data: 'phone'
                        },
                        {
                            data: null,
                            defaultContent: '<button class="edit-btn">Edit</button> <button class="delete-btn">Delete</button>',
                            orderable: false
                        }
                    ]
                });
            },

            error: function() {
                alert("failure From php side!!! ");
            }

        });

        return true;
    }
    $('#ajax-table').on('click', '.delete-btn', function() {
        const data = $('#ajax-table').DataTable().row($(this).parents('tr')).data();
        if (confirm('Are you sure you want to delete ID: ' + data.id + '?')) {
            $.ajax({
                url: '{{ url("deleteUser") }}/' + data.id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function() {
                    $('#ajax-table').DataTable().ajax.reload();
                    alert("after delete");
                },
                error: function() {
                    alert('Failed to delete user.');
                }
            });
        } else {
            console.log("Ok button not clicked ");
        }
    });
    $('#ajax-table').on('click', '.edit-btn', function() {
        const data = $('#ajax-table').DataTable().row($(this).parents('tr')).data();
        if (confirm('You want Edit the ' + data.name + ' with id ' + data.id + ' ? ')) {
            $.ajax({
                url: '{{ route("user.edit", ":id") }}'.replace(':id', data.id),
                type: 'get',
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function(response) {
                    $('.table').hide();
                    $('#edit-view').show();
                    $('#edit-view').html(response.html);
                },
                error: function() {
                    alert('Failed to delete user.');
                }
            });
        } else {
            console.log("ok not edit");
        }
    });

    function updateForm() {
        console.log("from update form");
        var name = document.getElementById("name").value;
        var id = document.getElementById("id").value;
        var email = document.getElementById("email").value;
        var phone = document.getElementById("phoneNumber").value;

        console.log(name, id, email, phone);
        $.ajax({
            data: {
                'id': id,
                'name': name,
                'email': email,
                'phone': phone
            },
            url: '{{ route("user.update", ":id") }}'.replace(':id', id),
            type: 'PUT',
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Success:', response);
                top.location.href = "user";
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
        return false;
    }
</script>


</html>