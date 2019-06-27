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
            <h1>Login Form</h1> 
            <p>Enter your details below</p> 
        </div>
        <div class="row">
            <div class="col-sm-4"></div>
            <!--Signin Form Start-->
            <div class="col-sm-4">
                <form method="POST">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="signinname" type="text" class="form-control" name="name" placeholder="User Name">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="signinpass" type="password" class="form-control" name="password" placeholder="Password">
                    </div><br>
                    <button type="button" onclick="signin()" class="btn btn-success btn-block">Login</button>
                </form>
                <br>
                <p class="text-center"><a href="accocreate.php" style="cursor:pointer">Need to Create an account?</a>/ <a href="../" style="cursor:pointer">Return Feed's</a></p>
            </div>
            <!-- Signin Form End -->
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

