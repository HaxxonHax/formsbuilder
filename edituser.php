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
        <title>Forms Central - Edit User</title>
        <link href="form.css" rel="stylesheet" type="text/css" />
        <script>
            function validateForm() {
                var flag = 0;
                
                // If there's only one element, there is no array, and no length
                if (!document.forms["edituserform"]["row[]"].length) {
                    if (document.forms["edituserform"]["row[]"].checked) {
                      flag=1;
                    }
                } else {
                    for (var i = 0; i < document.forms["edituserform"]["row[]"].length; i++) {
                        if (document.forms["edituserform"]["row[]"][i].checked) {
                            flag++;
                        }
                    }
                }

                if (flag == 0) {
                    alert("You must select at least one!");
                    return false;
                } else {
                    var r = window.confirm("Are you sure you want to modify the selected user(s)?");
                    r=true;
                    if (r == true) {
                        return true;
                    } else {
                        return false;
                    }
                }
                return true;
            }
        </script>
    </head>
    <body>
        <?php
        if (isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) > 0) {
            echo '<ul class="err">';
            foreach ($_SESSION['ERRMSG_ARR'] as $msg) {
                echo '<li>', $msg, '</li>';
            }
            echo '</ul>';
            unset($_SESSION['ERRMSG_ARR']);
        }
        ?>
        <header class="body">
            <h1>Forms Central - Edit User</h1>
        </header>
        <section class="full">
            <form id="edituserform" method="post" action="edituser-modify.php" onsubmit="return validateForm()" >
                <label>Please check the user you would like to edit</label>
                <div id="table">
                    <div class="firstLine">
                        <p>
                            <b> <span class="box">&nbsp;</span> <span class="login">Login</span> <span class="fname">First Name</span> <span class="lname">Last Name</span> <span class="email">Email</span> <span class="agency">Agency</span>
                        </p></b>
                    </div>
                    <?php
                    //Include database connection details
                    require_once ('config.php');
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

                    $qry = "SELECT member_id,login,firstname,lastname,login,email,agency FROM members LIMIT 0, 30";
                    $result = mysql_query($qry);
                    if ($result) {
                        if (mysql_num_rows($result) > 0) {
                            while ($row = mysql_fetch_assoc($result)) {
                                $rowid = $row['member_id'];
                                $rowein = $row['login'];
                                $rowfname = $row['firstname'];
                                $rowlname = $row['lastname'];
                                $rowemail = $row['email'];
                                $rowagcy = $row['agency'];
                                if ($row['member_id'] != $_SESSION['SESS_MEMBER_ID'] && $row['login'] != "admin") {
                                    printf("<p>\n <span class=\"box\"><input type=\"radio\" name=\"row[]\" value=\"%s\"></span>\n", $rowid);
                                    printf(" <span class=\"login\">%s&nbsp;</span>\n", $rowein);
                                    printf(" <span class=\"fname\">%s&nbsp;</span>\n", $rowfname);
                                    printf(" <span class=\"lname\">%s&nbsp;</span>\n", $rowlname);
                                    printf(" <span class=\"email\">%s&nbsp;</span>\n", $rowemail);
                                    printf(" <span class=\"agency\">%s&nbsp;</span>\n</p>\n\n", $rowagcy);
                                }
                            }
                        }
                        @mysql_free_result($result);
                    } else {
                        die("Query failed");
                    }
                    ?>
                    <div class="lastLine"></div>
                </div>
                <br>
                <input id="submit" type="submit" name="Submit" value="Edit User" />
            </form>
            <form method="post" action="admin.php">
                <input id="submit" name="submit" type="submit" value="Back">
            </form>
            <form method="post" action="logout.php">
                <input id="submit" name="submit" type="submit" value="Logout">
            </form>
        </section>
    </body>
</html>
