<?php
require_once("functions.php");
$res_type = $_POST["RES_TYPE"];
switch ($res_type) {
    case "INDEX":
        $buttons = getButtons();
        $companies = getCompanies();
        $jobj = array("buttons" => $buttons, "companies" => $companies);
        echo json_encode($jobj);
        break;
    case "DESC":
        $jobj = getCompaniesDesc($_POST["ID"]);
        echo json_encode($jobj);
        break;

    case "INFO":
        $jobj = getCompanyInfo($_POST["ID"]);
        echo json_encode($jobj);
        break;

    case "SAVED_JOBS":
        $jobj = getSavedJobs();
        echo json_encode($jobj);
        break;

    case "PROFILE":
        $jobj = getProfile();
        echo json_encode($jobj);
        break;

    case "REGISTER":
        $jobj = register($_POST["PNAME"], $_POST["PASSWORD"], $_POST["AGE"], $_POST["CITY"], $_POST["GENDER"]);
        echo json_encode($jobj);
        break;

    case "LOGIN":
        $jobj = login($_POST["USERNAME"], $_POST["PASSWORD"],$_POST["USERTYPE"]);
        echo json_encode($jobj);
        break;

    case "SEARCH":
        $jobj = search($_POST["SDC"], $_POST["EXP"], $_POST["LOC"]);
        echo json_encode($jobj);
        break;

    case "CFILTER":
        $jobj = cfilter($_POST["DATA"]);
        echo json_encode($jobj);
        break;

    case "SAVE":
        $jobj = save($_POST["ID"], $_POST["STATUS"]);
        echo json_encode($jobj);
        break;


    case "APPLY": 
        $jobj = apply($_POST["EXP"], $_POST["PACKAGE"],$_POST["LOC"],$_POST["SKILLS"],$_POST["ID"]);
        echo json_encode($jobj);
        break;
}
