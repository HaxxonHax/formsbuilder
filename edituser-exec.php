<?php
//Start session
session_start();

if (!(isset($_SESSION['SESS_MEMBER_ID']) && $_SESSION['SESS_MEMBER_ID'] != '')) {
    header("Location: login.php");
} else {
    if ($_SESSION['SESS_MEMBER_ROLE'] != "admin") {
        header("Location: index.php");
    }
}
//Include database connection details
require_once ('config.php');

//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;

//Connect to mysql server
$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$link) {
    die('Failed to connect to server: ' . mysql_error());
}

//Select database
$db = mysql_select_db(DB_DATABASE);
if (!$db) {
    die("Unable to select database");
}

//Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
    $str = @trim($str);
    if (get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return mysql_real_escape_string($str);
}

//Sanitize the POST values
$memberid = clean($_POST['memberid']);
$fname = clean($_POST['first']);
$lname = clean($_POST['last']);
$login = clean($_POST['login']);
$ein = clean($_POST['ein']);
$password = clean($_POST['password']);
$cpassword = clean($_POST['cpassword']);
$frole = clean($_POST['role']);
$femail = clean($_POST['email']);
$agency = clean($_POST['agencyselect']);
$agcyaddr = clean($_POST['agencyaddress']);
$fagency = clean($_POST['agencyinput']);
$fagcyaddr = clean($_POST['agencyaddressinput']);

//Input Validations
if (strcmp($password, $cpassword) != 0) {
    $errmsg_arr[] = 'Passwords do not match';
    $errflag = true;
}

//If there are input validations, redirect back to the registration form
if ($errflag) {
    $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
    session_write_close();
    header("location: adduser.php");
    exit();
}

//Create UPDATE query
if ( $password != '') {
    $qry = "REPLACE INTO members(member_id, ein, firstname, lastname, login, passwd, role, email, agency, agcyaddr) VALUES('$memberid','$ein', '$fname','$lname','$login','" . md5($_POST['password']) . "','$frole','$femail', '$fagency','$fagcyaddr')";
//    $qry = "UPDATE members SET ein = '$ein', firstname = '$fname', lastname = '$lname', login = '$login', passwd = '" . md5($_POST['password']) . "', role = '$frole', email = '$femail', agency = '$fagency', agcyaddr = '$fagcyaddr') WHERE member_id = $memberid";
} else {
    $qry = "REPLACE INTO members(member_id, ein, firstname, lastname, login, role, email, agency, agcyaddr) VALUES('$memberid','$ein', '$fname','$lname','$login','$frole','$femail', '$fagency','$fagcyaddr')";
//    $qry = "UPDATE members SET ein = '$ein', firstname = '$fname', lastname = '$lname', login = '$login', role = '$frole', email = '$femail', agency = '$fagency', agcyaddr = '$fagcyaddr') WHERE member_id = $memberid";
}
$result = @mysql_query($qry);

//Check whether the query was successful or not
if ($result) {
    header("location: edituser-success.php");
    exit();
} else {
    die("Query failed: ". $qry);
}
?>
