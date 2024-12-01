<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous">
    </script>
    <title>Login Page</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 5%;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            background-image: url('images/background.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .container {
            width: 700px;
            max-width: 800px;
            border: 1px solid #ccc;
            border-radius: 15px;
            padding: 30px;
            background-color: #fff;
            text-align: center;
        }

        .form-group {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .form-group label {
            width: 20%;
            text-align: left;
            margin-right: 10px;
        }

        .form-group input {
            width: 80%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: left;
        }

        img {
            width: 50%;
            height: auto;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <img src="images/logo.jpg" alt="Jobsafer">
        <h1>Login Now</h1>
        <br>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter Your Username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="Password" required>
        </div>
        
        <div class="form-group">
            <label for="password">User Type</label>
            <select name="" id="usertype">
                <option value="student">Student</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        


        <button onclick="login()" class="login-button px-4 btn btn-primary" style="border-radius: 25px; font-size: 18px; height: 50px; width: 250px;">Login</button> <br><br>
        <p>Don't Have Account,<a href="register.php"> Register </a>here</p>
        <h1 id="message"></h1>
    </div>

</body>
<script>
    function login() {


        if (username.value != "" && password.value != "") {
            $.ajax({
                url: "get_response.php",
                type: "post",
                data: {
                    "RES_TYPE": "LOGIN",
                    "USERNAME": username.value,
                    "PASSWORD": password.value,
                    "USERTYPE":usertype.value 
                },
                success: function(res) {
                    console.log(res)
                    var jobj = JSON.parse(res);
                    if (jobj.result == 1) {
                        message.style.color = "green";
                        message.innerHTML = "Login successful!";
                        setTimeout(function() {
                            if(usertype.value=="student")
                            window.location.replace("index.php");
                        else
                            window.location.replace("admin/add_categories.php");
                        
                        }, 2000);


                    } else {
                        message.style.color = "red";
                        message.innerHTML = "Invalid Username or password!";
                    }
                },
            });
        } else {
            message.style.color = "red";
            message.innerHTML = "Please fill up all fields.";
        }
    }
</script>


</html>