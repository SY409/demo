<!DOCTYPE html>
<html lang="en">

<head>
    <title>Registration</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .form-div {
            text-align: center;
            width: 50%;
            height: 50%;
            margin: auto;
            padding: 50px;
            border: 3px solid #ddd;
        }

        .danger {
            color: red;
            font-size: 0.875em;
        }

        .loader {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }

        .loader img {
            width: 50px;
            height: 50px;
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
        <form action="{{ route('user.store') }}" name="myForm" onsubmit="return validateForm()" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" maxlength="30" placeholder="Enter Your Name" required>
                <span id="username" class="danger"></span>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" maxlength="30" placeholder="Enter email" required>
                <span id="email" class="danger"></span>
            </div>
            <div class="form-group">
                <label for="phoneNumber">Phone</label>
                <input type="tel" class="form-control" id="phoneNumber" name="phone" placeholder="Enter phone number" maxlength="10" title="Please enter a 10-digit phone number" required>
                <span id="phone" class="danger"></span>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" maxlength="15" minlength="10" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label for="confpassword">Confirm Password</label>
                <input type="password" class="form-control" id="confpassword" maxlength="15" minlength="10" name="cnfpassword" placeholder="Confirm Password" required>
            </div>
            <div>
                <span id="pass" class="danger"></span>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div>
            <a href="/login">Already Registered || Click here to login</a>
        </div>
    </div>
    <div id="loader" class="loader">
        <img src="https://i.giphy.com/media/v1.Y2lkPTc5MGI3NjExbXV5a3Q0cWE1a2xpbWdkc2hibTJ4NGs2MmN3d3Y5aTI5Nzk3ejZ4bSZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/RgzryV9nRCMHPVVXPV/giphy.gif" alt="Loading...">
    </div>

    <script>
        document.getElementById('name').onkeyup = function() {
            document.getElementById('username').innerText = "Characters: " + this.value.length + "/30";
        }
        document.getElementById('exampleInputEmail1').onkeyup = function() {
            document.getElementById('email').innerText = "Characters: " + this.value.length + "/30";
        }
        document.getElementById('phoneNumber').onkeyup = function() {
            document.getElementById('phone').innerText = "Characters: " + this.value.length + "/10";
        }

        function validateForm() {
            const phone = document.getElementById("phoneNumber").value;
            const password1 = document.getElementById('exampleInputPassword1').value;
            const password2 = document.getElementById('confpassword').value;
            console.log(password1, password2);
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{7,}$/;


            let phoneText = "";
            if (!/^\d{10}$/.test(phone)) {
                phoneText = "Phone number must be Numbers of 10 digits.";
                document.getElementById("phone").innerText = phoneText;
                return false;
            } else {
                document.getElementById("phone").innerText = "";
            }
            if (password1 !== password2) {
                document.getElementById('pass').innerText = "Passwords do not match.";
                return false;
            }
            if (!passwordRegex.test(password1)) {
                document.getElementById('pass').innerText = "Password must be at least 7 characters long and include at least one uppercase letter, one lowercase letter, one digit, and one special character.";
                return false;
            }
            document.getElementById('loader').style.display = 'block';
            setTimeout(() => {
                document.getElementById('registrationForm').submit();
            }, 5000);
            return true;
        }
    </script>
</body>

</html>