<?PHP

session_start();

if (!(isset($_SESSION['SESS_MEMBER_ID']) && $_SESSION['SESS_MEMBER_ID'] != '')) {
    header("Location: login.php");
}
if ($_SESSION['SESS_MEMBER_ROLE'] != "admin") {
    header("Location: index.php");
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
    header("location: edituser.php");
    exit();
}

//Create SELECT query
$qry = "";
$qry = $qry . "SELECT * FROM members WHERE member_id = " . $rowSelected[0];
$qry = $qry . ";";
$result = @mysql_query($qry);
$memberid = $rowSelected[0];

if ($result) {
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result)) {
            $ein = $row['ein'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $login = $row['login'];
            $passwd = $row['passwd'];
            $role = $row['role'];
            $email = $row['email'];
            $myagency = $row['agency'];
            $myagcyaddr = $row['agcyaddr'];
        }
    }
} else {
    die("Query failed");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Login Form</title>
        <link href="form.css" rel="stylesheet" type="text/css" />
        <script>
            function toggleview(id1, id2, txt1) {
                var parnt = document.getElementById(id1);
                var child = document.getElementById(id2);
                var field = document.getElementById(id2 + "id");
                var matchtxt = txt1;
                if (parnt.options[parnt.selectedIndex].text == matchtxt) {
                    child.className = "itemshown";
                } else {
                    child.className = "itemhidden";
                    field.value = parnt.options[parnt.selectedIndex].text;
                }
            }

            function setvisible(id1) {
                var obj1 = document.getElementById(id1);
                if (obj1.className == "itemhidden") {
                    obj1.className = "itemshown";
                }
            }

            function validateForm() {
                var vform = document.forms["edituserform"];
                var x = vform["first"].value;
                if (x == null || x == "") {
                    alert("Please enter the employee's first name");
                    return false;
                }
                var x = vform["last"].value;
                if (x == null || x == "") {
                    alert("Please enter the employee's last name");
                    return false;
                }
                var x = vform["login"].value;
                if (x == null || x == "") {
                    alert("Please enter a valid username");
                    return false;
                }
                var x = vform["ein"].value;
                if (x == null || x == "") {
                    alert("EIN must be filled out");
                    return false;
                }
                var x = vform["agencyinputid"].value;
                if (x == null || x == "") {
                    alert("Please select an agency");
                    return false;
                }
                var x = vform["agencyaddressinputid"].value;
                if (x == null || x == "") {
                    alert("Please select an agency address");
                    return false;
                }
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
            <h1>Forms Central - Modify User</h1>
        </header>
        <section class="body">
            <form id="edituserform" method="post" action="edituser-exec.php" onsubmit="return validateForm()" >
                <?php
                    printf("<input name=\"memberid\" type=\"hidden\" class=\"hidden\" id=\"memberid\" value=\"%s\" />\n",$memberid);
                    printf("<label>First Name </label>\n");
                    printf("<input name=\"first\" type=\"text\" class=\"textfield\" id=\"first\" value=\"%s\" />\n",$firstname);
                    printf("<label>Last Name </label>\n");
                    printf("<input name=\"last\" type=\"text\" class=\"textfield\" id=\"last\" value=\"%s\" />\n",$lastname);
                    printf("<label>Username</label>\n");
                    printf("<input name=\"login\" type=\"text\" class=\"textfield\" id=\"login\" value=\"%s\"/>\n",$login);
                    printf("<label>EIN</label>\n");
                    printf("<input name=\"ein\" type=\"text\" class=\"textfield\" id=\"ein\" value=\"%s\"/>\n",$ein);
                    printf("<label>Agency</label>\n");
                    printf("<select id=\"agencyselect\" onchange=\"javascript:toggleview('agencyselect', 'agencyinput', 'My agency is not listed')\">\n");
                 ?>
                    <option> Select one of the following</option>
                    <option value="My agency is not listed">My agency is not listed</option>

            <?php
                //Include database connection details
                require_once ('config.php');

                $option1text='';
                $option2text='';
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

                $qry = "SELECT DISTINCT agency FROM members;";
                $result = mysql_query($qry);
                if ($result) {
                    if (mysql_num_rows($result) > 0) {
                        while ($row = mysql_fetch_assoc($result)) {
                            $agency = $row['agency'];
                            if ( $agency == $myagency )
                            {
                              $option1text .= " <option value=\"" . $agency . "\" selected>" . $agency . "&nbsp;</option>\n";
                            } else {
                              $option1text .= " <option value=\"" . $agency . "\">" . $agency . "&nbsp;</option>\n";
                            }
                        }
                    }
                } else {
                    die("Query failed");
                }

                $qry = "SELECT DISTINCT agcyaddr FROM members;";
                $result = mysql_query($qry);
                if ($result) {
                    if (mysql_num_rows($result) > 0) {
                        while ($row = mysql_fetch_assoc($result)) {
                            $agcyaddr = $row['agcyaddr'];
                            if ( $agcyaddr == $myagcyaddr ) {
                              $option2text .= " <option value=\"" . $agcyaddr . "\" selected>" . $agcyaddr . "&nbsp;</option>\n";
                            } else {
                              $option2text .= " <option value=\"" . $agcyaddr . "\">" . $agcyaddr . "&nbsp;</option>\n";
                            }
                        }
                    }
                    @mysql_free_result($result);
                    print $option1text;
                } else {
                    die("Query failed");
                }
            ?>
                </select>
                <div id="agencyinput" class="itemhidden">
                    <label>Agency Name</label>
                    <?php
                        printf("<input name=\"agencyinput\" id=\"agencyinputid\" value=\"%s\">\n",$myagency);
                    ?>
                </div>
                <label>Agency Address</label>
                <select id="agencyaddress" onchange="javascript:toggleview('agencyaddress', 'agencyaddressinput', 'My address is not listed')">
                    <option> Select one of the following</option>
                    <option value="My address is not listed">My address is not listed</option>
                    <?php
                        print $option2text;
                    ?>
                </select>
                <div id="agencyaddressinput" class="itemhidden">
                    <label>Work Address</label>
                    <?php
                        printf("<input name=\"agencyaddressinput\" id=\"agencyaddressinputid\" value=\"%s\">\n",$myagcyaddr);
                    ?>
                </div>
                <label>User Role</label>
                <?php
                   if ($role == "user") {
                       printf("<input type=\"radio\" name=\"role\" value=\"user\" checked=\"checked\">Form User - Can only fill out/submit forms<br>\n");
                       printf("<input type=\"radio\" name=\"role\" value=\"admin\">Admin - Can also create and edit form users<br>\n");
                   } else {
                       printf("<input type=\"radio\" name=\"role\" value=\"user\" >Form User - Can only fill out/submit forms<br>\n");
                       printf("<input type=\"radio\" name=\"role\" value=\"admin\" checked=\"checked\">Admin - Can also create and edit form users<br>\n");
                   }
                ?>
                <label>Password</label>
                <input name="password" type="password" class="textfield" id="password" />
                <label>Confirm Password </label>
                <input name="cpassword" type="password" class="textfield" id="cpassword" />
                <label alt="Employee's email address">Email Address</label>
                <?php
                  printf("<input name=\"email\" type=\"text\" type=\"email\" class=\"textfield\" id=\"email\" value=\"%s\"/>\n",$email);
                ?>
                <input id="submit" type="submit" name="Submit" value="Change User" />
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
