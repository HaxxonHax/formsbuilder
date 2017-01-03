<?php
//Start session
session_start();

if (!(isset($_SESSION['SESS_MEMBER_ID']) && $_SESSION['SESS_MEMBER_ID'] != '')) {
    header("Location: login.php");
}

//Include database connection details
require_once ('config.php');
require_once ('db-lib.php');

//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;

//Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
    $str = @trim($str);
    if (get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return db_real_escape_string($str);
}

if (isset($_POST['submit'])) {
    $_SESSION['fformdate'] = $_POST['formdate'];
    $_SESSION['fmeals'] = $_POST['meals'];
    $_SESSION['flodging'] = $_POST['lodging'];
}

//If there are input validations, redirect back to the login form
if ($errflag) {
    $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
    session_write_close();
    header("location: login.php");
    //printf("%s",$errflag);
    exit();
}

if (isset($_POST['submit'])) {
    $_SESSION['fmldate'] = $_POST['formdate'];
    $_SESSION['fmeals'] = $_POST['meals'];
    $_SESSION['flodging'] = $_POST['lodging'];
}

header("Output");
printf("<pre>\n");
if ((isset($_SESSION['ffirst']))) {
    printf("First Name: %s\n", $_SESSION['ffirst']);
}
if ((isset($_SESSION['flast']))) {
    printf("Last Name: %s\n", $_SESSION['flast']);
}
if ((isset($_SESSION['fein']))) {
    printf("EIN: %s\n", $_SESSION['fein']);
}
if ((isset($_SESSION['faddress1']))) {
    printf("Work Address 1: %s\n", $_SESSION['faddress1']);
}
if ((isset($_SESSION['faddress2']))) {
    printf("Work Address 2: %s\n", $_SESSION['faddress2']);
}
if ((isset($_SESSION['fvehicle']))) {
    printf("Vehicle type: %s\n", $_SESSION['fvehicle']);
}
if ((isset($_SESSION['fmessage']))) {
    printf("Message: %s\n", $_SESSION['fmessage']);
}

// Arrays
if ((isset($_SESSION['fdepartfrom']))) {
    $i = 0;
    $l = count($_SESSION['fdepartfrom']);
    for ($i = 0; $i < $l; $i++) {
        printf("\nTrip %s\n", ($i + 1));
        printf("Departed From: %s\n", $_SESSION['fdepartfrom'][$i]);
        printf("Departure Date: %s\n", $_SESSION['fdeparturedate'][$i]);
        printf("Odometer Start: %s\n", $_SESSION['fodstart'][$i]);
        printf("Arrived At: %s\n", $_SESSION['farrivedat'][$i]);
        printf("Arrival Date: %s\n", $_SESSION['farrivaldate'][$i]);
        printf("Odometer end: %s\n", $_SESSION['fodend'][$i]);
    }
}

if ((isset($_SESSION['fmldate']))) {
    $i = 0;
    $l = count($_SESSION['fmldate']);
    for ($i = 0; $i < $l; $i++) {
        printf("\nTrip %s\n", ($i + 1));
        printf("Meal and Lodging Date: %s\n", $_SESSION['fmldate'][$i]);
        printf("Meal Expenses: %s\n", $_SESSION['fmeals'][$i]);
        printf("Lodging expenses: %s\n", $_SESSION['flodging'][$i]);
    }
}

printf("</pre>");
?>
