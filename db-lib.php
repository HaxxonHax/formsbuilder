<?php
    require_once('config.php');
    function db_connect($db_host, $db_user, $db_password)
    {
        if (DB_TYPE == 'MYSQL')
        {
            $link = mysql_connect($db_host, $db_user, $db_password);
            return $link;
        }
        else {
            printf("Sorry, we do not currently support database of type %s\n",DB_TYPE);
        }
    }

    function db_error()
    {
        if (DB_TYPE == 'MYSQL')
        {
            mysql_error();
        }
        else {
            printf("Sorry, we do not currently support database of type %s\n",DB_TYPE);
        }    
    }
    
    function db_select_db($db_database)
    {
        if (DB_TYPE == 'MYSQL')
        {
            $db = mysql_select_db($db_database);
            return $db;
        }
        else {
            printf("Sorry, we do not currently support database of type %s\n",DB_TYPE);
        }    
    }
    
    function db_real_escape_string($dbstr)
    {
        if (DB_TYPE == 'MYSQL')
        {
            $dbs = mysql_real_escape_string($dbstr);
            return $dbs;
        }
        else {
            printf("Sorry, we do not currently support database of type %s\n",DB_TYPE);
        }
    }
        
    function db_query($query)
    {
        if (DB_TYPE == 'MYSQL')
        {
            $dbs = mysql_query($query);
            return $dbs;
        }
        else {
            printf("Sorry, we do not currently support database of type %s\n",DB_TYPE);
        }
    }

    function db_num_rows($res)
    {
        if (DB_TYPE == 'MYSQL')
        {
            $dbs = mysql_num_rows($res);
            return $dbs;
        }
        else {
            printf("Sorry, we do not currently support database of type %s\n",DB_TYPE);
        }
    } 

    function db_fetch_assoc($res)
    {
        if (DB_TYPE == 'MYSQL')
        {
            $dbs = mysql_fetch_assoc($res);
            return $dbs;
        }
        else {
            printf("Sorry, we do not currently support database of type %s\n",DB_TYPE);
        }
    } 

?>
