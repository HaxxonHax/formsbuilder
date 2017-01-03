<?PHP

session_start();

if (!(isset($_SESSION['SESS_MEMBER_ID']) && $_SESSION['SESS_MEMBER_ID'] != '')) {
    header("Location: login.php");
}
if ($_SESSION['SESS_MEMBER_ROLE'] != "admin") {
    header("Location: index.php");
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
                var vform = document.forms["adduserform"];
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
                var x = vform["password"].value;
                if (x == null || x == "") {
                    alert("Please enter a valid password");
                    return false;
                }
                var x = vform["cpassword"].value;
                if (x == null || x == "") {
                    alert("Please enter a valid password");
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
            <h1>Forms Central - Add User</h1>
        </header>
        <section class="body">
            <form id="adduserform" method="post" action="adduser-exec.php" onsubmit="return validateForm()" >
                <label>First Name </label>
                <input name="first" type="text" class="textfield" id="first" />
                <label>Last Name </label>
                <input name="last" type="text" class="textfield" id="last" />
                <label>Username</label>
                <input name="login" type="text" class="textfield" id="login" />
                <label>EIN</label>
                <input name="ein" type="text" class="textfield" id="ein" />
                <label>Agency</label>
                <select id="agencyselect" onchange="javascript:toggleview('agencyselect', 'agencyinput', 'My agency is not listed')">
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
                            $option1text .= " <option value=\"" . $agency . "\">" . $agency . "&nbsp;</option>\n";
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
                            $option2text .= " <option value=\"" . $agcyaddr . "\">" . $agcyaddr . "&nbsp;</option>\n";
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
                    <input name="agencyinput" id="agencyinputid" placeholder="Street Number and Name">
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
                    <input name="agencyaddressinput" id="agencyaddressinputid" placeholder="12345 Street, City, ST 12345-0000">
                </div>
                <label>User Role</label>
                <input type="radio" name="role" value="user" checked="checked">Form User - Can only fill out/submit forms<br>
                <input type="radio" name="role" value="admin">Admin - Can also create and edit form users<br>
                <label>Password</label>
                <input name="password" type="password" class="textfield" id="password" />
                <label>Confirm Password </label>
                <input name="cpassword" type="password" class="textfield" id="cpassword" />
                <label alt="Employee's email address">Email Address</label>
                <input name="email" type="text" type="email" class="textfield" id="email" />
                <input id="submit" type="submit" name="Submit" value="Register" />
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
