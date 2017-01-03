<?PHP

session_start();

if (!(isset($_SESSION['SESS_MEMBER_ID']) && $_SESSION['SESS_MEMBER_ID'] != '')) {
    header("Location: login.php");
} else {
    if ($_SESSION['SESS_MEMBER_ROLE'] != "admin") {
        $role = 'admin';
    }
}
// Need to validate with forms-validate.php first and get role.
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>Forms Page</title>
        <meta name="description" content="" />
        <meta name="author" content="landuca" />

        <meta name="viewport" content="width=device-width; initial-scale=1.0" />

        <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
        <link href="form.css" rel="stylesheet" type="text/css">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $( function() {
                $( "#sortable" ).sortable({
                    revert: true
                });
                $( "#draggable" ).draggable({
                    connectToSortable: "#sortable",
                    helper: "clone",
                    revert: "invalid"
                });
                $( "ul, li" ).disableSelection();
            } );
        </script>
    </head>
    <body>

        <header class="body">
            <h1>Forms Page</h1>
        </header>

        <section class="body">

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

                $qry = "SELECT member_id,role FROM members WHERE member_id = " . $_SESSION['SESS_MEMBER_ID'] . ";";
                $result = mysql_query($qry);
                if ($result) {
                    if (mysql_num_rows($result) > 0) {
                        while ($row = mysql_fetch_assoc($result)) {
                            $rowid = $row['member_id'];
                            $rowrole = $row['role'];
                            if ($row['member_id'] != $_SESSION['SESS_MEMBER_ID'] && $row['login'] != "admin") {
                                printf("<p>\n <span class=\"box\"><input type=\"radio\" name=\"row[]\" value=\"%s\"></span>\n", $rowid);
                                printf(" <span class=\"member_id\">%s&nbsp;</span>\n", $rowid);
                                printf(" <span class=\"role\">%s&nbsp;</span>\n", $rowrole);
                            }
                        }
                    }
                    @mysql_free_result($result);
                } else {
                    die("Query failed");
                }
            ?>



            <form method="post" action="form1.php">
                <input id="submit" name="submit" type="submit" value="Form 1">
            </form>
            <?php
                if ( isset($_SESSION['SESS_MEMBER_ROLE']) && $_SESSION['SESS_MEMBER_ROLE'] == 'admin' ) {
                    printf("<form method=\"post\" action=\"form-create.php\">\n");
                    printf("    <input id=\"submit\" name=\"submit\" type=\"submit\" value=\"Create Form\">");
                    printf("</form>\n");
                }
            ?>
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
        <ul>
            <li id="draggable" class="ui-state-highlight">Drag me down</li>
        </ul>
 
        <ul id="sortable">
            <li class="ui-state-default">Item 1</li>
            <li class="ui-state-default">Item 2</li>
            <li class="ui-state-default">Item 3</li>
            <li class="ui-state-default">Item 4</li>
            <li class="ui-state-default">Item 5</li>
        </ul>
    </body>
</html>
