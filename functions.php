<?php
require_once("dbconn.php");




function test()
{
    global $conn;
    $stmt=$conn->prepare("SELECT * FROM `categories`");
    if($stmt)
    {
        if($stmt->execute())
        {
             $result= $stmt->get_result();
             while($row=$result->fetch_assoc())
             {
             print_r($row);
             echo "<br>";
             }

        }else{
           echo $conn->connect_error;
        }

    }else{
        echo $conn->connect_error;
    }
    
    
    
    
    /*if($stmt){
        $stmt->bind_param("i",$cardid);
        if($stmt->execute()){
            $result=$stmt->get_result();
            while($row=$result->fetch_assoc())
            {
                //print_r($row);
                if($row["tag"]=="select"){
                    $options=getOptions($row["id"]);
                    $row["options"]=$options;
                }


                array_push($fields,$row);
            }
             
            //print_r($fields);
           return $fields;
        }else{
            echo "Execute Error";
        }
    }else{
        echo "Prepare Error";
    }
    */
}



function apply($exp,$package,$loc,$skills,$id)
{
    session_start();
    global $conn;
    $stmt=$conn->prepare("INSERT INTO `apply`( `exp`, `package`, `location`, `skills`, `user`, `job`) VALUES (?,?,?,?,?,?)");
    if($stmt)
    {
        $stmt->bind_param("iissii",$exp,$package,$loc,$skills,$_SESSION['userid'],$id);
        if($stmt->execute())
        {        
            return "Apply Success";
        }else{
            return "Apply Failed";
        }

    }else{
        echo $conn->connect_error;
    }

    
}

function login($username, $password,$usertype)
{

    global $conn;
    if($usertype=="student")
    $stmt=$conn->prepare("SELECT * FROM `users` WHERE BINARY name=? AND BINARY password=?");
    else
    $stmt=$conn->prepare("SELECT * FROM `admin` WHERE BINARY name=? AND BINARY password=?");
    
    if($stmt)
    {
        $stmt->bind_param("ss",$username,$password);
        if($stmt->execute())
        {
             $result= $stmt->get_result();
             $count=mysqli_num_rows($result);
             if($count>=1)
             {
                $row=$result->fetch_assoc();
                session_start();
                $_SESSION["login"] = true;
                $_SESSION["username"] = $row["name"];
                $_SESSION["userid"]=$row["id"];
                $res = array("result" => 1, "message" => "Login Successful");
                return $res;
            }else{
                $res = array("result" => 0, "message" => "Invalid Username or Password");
                return $res;
             }

             
        }else{
           echo $conn->connect_error;
        }

    }else{
        echo $conn->connect_error;
    }

}


function save($id, $status)
{
     
    session_start();
    global $conn;

    if($status=="black")
        $stmt=$conn->prepare("INSERT INTO savedjobs(user,job) VALUES(?,?)");
    else
        $stmt=$conn->prepare("DELETE FROM savedjobs WHERE user=? AND job=?");
   

    if($stmt)
    {
        $stmt->bind_param("ii",$_SESSION["userid"],$id);
        if($stmt->execute())
        {
            
            return $status;
        }else{
           echo $conn->connect_error;
        }

    }else{
        echo $conn->connect_error;
    }

}

function cfilter($data)
{
$minexp=0;
$maxexp=$data["exp"];
$minmax=explode("-",$data["salary"][0]);
$minsal=$minmax[0];
$maxsal=$minmax[1];

    $location=array();   
    global $conn;
    $stmt=$conn->prepare("SELECT jobs.id,jobs.title, jobs.exp,jobs.package,jobs.location,jobs.info, jobs.skills, companies.image, companies.rating, companies.review FROM `jobs` INNER JOIN companies ON jobs.company=companies.id INNER JOIN categories ON companies.category=categories.id WHERE jobs.location=?  AND companies.name=? AND (jobs.minexp BETWEEN ? AND ?) AND (jobs.maxsal BETWEEN ? AND ?)  AND jobs.category=?");
    if($stmt)
    {
        $stmt->bind_param("ssiiiii",$data["loc"],$data["tc"],$minexp,$maxexp,$minsal,$maxsal,$data["id"]);
        if($stmt->execute())
        {
             $result= $stmt->get_result();
             $companies = array();
             while($row=$result->fetch_assoc())
             {
                array_push($companies,$row);
                if (!in_array($row['location'], $location)) 
                array_push($location,$row['location']); 
             }
              
             return array("companies"=>$companies,"locations"=>$location);

        }else{
           echo $conn->connect_error;
        }

    }else{
        echo $conn->connect_error;
    }

   // return $data;
}

