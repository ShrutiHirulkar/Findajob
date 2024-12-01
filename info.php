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


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

  <style>
    .benifitsClass {
      text-align: center;
      width: 20%;
      margin: 10px;
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
  </style>
</head>

<body>


<?php
require_once("layouts/navbar.php");
?>


  <div style="display: flex; margin: 2%">
    <div style="width: 60%">
      <div id="JOBDIV"></div>
      <!-- =======================  -->

      <div id="JOBDESC"></div>

      <!--======================-->
    </div>
    <div style="width: 40%">
      <div id="BENIFITS"></div>
    </div>
  </div>
 


<div class="container">
  

  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Apply Now</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <input id="exp" type="number" placeholder="Your Experience in Years" class="form-control">
            <input id="package" type="number" placeholder="Expected Package in LPA" class="form-control mt-2">
            <input id="loc" type="text" placeholder="Expected Office Location" class="form-control mt-2">
            <input id="skills" type="text" placeholder="Skills You Mastered in" class="form-control mt-2">
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
         <button type="button" class="btn btn-success" onclick="apply();">Apply</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  
</div>




<?php
require_once("layouts/footer.php");
?>

</body>

<script>
  var queryString = window.location.search;
  var params = new URLSearchParams(queryString);
  var id = params.get("id");

function apply()
{
  if(exp.value!="" && package.value !="" && loc.value!="" &&skills.value!="" )
{
      $.ajax({
        url: "get_response.php",
        type: "post",
        data: {
          "RES_TYPE": "APPLY",
          "EXP": exp.value,
          "PACKAGE":package.value,
          "LOC": loc.value,
          "SKILLS":skills.value,
          "ID":id
        },
        success: function(res) {
            console.log(res)
            exp.value="" 
            package.value="" 
            loc.value=""
            skills.value=""

            $('#myModal').modal('hide');
            jobj=JSON.parse(res)

            if(jobj==="Apply Success")
            toastr.success("Apply Success");
            else
            toastr.error("Apply Failed.. Try again later");

        },
      });
  }else{
    toastr.error("Please fill All Fields");
  }
}

  $('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})

  
  var login = <?php
             
             
              if (isset($_SESSION["login"]))
                echo $_SESSION["login"];
              else
                echo 0;
              ?>

  $.ajax({
    url: "get_response.php",
    type: "post",
    data: {
      "RES_TYPE": "INFO",
      "ID": id
    },
    success: function(res) {
      console.log("Login " + login);
      var jobj = JSON.parse(res);

      getCompanyInfo(jobj)
    },
  });

  function getCompanyInfo(jobj) {


    var company = jobj.jobInfo;
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
    s2.innerHTML = company.review + " Reviews";
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
    var t1 = document.createTextNode(" " + company.info);
    p3.appendChild(i1);
    p3.appendChild(t1);

    var p4 = document.createElement("p");
    p4.innerHTML = company.skills;
    var p5 = document.createElement("hr");

    var btnDiv = document.createElement("div");

    if (login == 0) {
      btnDiv.style.textAlign = "right";
      var regbtn = document.createElement("button");
      regbtn.classList.add("btn", "btn-outline-danger");
      regbtn.style.borderRadius = "25px";
      regbtn.innerHTML = "Register To Apply";
      regbtn.addEventListener("click", redirectToRegister);
      btnDiv.appendChild(regbtn);

      var loginbtn = document.createElement("button");
      loginbtn.classList.add("btn", "btn-outline-primary");
      loginbtn.style.borderRadius = "25px";
      loginbtn.innerHTML = "Login To Apply";
      loginbtn.addEventListener("click", redirectToLogin);
      btnDiv.appendChild(loginbtn);
    } else {
      btnDiv.style.textAlign = "right";
      var applybtn = document.createElement("button");
      applybtn.classList.add("btn", "btn-outline-primary");
      applybtn.style.borderRadius = "25px";
      applybtn.innerHTML = "Apply";
      applybtn.addEventListener("click", redirectToApply);
      btnDiv.appendChild(applybtn);
    }
    mainDiv.appendChild(part1);
    mainDiv.appendChild(part2);

    jobdiv.appendChild(mainDiv);
    jobdiv.appendChild(p2);
    jobdiv.appendChild(p3);
    jobdiv.appendChild(p4);
    jobdiv.appendChild(p5);
    jobdiv.appendChild(btnDiv);

    JOBDIV.appendChild(jobdiv);

    //================ ====================== ====================  //
    var benifitDiv = document.createElement("div");
    benifitDiv.classList.add("borderClass");
    var titleText = document.createElement("h5");
    titleText.innerHTML = "Benifits and Perks";
    benifitDiv.appendChild(titleText);

    var hrule = document.createElement("hr");
    benifitDiv.appendChild(hrule);

    var mainDiv = document.createElement("div");
    mainDiv.style.display = "flex";
    mainDiv.style.flexWrap = "wrap";

    for (var i = 0; i < jobj.benifits.length; i++) {
      var bDiv = document.createElement("div");
      bDiv.classList.add("benifitsClass");
      var i1 = document.createElement("i");
      i1.classList.add("fa-solid", jobj.benifits[i].icon, "fa-xl");
      i1.style.color = "#5981f7";
      var title = document.createElement("p");
      title.style.marginTop = "5%";
      title.innerHTML = jobj.benifits[i].title;
      bDiv.appendChild(i1);
      bDiv.appendChild(title);
      mainDiv.appendChild(bDiv);
    }

    benifitDiv.appendChild(mainDiv);
    BENIFITS.appendChild(benifitDiv);

    //================= ================== Job Desc ================
    var jobDescDiv = document.createElement("div");
    jobDescDiv.classList.add("borderClass");
    var titleText = document.createElement("h5");
    titleText.innerHTML = "Job Description";
    jobDescDiv.appendChild(titleText);
    var hrule = document.createElement("hr");
    jobDescDiv.appendChild(hrule);

    for (var i = 0; i < jobj.jobdesc.length; i++) {
      var jobdesc = jobj.jobdesc[i];
      var jobTitle = document.createElement("h4");
      jobTitle.innerHTML = jobdesc.title;
      jobDescDiv.appendChild(jobTitle);

      var uitem = document.createElement("ul");
      for (var j = 0; j < jobdesc.desc.length; j++) {
        var listItem = document.createElement("li");
        listItem.innerHTML = jobdesc.desc[j];
        uitem.appendChild(listItem);
      }
      jobDescDiv.appendChild(uitem);


    }

    JOBDESC.appendChild(jobDescDiv);
  }

  function redirectToLogin() {
    window.location.href = "login.php";
  }

  function redirectToRegister() {
    window.location.href = "register.php";
  }

  function redirectToApply() {
    $('#myModal').modal('show');
  }
</script>

</html>