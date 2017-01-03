<?PHP

session_start();

if (!(isset($_SESSION['SESS_MEMBER_ID']) && $_SESSION['SESS_MEMBER_ID'] != '')) {
    header("Location: login.php");
} else {
    if ($_SESSION['SESS_MEMBER_ROLE'] != "admin") {
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>User(s) Successfully Deleted</title>
<link href="form.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <header class="body"><h1>User(s) Successfully Deleted!</h1></header>
    <section class="body"><a href="deluser.php">Click here</a> to return to the Delete User page.</p></section>
    
</body>
</html>
