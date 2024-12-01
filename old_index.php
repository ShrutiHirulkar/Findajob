<?php
/*$dob = $_GET['dob'];
$dob = new DateTime($dob);

$curDate = date("Y/m/d");
$curDate = new DateTime($curDate);

$interval = $dob->diff($curDate);
//print_r($interval);
echo $interval->format('%y years, %m months, %d days');
*/
/*
$pname = $_GET['pname'];
$pno = $_GET['pno'];

for ($i = 0; $i < $pno; $i++) {
    echo $pname;
    echo "<br>";
}*/
/*
$age = $_GET['age'];
$weight = $_GET['weight'];
$height = $_GET['height'];
$height = $height / 100; //in meters
$height = $height * $height; // square
$bmi = $weight / $height;

if ($age > 18 && $age < 65) {
    if ($bmi > 0 && $bmi < 18.5) {
        echo "You are Adult and UnderWeight";
    } else if ($bmi >= 18.5 && $bmi <= 24.9) {
        echo "You are  Adult and Normal weight";
    } else if ($bmi >= 25.0 && $bmi <= 29.9) {
        echo "You are  Adult and Overweight";
    } else {
        echo "You are  Adult and Obese";
    }
} else if ($age > 65) {
    if ($bmi > 0 && $bmi < 22) {
        echo "You are Senior Citizen and UnderWeight";
    } else if ($bmi >= 22 && $bmi <= 22.9) {
        echo "You are Senior Citizen and Normal weight";
    } else {
        echo "You are Senior Citizen and  Obese";
    }
}

echo "<br> Your BMI is". round($bmi);*/
/*
1. Index Array
2. Associative Array
*/
/*
$cities = array("Amravati", "Pune", "Banglore", "Mumbai");
$length = count($cities);

for ($i = 0; $i < $length; $i++) {
    print_r($cities[$i]);
    echo "<br>";
}
*/
/*
foreach ($cities as $city) {
    echo $city;
    echo "<br>";
}*/
//$student = array("name" => "Raj", "age" => 23, "address" => "Amravati");
/*foreach ($student as $key => $value) {
    echo $key." : ". $value;
    echo "<br>";
}
$username = $_POST["username"];
$password = $_POST["password"];

if ($username == "admin" && $password == "1234") {
    $result = array("status" => 1, "message" => "Login Successfull");
    $result = json_encode($result);
    print_r($result);
} else {
    $result = array("status" => 0, "message" => "Login Failed");
    $result = json_encode($result);
    print_r($result);
}
*/


$student = array("name" => "Raj", "age" => 23, "address" => "Amravati");
$student["marks"] = 85;
/*
$student=json_encode($student);
print_r($student);

$cities = array("Amravati", "Pune", "Banglore", "Mumbai");
$cities=json_encode($cities);
print_r($cities);
/*$fruits = array("Apple", "Mango", "Grapes", "Banana");
$combine = array();
for ($i = 0; $i < 4; $i++) {
    $element1 = $cities[$i];
    $element2 = $fruits[$i];
    array_push($combine, $element1, $element2);
}
print_r($combine);
*/





//echo json_encode($jobj);

?>