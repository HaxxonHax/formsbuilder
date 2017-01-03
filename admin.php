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
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>Admin Page</title>
        <meta name="description" content="" />
        <meta name="author" content="landuca" />

        <meta name="viewport" content="width=device-width; initial-scale=1.0" />

        <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
        <link href="form.css" rel="stylesheet" type="text/css">
    </head>
    <body>

        <header class="body">
            <h1>Admin Page</h1>
        </header>

        <section class="body">
            <form method="post" action="adduser.php">
                <input id="submit" name="submit" type="submit" value="Add User">
            </form>
            <form method="post" action="deluser.php">
                <input id="submit" name="submit" type="submit" value="Remove user">
            </form>
            <form method="post" action="edituser.php">
                <input id="submit" name="submit" type="submit" value="Edit user">
            </form>
            <form method="post" action="index.php">
                <input id="submit" name="submit" type="submit" value="Back">
            </form>
            <form method="post" action="logout.php">
                <input id="submit" name="submit" type="submit" value="Logout">
            </form>
            <p>
                <!--    &copy; Copyright  by landuca -->
            </p>
        </section>
    </body>
</html>
