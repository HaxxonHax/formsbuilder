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
                var x = vform["formname"].value;
                if (x == null || x == "") {
                    alert("Please enter a form name");
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
            <h1>Forms Central - Create Form</h1>
        </header>
        <section class="body">
            <form id="adduserform" method="post" action="create-exec.php" onsubmit="return validateForm()" >
                <!-- Form Info -->
                <label>Form Name</label>
                <input name="formname" type="text" class="textfield" id="formname" />
                <label>Form Description</label>
                <input name="description" type="text" class="textfield" id="description" />
                <label>Form Group</label>
                <input name="formname" type="text" class="textfield" id="formgroup" />
                <!-- Form Building -->
                <!-- Action Section -->
                <label>Action</label>
            </form>
            <form method="post" action="create-exec.php">
                <input id="submit" name="submit" type="submit" value="Create">
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
