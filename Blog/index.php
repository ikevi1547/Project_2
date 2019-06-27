<?php

// Including main files

require 'db/db.php';
require 'sub/oop.php';

// User status maintain object

$stat_upd = new login_update();

// strip data special char object

$strip = new special();

// setting the user name in cookie value if the user logged in or unset

if(isset($_GET['namelogin']))
    {
        $name = $_GET['namelogin'];
        echo 'Y';
        $stat_upd->set_status('Y');
        setcookie('loginUser',$name,time()+(86400),'../index.php');
    }
elseif(isset($_POST['namelogout']))
    {
        $stat_upd->set_status('N');
        echo $_COOKIE['loginUser'];
        setcookie('loginUser',"",time()-(86400),'../index.php');
    }
else
    {

// main body block content start

    $admin = false;
       
    // fetching the user details if he/she logged in

    if(isset($_COOKIE['loginUser']))
    {
        $log = $_COOKIE['loginUser'];
        $query = "SELECT ADMIN_ACCESS FROM USER WHERE USERNAME='$log'";
        $Run_Query = mysqli_query($conn, $query);
        if($cod_permission = mysqli_Fetch_array($Run_Query))
            {
                if($cod_permission[0]=='GRANT')
                    {
                        $admin = true;
                    }
                else
                    {
                        $admin = false;
                    }
            }
    }
?>

<!-- HTML ELEMENT START -->

<!DOCTYPE html>
<html lang="en">

    <!-- HEAD SECTION START -->

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="Author" content="Kevin Peter J">
        <meta name="Description" content="Infiniti Blog">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" href="img/Title/title.ico">
        <title>Infiniti Software Solution - Blog</title>
        <!-- Including CascadeSheet Files -->
        <link rel="stylesheet" href="lib/css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="lib/css/blog.css" type="text/css">
    </head>

    <!-- HEAD SECTION END -->

    <!-- Social link plugin script -->

    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5d1356da741621001275518d&product='inline-share-buttons' async='async'>
    </script>

    <!-- BODY SECTION START -->

    <body>

        <!-- NavBar Skeleton Start -->

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="../Blog/index.php">Infiniti Software Solutions</a>
                </div>
                <?php if($admin)
                {
                ?>
                <ul class="nav navbar-nav navbar-left">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Admin Panel
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="../Blog/index.php?manage-blogs=true">Manage Blogs</a></li>
                            <li><a href="../Blog/index.php?manage-categories=true">Manage Categories</a></li>
                            <li><a href="../Blog/index.php?manage-tags=true">Manage Tags</a></li>
                            <li><a href="../Blog/index.php?manage-choice=true">Editor's Choice</a></li>
                            <li><a href="../Blog/index.php?dashboard=true">Dashboard</a></li>
                        </ul>
                    </li>
                </ul>
                <?php 
                }
                ?>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    if(!isset($_COOKIE['loginUser']))
                    {
                        $stat_upd->set_status('N');
                    ?>
                        <li><a href="sub/accocreate.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                        <li><a href="sub/accologin.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    <?php
                    }
                    else
                    {
                    ?>
                        <li style="position:relative; top:15px;"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_COOKIE['loginUser']; ?> &nbsp; </li>
                        <li><a onclick="logout()" href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </nav>

        <!-- NavBar Skeleton End -->

        <!-- CONTENT SKELETON START -->

        <div class="container-fluid">
            <div class="row content">

                <!-- Side NavBar Start -->

                <div class="col-sm-3 sidenav">
                    <h4><img src="img/Title/title.ico"/> INFI Blogs</h4>
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active"><a href="../Blog/index.php">All Posts - Categories</a></li>
                        <?php
                        $run_query = mysqli_query($conn,"SELECT BLOG_CATEGORY FROM BLOG_CATEGORIES");
                        while($tdata = mysqli_fetch_array($run_query))
                        {
                        ?>
                        <li><a href="../Blog/index.php?manage-filter-categories=<?php echo $tdata[0]; ?>"><?php echo $tdata[0]; ?></a></li>
                        <?php
                        }
                        ?>
                    </ul><br>
                    <div class="input-group">
                        <form action="" method="GET">
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="q" placeholder="Search Blog by Title..">
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-default" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Side NavBar End -->

                <?php

                // HOME PAGE SECTION START

                if(!isset($_GET['manage-blogs']) && !isset($_GET['dashboard']) && !isset($_GET['manage-choice']) && !isset($_GET['q']) && !isset($_GET['manage-filter-categories']) && !isset($_GET['manage-categories']) && !isset($_GET['manage-tags']) 
                   || ($_COOKIE['logininfo']=='N' && !isset($_GET['manage-filter-categories']) && ($_COOKIE['logininfo']=='N' && !isset($_GET['q']))))
                    {
                        // EDITOR CHOICE BLOG LAYOUT START

                        $tag_sep_main = new tag_seperate();
                        ?>
                        <div class="col-sm-9">
                            <?php

                            $run_query = mysqli_query($conn,"SELECT 
                            BLOG_TITLE, BLOG_CATEGORY, BLOG_CONTENT,
                            BLOG_UPDATED, BLOG_PHOTOS_PATH, BLOG_AUTHOR,
                            BLOG_TAGS, BLOG_STATUS, BLOG_DATE_TIME,
                            BLOG_ADMIN_COMMENTS, ID, BLOG_COMMENT_COUNT,
                            BLOG_COMMENT_TABLE_NAME
                            FROM BLOG_INFO WHERE BLOG_STATUS = 'publish'
                            AND BLOG_RECOMMEND = 'Y'
                                ORDER BY ID DESC");

                            if(mysqli_num_rows($run_query)!=0)
                            {
                            ?>
                                <h4><small>Recommended Posts</small></h4>
                                <hr>
                            <?php 
                            }
                            while($tdata = mysqli_fetch_array($run_query)) // WHILE LOOP STARTS
                            { 
                                $title_value = $tdata[12];
                                $tag_sep_main->sep($tdata[6]);
                            ?>
                                <h2><?php echo $tdata[0]; ?></h2>
                                <h5><span class="glyphicon glyphicon-time"></span> Post on <?php echo $tdata[3]; ?>.</h5>
                                <h5><?php foreach($tag_sep_main->tag_sep_arr as $val){  echo '<span class="label label-success">'.$val.'</span>&nbsp;'; } ?></h5><br>
                                <p class="content-panel"><?php echo $tdata[2]; ?></p>
                                <hr>

                                <?php if($tdata[4]!='N'){echo '<img class="img-rounded" style="height:30%;width:30%;" src="sub/blog_content/'.$tdata[4].'">'; } ?>
                                <br><br>
                                <p><span class="badge"><?php echo $tdata[11]; ?></span> User Comments <button class="btn btn-xs btn-info" title="View user comments"><a style="cursor:pointer; text-decoration:none; color:white;" href="../Blog/index.php?view-user-comment=<?php echo $title_value; ?>">view</a></button></p><br>
                                
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <p><b>Category: </b><?php echo $tdata[1]; ?></p>
                                            <p><b>Author: </b><?php echo $tdata[5]; ?></p>
                                            <p><b>Event Date: </b><?php echo $tdata[8]; ?></p>
                                        </div>
                                        <div class="panel-body"> 
                                            <p><b>Admin Comment: </b><?php echo $tdata[9]; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if(isset($_COOKIE['loginUser']))
                                    {
                                ?>
                                        <h4>Leave a Comment:</h4>
                                        <form role="form">
                                            <div class="form-group">
                                                <textarea id="<?php echo $title_value; ?>" class="form-control" rows="3" required></textarea>
                                            </div>
                                            <button type="button" onclick="submit_user_comments('<?php echo $title_value; ?>','<?php echo $_COOKIE['loginUser']; ?>')" class="btn btn-success">Submit <span class="glyphicon glyphicon-comment"></span></button>
                                        </form>
                                        <br>
                                        <div class="sharethis-inline-share-buttons"></div>
                                        <br>
                                        <?php
                                    }
                                        ?>
                                        <hr>
                                        <?php
                                $tag_sep_main->tag_sep_arr = [];
                            }   // WHILE LOOP END

                            // EDITOR CHOICE LAYOUT END

                            // RECENT POST LAYOUT START

                            $tag_sep_main = new tag_seperate();
                                        ?>
                            <div class="col-sm-12">
                                <?php
                                    $run_query = mysqli_query($conn,"SELECT 
                                    BLOG_TITLE, BLOG_CATEGORY, BLOG_CONTENT,
                                    BLOG_UPDATED, BLOG_PHOTOS_PATH, BLOG_AUTHOR,
                                    BLOG_TAGS, BLOG_STATUS, BLOG_DATE_TIME,
                                    BLOG_ADMIN_COMMENTS, ID, BLOG_COMMENT_COUNT,
                                    BLOG_COMMENT_TABLE_NAME
                                    FROM BLOG_INFO WHERE BLOG_STATUS = 'publish'
                                    AND BLOG_RECOMMEND = 'N'
                                    ORDER BY ID DESC");

                                    if(mysqli_num_rows($run_query)!=0)
                                    {
                                ?>

                                        <h4><small>RECENT POSTS</small></h4>
                                        <hr>

                                <?php 
                                    }
                                    while($tdata = mysqli_fetch_array($run_query)) // WHILE LOOP START
                                    { 
                                        $title_value = $tdata[12];
                                        $tag_sep_main->sep($tdata[6]);
                                ?>
                                        <h2><?php echo $tdata[0]; ?></h2>
                                        <h5><span class="glyphicon glyphicon-time"></span> Post on <?php echo $tdata[3]; ?>.</h5>
                                        <h5><?php foreach($tag_sep_main->tag_sep_arr as $val){  echo '<span class="label label-success">'.$val.'</span>&nbsp;'; } ?></h5><br>
                                        <p class="content-panel"><?php echo $tdata[2]; ?></p>
                                        <hr>
                        
                                        <?php if($tdata[4]!='N'){echo '<img class="img-rounded" style="height:30%;width:30%;" src="sub/blog_content/'.$tdata[4].'">'; } ?>
                                        <br><br>
                                        <p><span class="badge"><?php echo $tdata[11]; ?></span> User Comments <button class="btn btn-xs btn-info" title="View user comments"><a style="cursor:pointer; text-decoration:none; color:white;" href="../Blog/index.php?view-user-comment=<?php echo $title_value; ?>">view</a></button></p><br>
                                        
                                        <div class="panel-group">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <p><b>Category: </b><?php echo $tdata[1]; ?></p>
                                                    <p><b>Author: </b><?php echo $tdata[5]; ?></p>
                                                    <p><b>Event Date: </b><?php echo $tdata[8]; ?></p>
                                                </div>
                                                <div class="panel-body"> 
                                                    <p><b>Admin Comment: </b><?php echo $tdata[9]; ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <?php

                                        if(isset($_COOKIE['loginUser']))
                                        {
                                            
                                        ?>
                                            <h4>Leave a Comment:</h4>
                                            <form role="form">
                                                <div class="form-group">
                                                    <textarea id="<?php echo $title_value; ?>" class="form-control" rows="3" required></textarea>
                                                </div>
                                                <button type="button" onclick="submit_user_comments('<?php echo $title_value; ?>','<?php echo $_COOKIE['loginUser']; ?>')" class="btn btn-success">Submit <span class="glyphicon glyphicon-comment"></span></button>
                                            </form>
                                            <br>
                                            <div class="sharethis-inline-share-buttons"></div>
                                            <br>
                                            
                                            <?php
                                        }
                                            ?>
                                        <hr>
                                        <?php
                                        $tag_sep_main->tag_sep_arr = [];
                                    } // WHILE LOOP END
                                        ?>
                            </div>
                        </div>
            </div>

                        <?php

                        if(isset($_GET['view-user-comment'])) // COMMENT PANEL START
                            {
                                $table_box = $_GET['view-user-comment'];

                        ?>

                                <div id="comment_view" class="pop_up_disp">
                                    <div class="col-sm-11"></div>
                                    <div class="col-sm-1"><br><button onclick="close_comment_blog()" class="btn btn-sm btn-danger">Close <span class="glyphicon glyphicon-remove"></span></button><br><br>
                                    </div>
                                    
                                    <?php

                                    $run_query = mysqli_query($conn,"SELECT * FROM `$table_box` ORDER BY ID DESC");
                                    while($tdata = mysqli_fetch_array($run_query))
                                    { 

                                    ?>
                                    
                                    <div class="panel-group col-sm-12">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <p><b>Comment Date: </b><?php echo $tdata[3]; ?></p>
                                                <p><b>User: </b><?php echo $tdata[2]; ?></p>
                                            </div>
                                            <div class="panel-body"> 
                                                <p><b>Comments: </b><?php echo $tdata[1]; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <?php
                            } // COMMENT PANEL END

                            if(isset($_GET['err'])) // ERROR MSG START
                            {
                                $error_msg = $_GET['err'];
                            ?>
                                <div class="content_wrapper">
                                    <div id="alertcontent_err">
                                    </div>
                                    <div class="alert" id="alertBoxerr">
                                        <div id="box_err">
                                            <div id="boxerr" class="alert alert-warning">
                                                <a onclick="closewarning_err()" href="#" class="close" aria-label="close">&times;</a>
                                                <strong>Warning! </strong><span id="warnmsg"><?php echo $error_msg; ?></span>
                                            </div>
                                        </div>
                                    </div>       
                                </div>
                            <?php
                            } // ERROR MSG END

                            if(isset($_GET['msg'])) // SUCCESS MSG START
                            {
                                $succ_msg = $_GET['msg'];
                            ?>

                                <div class="content_wrapper">
                                    <div id="alertcontent_err">
                                    </div>
                                    <div class="alert" id="alertBoxerr">
                                        <div id="box_err">
                                            <div id="boxerr" class="alert alert-success">
                                                <a onclick="closewarning_err()" href="#" class="close" aria-label="close">&times;</a>
                                                <strong>Success! </strong><span id="warnmsg"><?php echo $succ_msg; ?></span>
                                            </div>
                                        </div>
                                    </div>       
                                </div>

                            <?php
                            } // SUCCESS MSG END
            
                    }

                // HOME PAGE SECTION END
                
                // MANAGE PANEL SECTION START

                    elseif(isset($_GET['manage-blogs'])  && isset($_COOKIE['loginUser']) && $admin) // MANAGE BLOG SECTION START
                    {
                        if(!isset($_GET['add-new-blog']) && !isset($_GET['upload'])) // MANAGE BLOG CONTENT START
                        {
                            $tag_sep = new tag_seperate();
                            ?>

                            <div class="col-sm-9">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <button class="btn btn-success"><a href="../Blog/index.php?manage-blogs&add-new-blog" style="color:white;text-decoration:none;">+ Add New Blog</a></button>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>

                            <div class="col-sm-9">
                                <br>
                                <?php
                                $run_query = mysqli_query($conn,"SELECT BLOG_TITLE, BLOG_CATEGORY, BLOG_CONTENT, BLOG_UPDATED, BLOG_PHOTOS_PATH, BLOG_AUTHOR, BLOG_TAGS, BLOG_STATUS, BLOG_DATE_TIME, BLOG_ADMIN_COMMENTS, ID FROM BLOG_INFO ORDER BY ID DESC");
                                while($tdata = mysqli_fetch_array($run_query))
                                { 
                                    $tag_sep->sep($tdata[6]);
                    
                                ?>
                                    <div class="panel-group">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <div class="col-sm-4"></div>
                                                <div class="col-sm-6"></div>
                                                <div class="col-sm-2">
                                                    <button title="Edit" onclick="edit_blog_icon(
                                                    '<?php echo $strip->strip_char($tdata[0]); ?>',
                                                    '<?php echo $strip->strip_char($tdata[1]); ?>',
                                                    '<?php echo $strip->strip_char($tdata[2]); ?>',
                                                    '<?php echo $strip->strip_char($tdata[4]); ?>',
                                                    '<?php echo $strip->strip_char($tdata[5]); ?>',
                                                    '<?php echo $strip->strip_char($tdata[6]); ?>',
                                                    '<?php echo $strip->strip_char($tdata[7]); ?>',
                                                    '<?php echo $strip->strip_char($tdata[8]); ?>',
                                                    '<?php echo $strip->strip_char($tdata[9]); ?>',
                                                    '<?php echo $strip->strip_char($tdata[10]); ?>')" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span></button>    
                                                    <button title="Delete" onclick="delete_blog_icon('<?php echo $strip->strip_char($tdata[0]); ?>')" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
                                                </div>
                                                <h5><b>Title: </b><?php echo $tdata[0]; ?></h5>
                                                <p><b>Category: </b><?php echo $tdata[1]; ?></p>
                                                <p><b>Author: </b><?php echo $tdata[5]; ?></p>
                                                <p><b>Status: </b><?php echo $tdata[7]; ?></p>
                                                <p><b>Uploaded Date: </b><?php echo $tdata[3]; ?></p>
                                                <p><b>Tags: </b><?php foreach($tag_sep->tag_sep_arr as $val){ echo '<button class="btn btn-primary">'.$val.'</button>&nbsp;';} ?></p>
                                                <?php if($tdata[4]!='N'){echo '<p><b>Image Attachment: </b>'.$tdata[4].'</p>'; } ?>
                                            </div>
                                            <div class="panel-body"> 
                                                <p><b>Content: </b><?php echo $tdata[2]; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $tag_sep->tag_sep_arr = [];
                                }
                                    ?>
                                <div id="edit_blog" class="pop_up_disp">
                                    <div class="col-sm-11">
                                    </div>
                                    <div class="col-sm-1"><br><button onclick="close_edit_blog()" class="btn btn-sm btn-danger">Close <span class="glyphicon glyphicon-remove"></span></button>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <form action="sub/upload.php" method="POST" enctype="multipart/form-data">
                                                <fieldset><legend>EDIT Blog</legend>

                                                    <label for="title_edit">Title:</label>
                                                    <input type="text" class="form-control input-sm" name ="title_edit" id="title_edit"/>
                                                    <br>
                                                    <input type="text" style="display:none;" name ="id_edit" id="id_edit"/>

                                                    <label for="categorynewblog_edit">Select Category:</label>
                                                    <select class="form-control" name="categorynewblog_edit" id="categorynewblog_edit">
                                                        <?php
                                                            $run_query = mysqli_query($conn,"SELECT BLOG_CATEGORY FROM BLOG_CATEGORIES");
                                                            while($tdata = mysqli_fetch_array($run_query))
                                                            { 
                                                        ?>
                                                            <option value="<?php echo $tdata[0]; ?>"><?php echo $tdata[0]; ?></option>
                                                        <?php 
                                                            }
                                                        ?>
                                                    </select>
                                                    <br>

                                                    <label for="tags">Select Tags:</label>
                                                    <div class="checkbox">
                                                        <?php
                                                            $run_query = mysqli_query($conn,"SELECT BLOG_TAG FROM BLOG_TAGS");
                                                            while($tdata = mysqli_fetch_array($run_query))
                                                            { 
                                                        ?>
                                                            <label><input type="checkbox" id="tag_edit" name="tag_edit[]" value="<?php echo $tdata[0]; ?>"><?php echo $tdata[0]; ?></label>
                                                        <?php 
                                                            }
                                                        ?>
                                                    </div>
                                                    <br>

                                                    <label for="contentnewblog_edit">Content:</label>
                                                    <textarea class="form-control" name="contentnewblog_edit" rows="10" id="contentnewblog_edit">
                                                    </textarea>
                                                    <br>
                                                    <div class="col-sm-4">
                                                        <label for="date_time_edit">Select Event DateTime:</label>
                                                        <input type="text" name="date_time_edit" class="form-control input-sm" id="date_time_edit"/>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label><b>Photos</b></label><input class="input-sm" style="cursor:pointer" name="myfile" type="file" />
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="datetime">Enter Author Name:</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                            <input id="authorname_edit" type="text" class="form-control" name="authorname_edit" placeholder="Author">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <br><br>

                                                        <label for="status">Select Post Status:</label>
                                                        <label class="radio-inline"><input type="radio" name="status[]" value="Draft" >Draft</label>
                                                        <label class="radio-inline"><input type="radio" name="status[]" value="publish" >Publish</label>
                                                        <br><br>

                                                        <label for="comments_edit">Admin Comments:</label>
                                                        <textarea class="form-control" name="comments_edit" rows="4" id="comments_edit"></textarea>
                                                        <br>
                                                        <button type="submit" name="submit_blog_update" class="btn btn-success">Submit</button>
                                                    </div>
                                                    <br>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        } // MANAGE BLOG CONTENT END
                        elseif(isset($_GET['add-new-blog']))   // ADD NEW BLOG CONTENT START
                        {
                    ?>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <form action="sub/upload.php" method="POST" enctype="multipart/form-data">
                                        <fieldset><legend>Create New blog</legend>
                                            <label for="title">Title:</label>
                                            <input type="text" class="form-control input-sm" name ="title" id="title"/>
                                            <br>

                                            <label for="categorynewblog">Select Category:</label>
                                            <select class="form-control" name="categorynewblog" id="categorynewblog">
                                                <?php
                                                    $run_query = mysqli_query($conn,"SELECT BLOG_CATEGORY FROM BLOG_CATEGORIES");
                                                    while($tdata = mysqli_fetch_array($run_query))
                                                    { 
                                                ?>
                                                    <option value="<?php echo $tdata[0]; ?>"><?php echo $tdata[0]; ?></option>
                                                <?php 
                                                    }
                                                ?>
                                            </select>
                                            <br>

                                            <label for="tags">Select Tags:</label>
                                            <div class="checkbox">
                                                <?php
                                                    $run_query = mysqli_query($conn,"SELECT BLOG_TAG FROM BLOG_TAGS");
                                                    while($tdata = mysqli_fetch_array($run_query))
                                                    { 
                                                ?>
                                                    <label><input type="checkbox" name="tag[]" value="<?php echo $tdata[0]; ?>"><?php echo $tdata[0]; ?></label>
                                                <?php 
                                                    }
                                                ?>
                                            </div>
                                            <br>

                                            <label for="content">Content:</label>
                                            <textarea class="form-control" name="contentnewblog" rows="10" id="content"></textarea>
                                            <br>
                                            <div class="col-sm-4">
                                                <label for="datetime">Select Event DateTime:</label>
                                                <input type="datetime-local" name="date_time" class="form-control input-sm" id="datetime"/>
                                            </div>

                                            <div class="col-sm-4">
                                                <label><b>Photos</b></label><input class="input-sm" style="cursor:pointer" name="myfile" type="file" />
                                            </div>

                                            <div class="col-sm-4">
                                                <label for="datetime">Enter Author Name:</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                    <input id="authorname" type="text" class="form-control" name="author" placeholder="Author">
                                                </div>
                                            </div>

                                            <div class="col-sm-9">
                                                <br><br>
                                                <label for="status">Select Post Status:</label>
                                                <label class="radio-inline"><input type="radio" name="status" value="Draft" checked>Draft</label>
                                                <label class="radio-inline"><input type="radio" name="status" value="publish" >Publish</label>
                                                <br><br>

                                                <label for="comments">Admin Comments:</label>
                                                <textarea class="form-control" name="comments" rows="4" id="comments"></textarea>
                                                <br>
                                                <button type="submit" name="submit_blog" class="btn btn-success">Submit</button>
                                            </div>
                                            <br>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        <?php
                        }   // ADD NEW BLOG CONTENT END

                    } // MANAGE BLOG SECTION END

                    elseif(isset($_GET['manage-categories'])  && isset($_COOKIE['loginUser']) && $admin) // MANAGE CATEGORY SECTION START
                    {
                    ?>
                        <div class="col-sm-9">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                <div class="jumbotron text-center">
                                    <h1>Categories</h1> 
                                    <p>Add few categories to categorize the blog</p>
                                </div>
                                <label for="category">Available Category:</label>
                                <select class="form-control" name="category" id="category_view_menu">
                                <?php
                                $run_query = mysqli_query($conn,"SELECT BLOG_CATEGORY FROM BLOG_CATEGORIES ORDER BY BLOG_CATEGORY");
                                while($tdata = mysqli_fetch_array($run_query))
                                { 
                                ?>
                                <option value="<?php echo $tdata[0]; ?>"><?php echo $tdata[0]; ?></option>
                                <?php 
                                }
                                ?>
                                </select>
                                <br>
                                <div class="col-sm-4"></div>
                                    <div class="col-sm-4">
                                        <button class="btn btn-danger" onclick="delcategory()"><span class="glyphicon glyphicon-minus"></span> Delete Category</button>
                                    </div>
                                    <div class="col-sm-4"></div>
                                    <br><br><br>
                                <label for="datetime">New Category:</label>
                                <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-plus"></i></span>
                                <input id="categoryname_new" type="text" class="form-control" name="author" placeholder="Category Name">
                                </div>
                                <br>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <button class="btn btn-success" onclick="addcategory()"><span class="glyphicon glyphicon-plus"></span> Add Category</button>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                    <?php
                    } // MANAGE CATEGORY SECTION END

                    elseif(isset($_GET['manage-tags'])  && isset($_COOKIE['loginUser']) && $admin) // MANAGE TAG SECTION START
                    {
                    ?>
                        <div class="col-sm-9">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                <div class="jumbotron text-center">
                                    <h1>Tags</h1> 
                                    <p>Add Tags to highlight the blog</p>
                                </div>
                                <label for="tags">Available Tags:</label>
                                <select class="form-control" name="tags" id="tags_view_menu">
                                <?php
                                $run_query = mysqli_query($conn,"SELECT BLOG_TAG FROM BLOG_TAGS ORDER BY BLOG_TAG");
                                while($tdata = mysqli_fetch_array($run_query))
                                { 
                                ?>
                                <option value="<?php echo $tdata[0]; ?>"><?php echo $tdata[0]; ?></option>
                                <?php 
                                }
                                ?>
                                </select>
                                <br>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <button class="btn btn-danger" onclick="deltag()"><span class="glyphicon glyphicon-minus"></span> Delete Tag</button>
                                </div>
                                <div class="col-sm-4"></div>
                                <br><br><br>
            
                                <label for="datetime">New Tag:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-plus"></i></span>
                                    <input id="tagname_new" type="text" class="form-control" name="tag" placeholder="Tag Name">
                                </div>
                                <br>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <button class="btn btn-success" onclick="addtag()"><span class="glyphicon glyphicon-plus"></span> Add Tag</button>
                                </div>
                                
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                        <?php
                    } // MANAGE TAG SECTION END

                    elseif(isset($_GET['dashboard'])  && isset($_COOKIE['loginUser']) && $admin) // DASHBOARD SECTION START
                    {
                        $run_query = mysqli_query($conn,"SELECT * FROM BLOG_CATEGORIES");
                        while($tdata = mysqli_fetch_array($run_query))
                        {
                            $blog_cat_count += 1;
                        }
                        $run_query = mysqli_query($conn,"SELECT * FROM BLOG_INFO");
                        while($tdata = mysqli_fetch_array($run_query))
                        {
                            $blog_post_count += 1;
                        }
                        $run_query = mysqli_query($conn,"SELECT * FROM BLOG_TAGS");
                        while($tdata = mysqli_fetch_array($run_query))
                        {
                            $blog_tag_count += 1;
                        }
                        $run_query = mysqli_query($conn,"SELECT * FROM BLOG_INFO WHERE BLOG_STATUS = 'Drafts'");
                        while($tdata = mysqli_fetch_array($run_query))
                        {
                            $blog_draft_count += 1;
                        }
                        $run_query = mysqli_query($conn,"SELECT * FROM BLOG_INFO WHERE BLOG_STATUS = 'publish'");
                        while($tdata = mysqli_fetch_array($run_query))
                        {
                            $blog_publish_count += 1;
                        }
                        $run_query = mysqli_query($conn,"SELECT * FROM BLOG_INFO WHERE BLOG_RECOMMEND = 'Y'");
                        while($tdata = mysqli_fetch_array($run_query))
                        {
                            $editor_choice_count += 1;
                        }
                        ?>
                        <div class="col-sm-9">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                <div class="jumbotron text-center">
                                    <h1>Dashboard</h1> 
                                </div>
                                    <div class="panel panel-default">
                                    <h4 class="text-left panel-body"><span class="col-sm-11">Blog Posted: </span><span class="text-danger col-sm-1"><?php echo $blog_post_count; ?></span></h4>
                                    </div>
                                    <div class="panel panel-default">
                                    <h4 class="text-left panel-body"><span class="col-sm-11">Blog Categories: </span><span class="text-danger col-sm-1"><?php echo $blog_cat_count; ?></span></h4>
                                    </div>
                                    <div class="panel panel-default">
                                    <h4 class="text-left panel-body"><span class="col-sm-11">Blog Tags: </span><span class="text-danger col-sm-1"><?php echo $blog_tag_count; ?></span></h4>
                                    </div>
                                    <div class="panel panel-default">
                                    <h4 class="text-left panel-body"><span class="col-sm-11">Blog Drafts: </span><span class="text-danger col-sm-1"><?php echo $blog_draft_count; ?></span></h4>
                                    </div>
                                    <div class="panel panel-default">
                                    <h4 class="text-left panel-body"><span class="col-sm-11">Blog Published: </span><span class="text-danger col-sm-1"><?php echo $blog_publish_count; ?></span></h4>
                                    </div>
                                    <div class="panel panel-default">
                                    <h4 class="text-left panel-body"><span class="col-sm-11">Editor's Choice: </span><span class="text-danger col-sm-1"><?php echo $editor_choice_count; ?></span></h4>
                                    </div>
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                        <?php
                    } // DASHBOARD SECTION END

                    elseif(isset($_GET['manage-filter-categories'])) // FILTER SECTION START
                    {
                        $categ = $_GET['manage-filter-categories'];
                        $tag_sep_filt = new tag_seperate();
                        ?>

                    <div class="col-sm-9">                    
                        <h4><small><?php echo $categ ?></small></h4>
                        <hr>
                        <?php
                            $run_query_blog = mysqli_query($conn,"SELECT 
                            BLOG_TITLE, BLOG_CATEGORY, BLOG_CONTENT,
                            BLOG_UPDATED, BLOG_PHOTOS_PATH, BLOG_AUTHOR,
                            BLOG_TAGS, BLOG_STATUS, BLOG_DATE_TIME,
                            BLOG_ADMIN_COMMENTS, ID, BLOG_COMMENT_COUNT,
                            BLOG_COMMENT_TABLE_NAME
                            FROM BLOG_INFO WHERE BLOG_STATUS = 'publish'
                            AND BLOG_CATEGORY = '$categ'
                            ORDER BY ID DESC");
                            while($tdata = mysqli_fetch_array($run_query_blog))
                            {
                                $title_value = $tdata[12];
                                $tag_sep_filt->sep($tdata[6]);
                        ?>

                                <h2><?php echo $tdata[0]; ?></h2>
                                <h5><span class="glyphicon glyphicon-time"></span> Post on <?php echo $tdata[3]; ?>.</h5>
                                <h5><?php foreach($tag_sep_filt->tag_sep_arr as $val){  echo '<span class="label label-success">'.$val.'</span>&nbsp;'; } ?></h5><br>
                                <p class="content-panel"><?php echo $tdata[2]; ?></p>
                                <hr>

                                <?php if($tdata[4]!='N'){echo '<img class="img-rounded" style="height:30%;width:30%;" src="sub/blog_content/'.$tdata[4].'">'; } ?>
                                <br><br>
                                <p><span class="badge"><?php echo $tdata[11]; ?></span> User Comments <button class="btn btn-xs btn-info" title="View user comments"><a style="cursor:pointer; text-decoration:none; color:white;" href="../Blog/index.php?view-user-comment=<?php echo $title_value; ?>">view</a></button></p><br>
                                
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">                                                                        
                                            <p><b>Category: </b><?php echo $tdata[1]; ?></p>
                                            <p><b>Author: </b><?php echo $tdata[5]; ?></p>
                                            <p><b>Event Date: </b><?php echo $tdata[8]; ?></p>                                
                                        </div>
                                        <div class="panel-body"> 
                                            <p><b>Admin Comment: </b><?php echo $tdata[9]; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php

                                if(isset($_COOKIE['loginUser']))
                                {    
                                ?>
                                    <h4>Leave a Comment:</h4>
                                    <form role="form">
                                        <div class="form-group">
                                            <textarea id="<?php echo $title_value; ?>" class="form-control" rows="3" required></textarea>
                                        </div>
                                        <button type="button" onclick="submit_user_comments('<?php echo $title_value; ?>','<?php echo $_COOKIE['loginUser']; ?>')" class="btn btn-success">Submit <span class="glyphicon glyphicon-comment"></span></button>
                                    </form>
                                    <br>
                                    <div class="sharethis-inline-share-buttons"></div>
                                    <br>                                    
                                <?php
                                }
                                ?>
                                <hr>
                                <?php
                                $tag_sep_main->tag_sep_arr = [];
                            }
                            if(mysqli_num_rows($run_query_blog)==0)
                            {
                                echo '<h2>Sorry... No Post available in this category</h2>';
                            }
                                ?>
                        
                    </div>
                </div>
            </div>
                            <?php
                            if(isset($_GET['view-user-comment']))
                            {
                                $table_box = $_GET['view-user-comment'];
                                ?>
                                <div id="comment_view" class="pop_up_disp">
                                    <div class="col-sm-11"></div>
                                    <div class="col-sm-1"><br><button onclick="close_comment_blog()" class="btn btn-sm btn-danger">Close <span class="glyphicon glyphicon-remove"></span></button><br><br>
                                    </div>
                                        
                                    <?php
                                    $run_query = mysqli_query($conn,"SELECT * FROM `$table_box` ORDER BY ID DESC");
                                    while($tdata = mysqli_fetch_array($run_query))
                                    { 
                                    ?>
                                        
                                    <div class="panel-group col-sm-12">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <p><b>Comment Date: </b><?php echo $tdata[3]; ?></p>
                                                <p><b>User: </b><?php echo $tdata[2]; ?></p>
                                            </div>
                                            <div class="panel-body"> 
                                                <p><b>Comments: </b><?php echo $tdata[1]; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            $tag_sep_filt->tag_sep_arr = [];
                    } // FILTER SECTION END

                    elseif(isset($_GET['q'])) // SEARCH SECTION START
                        {
                            $search = $_GET['q'];
                            $tag_sep_search = new tag_seperate();
                            ?>

                            <div class="col-sm-9">                            
                                <h4><small>RECENT POSTS</small></h4>
                                <hr>
                                <?php
                                    $run_query_blog = mysqli_query($conn,"SELECT 
                                    BLOG_TITLE, BLOG_CATEGORY, BLOG_CONTENT,
                                    BLOG_UPDATED, BLOG_PHOTOS_PATH, BLOG_AUTHOR,
                                    BLOG_TAGS, BLOG_STATUS, BLOG_DATE_TIME,
                                    BLOG_ADMIN_COMMENTS, ID, BLOG_COMMENT_COUNT,
                                    BLOG_COMMENT_TABLE_NAME
                                    FROM BLOG_INFO WHERE BLOG_STATUS = 'publish'
                                    AND BLOG_TITLE LIKE '%$search%'
                                    ORDER BY ID DESC");
                                    while($tdata = mysqli_fetch_array($run_query_blog))
                                    {
                                        $title_value = $tdata[12];
                                        $tag_sep_search->sep($tdata[6]);
                                ?>
                                        <h2><?php echo $tdata[0]; ?></h2>
                                        <h5><span class="glyphicon glyphicon-time"></span> Post on <?php echo $tdata[3]; ?>.</h5>
                                        <h5><?php foreach($tag_sep_search->tag_sep_arr as $val){  echo '<span class="label label-success">'.$val.'</span>&nbsp;'; } ?></h5><br>
                                        <p class="content-panel"><?php echo $tdata[2]; ?></p>
                                        <hr>

                                        <?php if($tdata[4]!='N'){echo '<img class="img-rounded" style="height:30%;width:30%;" src="sub/blog_content/'.$tdata[4].'">'; } ?>
                                        <br><br>
                                        <p><span class="badge"><?php echo $tdata[11]; ?></span> User Comments <button class="btn btn-xs btn-info" title="View user comments"><a style="cursor:pointer; text-decoration:none; color:white;" href="../Blog/index.php?view-user-comment=<?php echo $title_value; ?>">view</a></button></p><br>
                                        
                                        <div class="panel-group">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">                                                                                
                                                    <p><b>Category: </b><?php echo $tdata[1]; ?></p>
                                                    <p><b>Author: </b><?php echo $tdata[5]; ?></p>
                                                    <p><b>Event Date: </b><?php echo $tdata[8]; ?></p>                                        
                                                </div>
                                                <div class="panel-body"> 
                                                    <p><b>Admin Comment: </b><?php echo $tdata[9]; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if(isset($_COOKIE['loginUser']))
                                        {
                                            
                                        ?>
                                            <h4>Leave a Comment:</h4>
                                            <form role="form">
                                                <div class="form-group">
                                                    <textarea id="<?php echo $title_value; ?>" class="form-control" rows="3" required></textarea>
                                                </div>
                                                <button type="button" onclick="submit_user_comments('<?php echo $title_value; ?>','<?php echo $_COOKIE['loginUser']; ?>')" class="btn btn-success">Submit <span class="glyphicon glyphicon-comment"></span></button>
                                            </form>
                                            <br>
                                            <div class="sharethis-inline-share-buttons"></div>
                                            <br>                                        
                                        <?php
                                        
                                        }
                                        ?>
                                        <hr>
                                        <?php
                                        $tag_sep_search->tag_sep_arr = [];
                                    }
                                    if(mysqli_num_rows($run_query_blog)==0)
                                    {
                                        echo '<h2>Sorry... No Post available in this Title</h2>';
                                    }
                                    ?>
                                
                            </div>
                        </div>
                    </div>
                                    <?php
                                    if(isset($_GET['view-user-comment']))
                                    {
                                        $table_box = $_GET['view-user-comment'];
                                        ?>
                                        <div id="comment_view" class="pop_up_disp">
                                                <div class="col-sm-11"></div>
                                                <div class="col-sm-1"><br><button onclick="close_comment_blog()" class="btn btn-sm btn-danger">Close <span class="glyphicon glyphicon-remove"></span></button><br><br>
                                                </div>
                                                    
                                            <?php

                                                $run_query = mysqli_query($conn,"SELECT * FROM `$table_box` ORDER BY ID DESC");
                                                while($tdata = mysqli_fetch_array($run_query))
                                                { 
                                            ?>
                                                    
                                                <div class="panel-group col-sm-12">
                                                    <div class="panel panel-primary">
                                                        <div class="panel-heading">
                                                            <p><b>Comment Date: </b><?php echo $tdata[3]; ?></p>
                                                            <p><b>User: </b><?php echo $tdata[2]; ?></p>
                                                        </div>
                                                        <div class="panel-body"> 
                                                            <p><b>Comments: </b><?php echo $tdata[1]; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                    <?php
                                    }
                        $tag_sep_search->tag_sep_arr = [];
                        } // SEARCH SECTION END

                        elseif(isset($_GET['manage-choice'])  && isset($_COOKIE['loginUser']) && $admin) // EDITOR CHOICE SECTION START
                        {
                            ?>
                            <div class="col-sm-9">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-8">
                                    <div class="jumbotron text-center">
                                        <h2>Editor's Choice</h2> 
                                        <p>Add Title to set the recommendation of the article</p>
                                    </div>
                                    <label for="editor_title">Available Blog Title:</label>
                                    <select class="form-control" name="editor_title" id="editor_title">
                                        <?php
                                        $run_query = mysqli_query($conn,"SELECT BLOG_TITLE FROM BLOG_INFO ORDER BY BLOG_TITLE");
                                        while($tdata = mysqli_fetch_array($run_query))
                                        { 
                                        ?>
                                        <option value="<?php echo $tdata[0]; ?>"><?php echo $tdata[0]; ?></option>
                                        <?php 
                                        }
                                        ?>
                                    </select>
                                    <br>
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4">
                                        <button class="btn btn-success" onclick="addtitleEditor()"><span class="glyphicon glyphicon-plus"></span> Set Recommend</button>
                                    </div>
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-12">
                                        <br>
                                        <div class="well well-sm text-center"><h4>Editor's Choice Blogs</h4>
                                        </div>
                                                <?php
                                                $run_query = mysqli_query($conn,"SELECT BLOG_TITLE FROM BLOG_INFO WHERE BLOG_RECOMMEND = 'Y' ORDER BY BLOG_TITLE");
                                                while($tdata = mysqli_fetch_array($run_query))
                                                { 
                                                ?>
                                                    <div class="panel panel-primary">
                                                    <div class="panel-body"><div class="col-sm-9"><?php echo $tdata[0]; ?></div><div class="col-sm-3"><button onclick="removeeditorchoice('<?php echo $tdata[0]; ?>')" class="btn btn-sm btn-danger">Remove <span class="glyphicon glyphicon-trash"></span></button></div></div>
                                                    </div>
                                                <?php 
                                                }
                                                ?>
                                    
                                    </div>
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                            <?php
                        } // EDITOR CHOICE SECTION END
                            ?>

        <!-- FOOTER BLOCK START -->

        <div class="navbar navbar-fixed-bottom">
            <footer class="container-fluid">
                <p>INFINITI SOFTWARE BLOG Developed by <span class="glyphicon glyphicon-user"></span> Kevi</p>
            </footer>
        </div>
        
        <!-- FOOTER BLOCK END -->

        <!-- alertscreen block start -->
        <div class="content_wrapper">
            <div id="alertPage"></div>
            <div class="alert" id="alertBox">
                <div id="box_main">
                    <div id="error" class="alert alert-warning">
                        <a onclick="closewarning_main()" href="#" class="close" aria-label="close">&times;</a>
                        <strong>Warning! </strong><span id="warnmsg">Indicates a warning that might need attention.</span>
                    </div>
                    <div id="success" class="alert alert-success">
                        <a onclick="closewarning_main()" href="#" class="close" aria-label="close">&times;</a>
                        <strong>Success! </strong><span id="successmsg">Indicates a warning that might need attention.</span>
                    </div>
                </div>
            </div>       
        </div>
        <!-- alertscreen block end -->

    </body>

    <!-- BODY SECTION END -->

    <!-- Including Script Files -->
    <script src="lib/js/jquery.js"></script>
    <script src="lib/js/bootstrap.js"></script>
    <script src="lib/js/blog.js"></script>

</html>

<!-- HTML ELEMENT END -->

<?php

// main body block content end

    }