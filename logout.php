<?php
    //Start session
    session_start();
    
    //Unset the variables stored in session
    unset($_SESSION['SESS_MEMBER_ID']);
    unset($_SESSION['SESS_FIRST_NAME']);
    unset($_SESSION['SESS_LAST_NAME']);
    unset($_SESSION['SESS_USERNAME']);
    unset($_SESSION['SESS_MEMBER_ROLE']);
    session_unset();
    session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="viewport" content="width=device-width; initial-scale=1.0" />

<title>You Have Successfully Logged Out</title>
<link href="form.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <header class="body"><h1>Forms Central Logout</h1></header>

<p align="center">&nbsp;</p>
<h4 align="center" class="err">You have been logged out.</h4>
<p align="center">Click here to <a href="login.php">Login</a></p>
</body>
</html>
