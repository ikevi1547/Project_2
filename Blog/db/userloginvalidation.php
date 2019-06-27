<?php

require 'db.php';

$nam = $_POST['name'];
$pa = $_POST['pass'];
if(isset($_POST['name']))
    {
        $QUERY = "SELECT `USERNAME`,`PASS` FROM USER WHERE USERNAME='$nam'";
        $RunQuery = mysqli_query($conn, $QUERY);
        if($GETINFO = mysqli_Fetch_array($RunQuery))
        {
            if($GETINFO[1]==$pa)
                {
                    echo 'Y';
                }
            else
                {
                    echo 'N';
                }
        }
        else
        {
            echo 'NA';
        }
    }