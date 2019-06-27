<?php
require '../db/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Author" content="Kevin Peter J">
    <meta name="Description" content="Sign up page">
    <link rel="icon" href="../img/Title/title.ico">
    <title>SignUpForm</title>
    <!-- Including CascadeSheet Files -->
    <link rel="stylesheet" href="../lib/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="../lib/css/blog.css" type="text/css">
</head>
<body>
    <div class="container">
        <div class="jumbotron text-center">
            <h1>Signup Form</h1> 
            <p>Enter your details to create a blog account</p>
            <?php
            if(!isset($_GET['admin-sign'])){
            ?>
            <p><a href="accocreate.php?admin-sign=1" style="cursor:pointer">If you have an admin access code, then click here to sign-up as an admin..</a></p> 
            <?php
            }
            elseif(isset($_GET['admin-sign']))
            {
            ?>
            <p><a href="accocreate.php" style="cursor:pointer">If you don't have an admin access code, then click here to sign-up as an General User..</a></p> 
            <?php
            }
            ?>
        </div>
        <div class="row">
            <div class="col-sm-4"></div>
            <!--Signup Form Start-->
            <div class="col-sm-4">
                <form method="POST">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="signupname" type="text" class="form-control" name="name" placeholder="User Name">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input id="signupemail" type="text" class="form-control" name="email" placeholder="Email">
                    </div>
                    <?php if(isset($_GET['admin-sign']))
                    {
                    ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                        <input id="signupcode" type="text" class="form-control" name="code" placeholder="Access Code Eg. INFI">
                    </div>
                    <?php
                    }
                    ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                        <input id="signupnumber" type="text" class="form-control" name="number" placeholder="Mobile Number">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="signuppass" type="password" class="form-control" name="password" placeholder="Password">
                    </div><br>
                    <?php if(!isset($_GET['admin-sign']))
                    {
                    ?>
                    <button type="button" onclick="signup()" class="btn btn-success btn-block">Submit</button>
                    <?php
                    }
                    elseif(isset($_GET['admin-sign']))
                    {
                    ?>
                    <button type="button" onclick="signupAdmin()" class="btn btn-success btn-block">Submit</button>
                    <?php
                    }
                    ?>
                </form>
                <br>
                <p class="text-center"><a href="accologin.php" style="cursor:pointer">Already have an account?</a>/ <a href="../" style="cursor:pointer">Return Feed's</a></p>
            </div>
            <!-- Signup Form End -->
            <div class="col-sm-4"></div>
        </div>
    </div>

    <!-- alertscreen block -->
    <div class="content_wrapper">
       <div id="alertPage"></div>
            <div class="alert" id="alertBox">
                <div id="box">
                    <div id="error" class="alert alert-warning">
                        <a onclick="closewarning()" href="#" class="close" aria-label="close">&times;</a>
                        <strong>Warning! </strong><span id="warnmsg">Indicates a warning that might need attention.</span>
                    </div>
                    <div id="success" class="alert alert-success">
                        <a onclick="closewarning()" href="#" class="close" aria-label="close">&times;</a>
                        <strong>Success! </strong><span id="successmsg">Indicates a warning that might need attention.</span>
                    </div>
                </div>
            </div>       
    </div>
    <!-- alertscreen block end -->

</body>
    <!-- Including Script Files -->
    <script src="../lib/js/jquery.js"></script>
    <script src="../lib/js/bootstrap.js"></script>
    <script src="../lib/js/blog.js"></script>
</html>