function search($sdc, $exp, $loc)
{
   
    
    global $conn;
    $stmt=$conn->prepare("SELECT * FROM `jobs` INNER JOIN companies ON jobs.company=companies.id INNER JOIN categories ON jobs.category=categories.id WHERE jobs.minexp<? AND jobs.location=? AND jobs.tags LIKE ?");
    if($stmt)
    {
        $sdc="%$sdc%";
        $stmt->bind_param("iss",$exp,$loc,$sdc);
        if($stmt->execute())
        {
             $result= $stmt->get_result();
             $companies = array();
             while($row=$result->fetch_assoc())
             {
                array_push($companies,$row);  
             }
              
             return array("companies"=>$companies);

        }else{
           echo $conn->connect_error;
        }

    }else{
        echo $conn->connect_error;
    }
}

function register($pname, $password, $age, $city, $gender)
{
    global $conn;
    $stmt=$conn->prepare("INSERT INTO `users`( `name`, `password`, `age`, `gender`, `city`) VALUES (?,?,?,?,?)");
    if($stmt)
    {
        $stmt->bind_param("ssiss",$pname,$password,$age,$gender,$city);
        if($stmt->execute())
        {        
            $result = array("result" => 1, "message" => "Registration Successfull");
            return $result;    
        }else{
            $result = array("result" => 0, "message" => "Registration Failed");
            return $result;  
        }

    }else{
        echo $conn->connect_error;
    }

}

function getProfile()
{
    $pinfo = array(
        "name" => "Ravi",
        "username" => "ravi",
        "phone" => "9595210063",
        "gender" => "male",
        "age" => 23,
        "email" => "ravi@gmail.com"
    );
    return $pinfo;
}

function getSavedJobs()
{
    $jobj = array(
        "companies" => array(
            array(
                "id" => 1,
                "title" => "React.js Developer - HTML/ CSS/ JavaScript",
                "category" => "Web Programming",
                "rating" => 4.25,
                "reviews" => 329,
                "image" => "hp.png",
                "exp" => "5 - 10 Years",
                "package" => "1-3 Lakhs",
                "location" => "Amravati",
                "desc" => "Requirements: Bachelors degree in Computer Science, Software Engineering, or relat",
                "skills" => "Javascript | TypeScript |RESTful API | CSS | Git | UI | Redux | HTML"
            ),
            array(
                "id" => 2,
                "title" => "Mobile App Developer - Java",
                "category" => "Mobile Programming",
                "rating" => 5.0,
                "reviews" => 429,
                "image" => "lg.png",
                "exp" => "1 - 5 Years",
                "package" => "2-5 Lakhs",
                "location" => "Mumbai",
                "desc" => "Mobile App Developer needed to design native android apps",
                "skills" => "Java | XML |RESTful API | Git | UI  | HTML"
            )
        ),
        "pinfo" => array(
            "username" => "ravi",
            "phone" => "9595210063"
        )
    );
    return $jobj;
}

function getJobInfo($id)
{
    global $conn;
    $stmt=$conn->prepare("SELECT * FROM `jobs` INNER JOIN companies ON jobs.company=companies.id INNER JOIN categories ON jobs.category=categories.id WHERE jobs.id=?");
    if($stmt)
    {
        $stmt->bind_param("i",$id);
        if($stmt->execute())
        {
             $result= $stmt->get_result();
             $row=$result->fetch_assoc();
             return $row;

        }else{
           echo $conn->connect_error;
        }

    }else{
        echo $conn->connect_error;
    }
}

