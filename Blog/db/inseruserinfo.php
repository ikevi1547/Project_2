<?php

require 'db.php';

$nam = $_POST['name'];
$em = $_POST['email'];
$nu = $_POST['number'];
$pa = $_POST['pass'];
$cod = $_POST['code'];
$acc = true;

if($cod=='INFI')
    {
        $admin_permission = 'GRANT';
    }
elseif($cod=='USER')
    {
        $admin_permission = 'NO';
    }
else
    {
        echo 'FAIL';
        $acc = false;
    }


if(isset($_POST['name']) && $acc)
    {
        $QUERY = "SELECT * FROM USER WHERE USERNAME='$nam'";
        $RunQuery = mysqli_query($conn, $QUERY);
        if(mysqli_Fetch_array($RunQuery))
        {
            echo 'D';
        }
        else
        {
        $QUERY = "INSERT INTO USER 
        (USERNAME,EMAIL,MOBILENUMBER,PASS,ADMIN_ACCESS) 
        VALUES 
        ('$nam','$em','$nu','$pa','$admin_permission')";
        if($conn->query($QUERY)===True)
            {
                echo 'Y';
            }
            else
            {
                echo 'N';
            }
        }
    }