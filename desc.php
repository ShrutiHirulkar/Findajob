<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">


    <title>Job Description</title>
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
    </style>
  </head>
  <body>

  <?php
require_once("layouts/navbar.php");
?>


    <div style="display: flex">
      <!--=========================== Left Part =================-->

      <div style="width: 20%; padding: 2%">
        <h5>All Filters</h5>
        <hr />
        <h5>Exprience <span id="expyrs">0</span> Yrs</h5>
        <input id="exp" type="range" style="width: 100%" min="0" max="30" step="1" value="0" onchange="valuesUpdated(this);"/>
        <p>
          <label>0 Yrs</label>
          <label style="margin-left: 50%">30 Yrs</label>
        </p>
        <hr />
        <h5>Salary</h5>
        <p><input type="checkbox" style="margin-right: 5%" value="0-3" onchange="valuesUpdated(this);"/> 0 - 3 Lakhs</p>
        <p><input type="checkbox" style="margin-right: 5%" value="3-6"onchange="valuesUpdated(this);" /> 3 - 6 Lakhs</p>
        <p><input type="checkbox" style="margin-right: 5%" value="6-10"onchange="valuesUpdated(this);" /> 6 - 10 Lakhs</p>
        <p><input type="checkbox" style="margin-right: 5%" value="10-15"onchange="valuesUpdated(this);" /> 10 - 15 Lakhs</p>
        <h6 style="color: rgb(11, 55, 177)">View More</h6>
        <hr />
        <h5>Location</h5>
        <select name="" id="loc" class="form-control" onchange="valuesUpdated(this);">
          <option value="all">All</option>
           
        </select>

        <hr />
        <h5>Company type</h5>
        <select name="" id="ctype" class="form-control" onchange="valuesUpdated(this);">
        <option value="all">All</option>
          <option value="corporate">Corporate</option>
          <option value="foreign-mnc">Foreign MNC</option>
          <option value="startup">Startup</option>
          <option value="indian-mnc">Indian MNC</option>
        </select>

        <hr />
        <h5>Work mode</h5>
        <select name="" id="wm" class="form-control" onchange="valuesUpdated(this)";>
        <option value="all">All</option>
          <option value="wfo">Work from office</option>
          <option value="remote">Remote</option>
          <option value="hybrid">Hybrid</option>
        </select>

        <hr />
        <h5>Top companies</h5>
        <select name="" id="tc" class="form-control" onchange="valuesUpdated(this)">
           <option value="all">All</option>
          <option value="accenture">Accenture</option>
          <option value="ibm">IBM</option>
          <option value="microsoft">Microsoft</option>
        </select>
      </div>

      <!--=========================== Right Part =================-->

      <div style="width: 80%" id="jobContainer">
        
    
    </div>
    </div>



<?php
require_once("layouts/footer.php");
?>

  </body>
</html>

<script>

var queryString=window.location.search;
var params=new URLSearchParams(queryString);
var id= params.get("id");

var salary=[];
 var updatedValues={"loc":"all","ctype":"all","wm":"all","tc":"all","exp":0,"salary":salary,"id":id}; 
function valuesUpdated(element)
{
  //updating elements in salary array
  if(element.type=="checkbox")
  {
        var index= salary.indexOf(element.value); 
        if(index==-1)
        {
          salary.push(element.value);
        }else{
          salary.splice(index,1);
        } 
        updatedValues["salary"]=salary; 
  }else{
        updatedValues[element.id]=element.value;
  }

expyrs.innerHTML=element.value; 

 $.ajax({
      url: "get_response.php",
      type: "post",
      data: {  "RES_TYPE":"CFILTER","DATA":updatedValues },
      success: function (res) {
         console.log(res)
      },
    });

}


 
console.log(id)

    $.ajax({
      url: "get_response.php",
      type: "post",
      data: {  "RES_TYPE":"DESC","ID":id },
      success: function (res) {
        console.log(res)
        var jobj=JSON.parse(res);
        
        getCompaniesDesc(jobj.companies);
        createLocations(jobj.locations);
      },
    });

    function createLocations(locations){
        for(i=0; i<locations.length;i++)
        {
          opt=document.createElement("option");
          opt.innerHTML=locations[i];
          opt.value=locations[i];
          loc.appendChild(opt);
        }
        
    }

    function getCompaniesDesc(companies)
    {
  
  for (var i = 0; i < companies.length; i++) {
    var company = companies[i];
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
    var p5 = document.createElement("p");
    p5.style.textAlign = "right";
    p5.style.color="black";
    p5.id="p5_"+company.id;
    var i1 = document.createElement("i");
    i1.classList.add("fa-solid", "fa-bookmark");
    i1.addEventListener("click",saveCompany);
    i1.id=company.id;
    var t1 = document.createTextNode(" Save");
    t1.marginRight="2%";
    p5.appendChild(i1);
    p5.appendChild(t1);


    var viewInfoBtn = document.createElement("button");
    viewInfoBtn.classList.add("btn", "btn-outline-primary");
    viewInfoBtn.style.borderRadius = "25px";
    viewInfoBtn.innerHTML = "View Info";
    viewInfoBtn.style.marginLeft="25px";
    viewInfoBtn.id=company.id;
    viewInfoBtn.addEventListener("click",redirectToInfo);
    p5.appendChild(viewInfoBtn); 


    mainDiv.appendChild(part1);
    mainDiv.appendChild(part2);

    jobdiv.appendChild(mainDiv);
    jobdiv.appendChild(p2);
    jobdiv.appendChild(p3);
    jobdiv.appendChild(p4);
    jobdiv.appendChild(p5); 

    jobContainer.appendChild(jobdiv);
  }

    }

    function redirectToInfo()
    {
      window.location.href="info.php?id="+this.id;
    }

    function saveCompany()
    {
       <?php
          if (isset($_SESSION["login"]) && $_SESSION["login"] == true)
          {
        ?>

      var element=document.getElementById("p5_"+this.id);
      $.ajax({
      url: "get_response.php",
      type: "post",
      data: {  "RES_TYPE":"SAVE","ID":this.id,"STATUS":element.style.color },
      success: function (res) {
              console.log(res)
          },
      });
      if(element.style.color=="black")
      element.style.color="red";
      else
      element.style.color="black";
   
   <?php
          }else{
    ?>
            toastr.error("Please login before apply");
   <?php
          }
   ?>
    }

    function redirectToLogin()
    {
        window.location.replace("login.php")
    }
</script>
