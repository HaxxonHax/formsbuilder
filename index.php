<?PHP
session_start();
if (!(isset($_SESSION['SESS_MEMBER_ID']) && $_SESSION['SESS_MEMBER_ID'] != '')) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8" />

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>Forms Central</title>
        <meta name="description" content="" />
        <meta name="author" content="landuca" />
        
        <meta name="viewport" content="initial-scale=1.0" />

        <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
        <link href="form.css" rel="stylesheet" type="text/css">
        <script>
            function toggleview(id1, id2, txt1) {
                var parnt = document.getElementById(id1);
                var child = document.getElementById(id2);
                var matchtxt = txt1;
                if (parnt.options[parnt.selectedIndex].text == matchtxt) {
                    child.className = "itemshown";
                } else {
                    child.className = "itemhidden";
                }
            }

            function setvisible(id1) {
                var obj1 = document.getElementById(id1);
                if (obj1.className == "itemhidden") {
                    obj1.className = "itemshown";
                }
            }

        </script>
    </head>
        <br>
        <header class="body">
            <h1>Forms Central</h1>
        </header>
    <body>
        <section class="body">
        <ul>
        <?php
        if (isset($_SESSION['SESS_MEMBER_ROLE']) && $_SESSION['SESS_MEMBER_ROLE'] == 'admin') {
            printf("<li>\n<a href=\"admin.php\">Add/Change/Remove Form Users</a>\n</li>\n");
        }
    ?>
    <li><a href="forms.php">My Forms</a></li>
    <li><a href="kb.php">Knowledge Base (Howto)</a></li>
</ul>
</section>

<footer class="body">
<form method="post" action="logout.php">
<input id="submit" name="submit" type="submit" value="Logout">
</form>
<p>
<!-- &copy; Copyright  by Alan T. Landucci-Ruiz (eightballmclaw-at-gmail-dot-com) -->
</p>
</footer>
</body>
</html>
