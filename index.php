<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

  <style>
    .titleStyle {
      font-size: larger;
    }

    .logoButtonStyle {
      margin: 25px;
      padding: 12px;
    }

    

    .companyStyle {
      width: 250px;
      border: 1px solid rgba(89, 88, 88, 0.791);
      text-align: center;
      border-radius: 15px;
      margin: 20px;
      padding: 15px;
    }
  </style>
</head>

<body>

<?php
require_once("layouts/navbar.php");
?>

  <div class="m-5">
    <h1 class="text-center">Find your dream job now</h1>
    <p class="text-center">5 lakh+ jobs for you to explore</p>
  </div>

  <div class="container">
    <div
      class="row"
      style="
          border-radius: 25px;
          border: 1px solid rgba(250, 152, 152, 0.492);
          padding: 15px;
        ">
      <div class="col-1"><i class="fa-solid fa-magnifying-glass"></i></div>

      <div class="col-4">
        <input
          class="form-control"
          type="text"
          style="width: 100%"
          placeholder="Enter skills / designations / companies"
          id="sdc" />
      </div>

      <div class="col-2">
        <select style="width: 100%" class="form-control" id="exp">
          <option value="">Select Exprience</option>
          <option value="0">Fresher</option>
          <option value="1">1 Year</option>
          <option value="2">2 Years</option>
          <option value="3">3 Years</option>

        </select>
      </div>

      <div class="col-2">
        <input
          type="text"
          class="form-control"
          placeholder="Enter Location"
          id="loc" />
      </div>

      <div class="col-1">
        <button class="btn btn-primary px-5" style="border-radius: 25px" onclick="search();">
          Search
        </button>
      </div>
    </div>
  </div>

  <h2 style="margin: 25px">Top companies hiring now</h2>
  <div
    style="display: flex; flex-wrap: wrap; justify-content: center"
    id="btnCategory"></div>
  <h2 style="margin: 25px">Featured companies actively hiring</h2>

  <div style="text-align: center">
    <button
      class="btn btn-outline-danger mt-3 px-4"
      style="border-radius: 25px">
      All
    </button>

    <button
      class="btn btn-outline-danger mt-3 px-4"
      style="border-radius: 25px">
      IT Services
    </button>

    <button
      class="btn btn-outline-danger mt-3 px-4"
      style="border-radius: 25px">
      BFSI
    </button>
  </div>

  <div id="companiesDiv">
    <div id="jobs" style="display: flex; flex-wrap: wrap"></div>
  </div>


<?php
require_once("layouts/footer.php");
?>

</body>

<script>
  var btns;
  $.ajax({
    url: "get_response.php",
    type: "post",
    data: {
      "RES_TYPE": "INDEX"
    },
    success: function(res) {
      var jobj = JSON.parse(res);
      console.log(jobj);
      createBtns(jobj.buttons);
      createCompanies(jobj.companies);
    },
  });

  function createBtns(bobj) {
    var parentDiv = document.createElement("div");
    for (var j = 0; j < bobj.buttons.length; j++) {
      var b1 = document.createElement("button");
      b1.id = bobj.buttons[j].id;
      var tn = document.createTextNode(" " + bobj.buttons[j].category);
      b1.classList.add("btn", "btn-outline-primary", "logoButtonStyle");
      var i = document.createElement("i");
      i.classList.add("fa-solid", bobj.buttons[j].icon);
      b1.appendChild(i);
      b1.appendChild(tn);
      b1.addEventListener("click", redirectToDesc);
      parentDiv.appendChild(b1);
      btnCategory.appendChild(parentDiv);
    }
  }

  function redirectToDesc() {
    console.log(this.id);
    window.location.href = "desc.php?id=" + this.id;
  }

  function redirectToInfo() {
    window.location.href = "info.php?id=" + this.id;
  }



  function createCompanies(jobj) {


    for (var i = 0; i < jobj.companies.length; i++) {
      console.log(jobj.companies[i].name);
    }

    for (var i = 0; i < jobj.companies.length; i++) {
      var d1 = document.createElement("div");
      d1.classList.add("companyStyle");
      var i1 = document.createElement("img");
      i1.style.width = "100px";
      i1.style.height = "100px";
      i1.src = "images/" + jobj.companies[i].image;
      var helement = document.createElement("h5");
      helement.innerHTML = jobj.companies[i].name;
      helement.classList.add("text-center");
      var p1 = document.createElement("p");
      p1.innerHTML =
        "⭐" +
        jobj.companies[i].rating +
        " " +
        jobj.companies[i].review +
        "+ Reviews";
      var p2 = document.createElement("p");
      var trimmedString = jobj.companies[i].info.substring(0, 50);
      p2.innerHTML = trimmedString;
      var b1 = document.createElement("button");
      b1.classList.add("btn", "btn-outline-danger", "mt-3", "px-4");
      b1.style.borderRadius = "25px";
      b1.innerHTML = "View Jobs";
      b1.id = jobj.companies[i].id;
      b1.addEventListener("click", redirectToInfo)
      d1.appendChild(i1);
      d1.appendChild(helement);
      d1.appendChild(p1);
      d1.appendChild(p2);
      d1.appendChild(b1);
      jobs.appendChild(d1);
    }

  }

  function search() {
    window.location.href = "search.php?sdc=" + sdc.value + "&exp=" + exp.value + "&location=" + loc.value;
  }

  function redirectToLogin() {
    window.location.href = "login.php";
  }


  function redirectToRegister() {
    window.location.href = "register.php";
  }

</script>

</html>