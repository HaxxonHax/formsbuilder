<?php
session_start();
if (isset($_SESSION['ERRMSG_ARR']) && $_SESSION['ERRMSG_ARR'][0] != '') {
    print $_SESSION['ERRMSG_ARR'][0];
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>Forms Central Login</title>
        <meta name="description" content="" />
        <meta name="author" content="Alan T. Landucci-Ruiz (eightballmclaw-at-gmail-dot-com)" />
        <meta name="viewport" content="width=device-width; initial-scale=1.0" />

        <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
        <link href="form.css" rel="stylesheet" type="text/css">
    </head>
    <body>

        <header class="body">
            <h1>Forms Central Login</h1>
        </header>

        <section class="body">
            <form id="loginForm" name="loginForm" method="post" action="login-exec.php">
                <label>Username</label>
                <input name="username" placeholder="username">
                <label>Password</label>
                <input name="password" type="password"  placeholder="password">
                <input id="submit" name="submit" type="submit" value="Login">
            </form>
        </section>

        <footer class="body">
            <p>
                <!--    &copy; Copyright  by Alan T. Landucci-Ruiz (eightballmclaw-at-gmail-dot-com) -->
            </p>
        </footer>
    </body>
</html>
