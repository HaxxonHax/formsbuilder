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
    require_once('config.php');
    require_once('db-lib.php');
    
    //Array to store validation errors
    $errmsg_arr = array();
    
    //Validation error flag
    $errflag = false;
    
    //Connect to db server
    $link = db_connect(DB_HOST, DB_USER, DB_PASSWORD);
    if(!$link) {
        die('Failed to connect to server: ' . db_error());
    }
    
    //Select database
    $db = db_select_db(DB_DATABASE);
    if(!$db) {
        die("Unable to select database");
    }
    
    //Function to sanitize values received from the form. Prevents SQL injection
    function clean($str) {
        $str = @trim($str);
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return db_real_escape_string($str);
    }
    
    //Sanitize the POST values
    $login = clean($_POST['username']);
    $password = clean($_POST['password']);
    
    //Input Validations
    if($login == '') {
        $errmsg_arr[] = 'Login ID missing';
        $errflag = true;
    }
    if($password == '') {
        $errmsg_arr[] = 'Password missing';
        $errflag = true;
    }
    
    //If there are input validations, redirect back to the login form
    if($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: login.php");
        //printf("%s",$errflag);
        exit();
    }
    
    //Create query
    $qry="SELECT * FROM members WHERE login='$login' AND passwd='".md5($_POST['password'])."'";
    $result=db_query($qry);
    
    //Check whether the query was successful or not
    if($result) {
        if(db_num_rows($result) == 1) {
            //Login Successful
            session_regenerate_id();
            $member = db_fetch_assoc($result);
            $_SESSION['SESS_MEMBER_ID'] = $member['member_id'];
            $_SESSION['SESS_FIRST_NAME'] = $member['firstname'];
            $_SESSION['SESS_LAST_NAME'] = $member['lastname'];
            $_SESSION['SESS_USERNAME'] = $member['login'];
            $_SESSION['SESS_MEMBER_ROLE'] = $member['role'];
            session_write_close();
            header("location: index.php");
            exit();
        }else {
            //Login failed
            header("location: login-failed.php");
            exit();
        }
    }else {
        die("Query failed");
    }
?>
