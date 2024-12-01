<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <style>
      span {
        margin: 15px;
      }
      .borderClass {
        border: 1px solid black;
        padding: 2%;
        margin: 2%;
        border-radius: 15px;
      }

      .imgClass {
        width: 65px;
        height: 65px;
        border-radius: 15px;
      }

      p {
        margin: 15px;
      }
      button {
        margin: 10px;
      }
      .containerClass {
        border: 1px solid black;
        border-radius: 20px;
        padding: 10px;
        margin: 10px;
      }
    </style>
  </head>
  <body>


<?php
require_once("layouts/navbar.php");
?>

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
      <div style="width: 70%" id="SAVEDJOB"></div>
    </div>



<?php
require_once("layouts/footer.php");
?>

  </body>

  <script>
    $.ajax({
      url: "get_response.php",
      type: "post",
      data: {  "RES_TYPE":"SAVED_JOBS" },
      success: function (res) {
        var jobj=JSON.parse(res);
        console.log(jobj);
        getSavedJobs(jobj);
      },
    });

    function getSavedJobs(jobj)
    {

    console.log(jobj);
    username.innerHTML = jobj.pinfo.username;
    phone.innerHTML = jobj.pinfo.phone;

    for (var i = 0; i < jobj.companies.length; i++) {
      var company = jobj.companies[i];
      var jobdiv = document.createElement("div");
      jobdiv.classList.add("borderClass");

      var mainDiv = document.createElement("div");
      mainDiv.style.display = "flex";

      var part1 = document.createElement("div");
      part1.style.width = "80%";

      var titleText = document.createElement("h5");
      titleText.innerHTML = company.title;
      part1.appendChild(titleText);

      var p1 = document.createElement("p");
      var s1 = document.createElement("span");
      s1.innerHTML = company.category + " ⭐ " + company.rating;
      s1.style.fontWeight = "400";
      p1.appendChild(s1);

      var s2 = document.createElement("span");
      s2.innerHTML = company.reviews + " Reviews";
      s2.style.fontSize = "small";
      s2.style.marginLeft = "2%";
      p1.appendChild(s2);
      part1.appendChild(p1);

      var part2 = document.createElement("div");
      part2.style.width = "20%";
      part2.style.textAlign = "right";

      var logoImg = document.createElement("img");
      logoImg.classList.add("imgClass");
      logoImg.src = "images/" + company.image;
      part2.appendChild(logoImg);

      var p2 = document.createElement("p");

      var sp1 = document.createElement("span");
      var i1 = document.createElement("i");
      i1.classList.add("fa-solid", "fa-briefcase");
      var t1 = document.createTextNode(" " + company.exp);
      sp1.appendChild(i1);
      sp1.appendChild(t1);
      p2.appendChild(sp1);

      var sp1 = document.createElement("span");
      sp1.style.marginLeft = "2%";
      var i1 = document.createElement("i");
      i1.classList.add("fa-solid", "fa-indian-rupee-sign");
      var t1 = document.createTextNode(" " + company.package + " PA");
      sp1.appendChild(i1);
      sp1.appendChild(t1);
      p2.appendChild(sp1);

      var sp1 = document.createElement("span");
      sp1.style.marginLeft = "2%";
      var i1 = document.createElement("i");
      i1.classList.add("fa-solid", "fa-location-dot");
      var t1 = document.createTextNode(" " + company.location);
      sp1.appendChild(i1);
      sp1.appendChild(t1);
      p2.appendChild(sp1);

      var p3 = document.createElement("p");
      var i1 = document.createElement("i");
      i1.classList.add("fa-solid", "fa-note-sticky");
      var t1 = document.createTextNode(" " + company.desc);
      p3.appendChild(i1);
      p3.appendChild(t1);

      var p4 = document.createElement("p");
      p4.innerHTML = company.skills;

      mainDiv.appendChild(part1);
      mainDiv.appendChild(part2);

      jobdiv.appendChild(mainDiv);
      jobdiv.appendChild(p2);
      jobdiv.appendChild(p3);
      jobdiv.appendChild(p4);

      SAVEDJOB.appendChild(jobdiv);
    
    }

  }
  </script>
</html>
