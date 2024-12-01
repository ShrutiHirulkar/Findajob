
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
   
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <style>
      p {
        margin: 15px;
      }
      button {
        margin: 10px;
      }
    </style>
  </head>
  <body>
    <div style="display: flex">
      <div style="width: 30%">
        <div
          style="
            border: 1px solid black;
            text-align: center;
            border-radius: 25px;
            margin: 15px;
            padding: 15px;
          "
        >
          <img
            src="images/user.jpeg"
            alt=""
            style="width: 150px; height: 150px; border-radius: 50%"
          />
          <p id="username">User Name</p>
          <p id="phone">Phone</p>
        </div>

        <button
          class="btn btn-outline-danger"
          style="width: 80%; border-radius: 25px; margin-left: 10%"
        >
          Profile
        </button>

        <button
          class="btn btn-outline-danger"
          style="width: 80%; border-radius: 25px; margin-left: 10%"
        >
          Saved Jobs
        </button>

        <button
          class="btn btn-outline-danger"
          style="width: 80%; border-radius: 25px; margin-left: 10%"
        >
          Help
        </button>

        <button
          class="btn btn-outline-danger"
          style="width: 80%; border-radius: 25px; margin-left: 10%"
        >
          Logout
        </button>
      </div>
      <div style="width: 70%">
        <div
          style="
            border: 1px solid black;
            margin: 10px;
            padding: 10px;
            border-radius: 15px;
          "
        >
          <p id="pname">Name</p>
          <p id="gender">Gender</p>
          <p id="age">Age</p>
          <p id="email">Email</p>
        </div>

        <button class="btn btn-danger" style="margin-left: 50%">Update</button>
      </div>
    </div>
  </body>

  <script>
     $.ajax({
      url: "get_response.php",
      type: "post",
      data: {  "RES_TYPE":"PROFILE" },
      success: function (res) {
        var jobj=JSON.parse(res);
       
        getProfile(jobj);
      },
    });

    function getProfile(pinfo)
   {   
    username.innerHTML = pinfo.username;
    pname.innerHTML = pinfo.name;
    phone.innerHTML = pinfo.phone;
    gender.innerHTML = pinfo.gender;
    age.innerHTML = pinfo.age;
    email.innerHTML = pinfo.email;}
  </script>
</html>
