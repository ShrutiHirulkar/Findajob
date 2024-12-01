<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <style>
        .row {
            margin: 20px
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h3>Register Now</h3>
            </div>
        </div>
        <div class="row">
            <div class="col">Name</div>
            <div class="col"><input type="text" id="pname"></div>
        </div>
        <div class="row">
            <div class="col">Password</div>
            <div class="col"><input type="password"  id="password"></div>
        </div>
        <div class="row">
            <div class="col">Age</div>
            <div class="col"><input type="number" id="age"></div>
        </div>
        <div class="row">
            <div class="col">Gender</div>
            <div class="col"><input type="radio" id="male" value="male" name="gender">Male</div>
            <div class="col"><input type="radio" id="female" value="female" name="gender">Female</div>
        </div>
        <div class="row">

            <div class="col">City</div>
            <div class="col">
                <select name="" id="city">
                    <option value="">Select City</option>
                    <option value="amravati">Amravati</option>
                    <option value="pune">Pune</option>
                    <option value="banglore">Banglore</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <button class="btn btn-outline-danger" onclick="register();">Register Now</button>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <h6 id="message"></h6>
            </div>
        </div>
    </div>

</body>
<script>
    function register() {

        //var regexp = new RegExp("^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$");
        var regexp = /^(?=.*[A-Z])(?=.*\d)(?=.*[@#$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        var res = regexp.test(password.value);
        if(res)
    {
        if (pname.value != "" && password.value != "" && age.value != "" && city.value != "" )

        {
            var gender = document.querySelector('input[name="gender"]:checked').value;
            $.ajax({
                url: "get_response.php",
                type: "post",
                data: {
                    "RES_TYPE": "REGISTER",
                    "PNAME": pname.value,
                    "PASSWORD": password.value,
                    "AGE": age.value,
                    "CITY": city.value,
                    "GENDER": gender
                },
                success: function(res) {
                    console.log(res);
                    var jobj = JSON.parse(res);
                    if(jobj.result==1)
                {
                    message.style.color="green";
                    message.innerHTML = "Registration Successfull";
                }else{
                    message.style.color="red";
                     message.innerHTML = "Registration Failed";
                }
                },
            });
        } else {
            message.style.color="red";
            message.innerHTML = "Please Fill up all and valid fields";
        }

    }else{
                 message.style.color="red";
            message.innerHTML = "Password should have 8 chars 1 special char,caps alphabet and number ";
    }
        console.log(res);



    }
</script>

</html>