function getBenifits($id)
{
    global $conn;
    $stmt=$conn->prepare("SELECT * FROM `benifits` WHERE jobid=?");
    if($stmt)
    {
        $stmt->bind_param("i",$id);
        if($stmt->execute())
        {
             $result= $stmt->get_result();
             $benifits = array();
             while($row=$result->fetch_assoc())
             {
                array_push($benifits,$row);
             }
              
             return $benifits;

        }else{
           echo $conn->connect_error;
        }
    }else{
        echo $conn->connect_error;
    }
}

function getCompanyDesc($id)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `jobdesc` INNER JOIN jobtitles ON jobdesc.title=jobtitles.id WHERE jobdesc.jobid=?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $companies = [];

            // Process each row in the result
            while ($row = $result->fetch_assoc()) {
                $title = $row['title'];
                $description = $row['description'];

                // Check if the title already exists in the $companies array
                $found = false;
                foreach ($companies as &$entry) {
                    if ($entry['title'] === $title) {
                        // Add the description to the existing title entry
                        $entry['desc'][] = $description;
                        $found = true;
                        break;
                    }
                }

                // If the title does not exist, create a new entry
                if (!$found) {
                    $companies[] = [
                        "title" => $title,
                        "desc" => [$description]
                    ];
                }
            }
                return $companies;
            
        } else {
            echo $conn->error;
        }
        
    } else {
        echo $conn->error;
    }
}



function getCompanyInfo($id)
{
    $jobInfo=getJobInfo($id);
    $benifits=getBenifits($id);
    $jobdesc=getCompanyDesc($id);
    $jobDetails = array(
        "jobInfo" => $jobInfo,
        "benifits" => $benifits,
        "jobdesc" => $jobdesc
    );
    return $jobDetails;
}

function getCompaniesDesc($id)
{
 
    $location=array();   
    global $conn;
    $stmt=$conn->prepare("SELECT jobs.id,jobs.title, jobs.exp,jobs.package,jobs.location,jobs.info, jobs.skills, companies.image, companies.rating, companies.review, categories.category FROM `jobs` INNER JOIN companies ON jobs.company=companies.id INNER JOIN categories ON companies.category=categories.id WHERE categories.id=?;");
    if($stmt)
    {
        $stmt->bind_param("i",$id);
        if($stmt->execute())
        {
             $result= $stmt->get_result();
             $companies = array();
             while($row=$result->fetch_assoc())
             {
                array_push($companies,$row);
                if (!in_array($row['location'], $location)) 
                array_push($location,$row['location']); 
             }
              
             return array("companies"=>$companies,"locations"=>$location);

        }else{
           echo $conn->connect_error;
        }

    }else{
        echo $conn->connect_error;
    }
  
}







function getButtons()
{
    global $conn;
    $stmt=$conn->prepare("SELECT * FROM `categories`");
    if($stmt)
    {
        if($stmt->execute())
        {
             $result= $stmt->get_result();
             $btns = array();
             while($row=$result->fetch_assoc())
             {
                array_push($btns,$row);
             }
             $buttonsObj = array("buttons" => $btns);
             return $buttonsObj;

        }else{
           echo $conn->connect_error;
        }

    }else{
        echo $conn->connect_error;
    }
  
    
}

function getCompanies()
{
    global $conn;
    $stmt=$conn->prepare("SELECT * FROM `companies`");
    if($stmt)
    {
        if($stmt->execute())
        {
             $result= $stmt->get_result();
             $companies = array();
             while($row=$result->fetch_assoc())
             {
                array_push($companies,$row);

               
             }
             $jobj = array("companies" => $companies);
             return $jobj;

        }else{
           echo $conn->connect_error;
        }

    }else{
        echo $conn->connect_error;
    }

}
