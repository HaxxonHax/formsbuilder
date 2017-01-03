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
$rowSelected = $_POST['row'];

// If nothing was selected.
if (empty($rowSelected)) {
    echo("You didn't select anything.");
    session_write_close();
    header("location: deluser.php");
    exit();
}

//Create INSERT query
$qry = "";
$m = "";
$N = count($rowSelected);
if ($N > 1) {
    $qry = $qry . "DELETE FROM members WHERE member_id = " . $rowSelected[0];
} else {
    $qry = $qry . "DELETE FROM members WHERE ((member_id = " . $rowSelected[0] . ")";
    for ($i = 1; $i < $N; $i++) {
        $qry = $qry . "OR (member_id = " . $rowSelected[$i] . ")";
    }
    $qry = $qry . ");";
}
$qry = $qry . ";";
printf("%s", $qry);
$result = @mysql_query($qry);

//Check whether the query was successful or not
if ($result) {
    header("location: deluser-success.php");
    exit();
} else {
    die("Query failed");
}
?>
