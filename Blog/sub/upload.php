<?php
// error_reporting(0);
require '../db/db.php';
require 'oop.php';
date_default_timezone_set('Asia/Kolkata');
$CreatedDate=  date('Y-m-d-H:i:s');
$strip = new special();

if(isset($_POST['submit_blog']))
    {
    $current_dir = getcwd();
    $uploadDirectory = "/blog_content/";
    $errors = []; // Store all foreseen and unforseen errors here
    $fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions
    $fileName = $_FILES['myfile']['name'];
    $fileSize = $_FILES['myfile']['size'];
    $fileTmpName  = $_FILES['myfile']['tmp_name'];
    $fileExtension = strtolower(end(explode('.',$fileName)));
    $title =  $strip->strip_char($_POST['title']);
    $category =  $_POST['categorynewblog'];
    $count_tag = count($_POST['tag']);
    for($i=0;$i<$count_tag;$i++)
        {
            $tag .= $_POST['tag'][$i];
            $tag .= '-';
        }
    $content = $strip->strip_char($_POST['contentnewblog']);
    $event_date_time = $_POST['date_time'];
    $event_date_time = str_replace('T'," ",$event_date_time);
    $auth = $strip->strip_char($_POST['author']);
    $blog_stat = $_POST['status'];
    $admin_comment = $strip->strip_char($_POST['comments']);
    if (!in_array($fileExtension,$fileExtensions)) {
        $errors[] = "This file extension is not allowed.";
        }
        if(empty($errors))
        {
            $uploadPath = $current_dir . $uploadDirectory . basename($fileName);
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
            if($didUpload)
                {
                     $QUERY = "SELECT * FROM BLOG_INFO WHERE BLOG_TITLE='$title'";
                        $RunQuery = mysqli_query($conn, $QUERY);
                        if(mysqli_Fetch_array($RunQuery))
                        {
                            $err = 'Duplicated Title, title already exist... please try with new title';
                            header("Refresh:0; url=../index.php?err=$err");
                        }
                        else
                        {

                            $QUERY = "INSERT INTO BLOG_INFO
                            (BLOG_TITLE, BLOG_CATEGORY, BLOG_CONTENT, BLOG_DATE_TIME,
                            BLOG_UPDATED, BLOG_PHOTOS_PATH, BLOG_AUTHOR, BLOG_TAGS,
                            BLOG_STATUS, BLOG_ADMIN_COMMENTS) 
                            VALUES
                            ('$title','$category','$content','$event_date_time',
                            '$CreatedDate', '$fileName', '$auth', '$tag',
                            '$blog_stat', '$admin_comment')";

                            if($conn->query($QUERY)===True)
                                {
                                    $QUERY = "SELECT ID FROM BLOG_INFO WHERE BLOG_TITLE='$title'";
                                    $RunQuery = mysqli_query($conn, $QUERY);
                                    $data = mysqli_Fetch_array($RunQuery);

                                    $QUERY = "UPDATE BLOG_INFO SET BLOG_COMMENT_TABLE_NAME = '$data[0]' WHERE BLOG_TITLE='$title'";
                                    $conn->query($QUERY);

                                    $title_seperated = $data[0];

                                    $QUERY = "CREATE TABLE `$title_seperated`
                                    (
                                    ID INT AUTO_INCREMENT PRIMARY KEY,
                                    USER_COMMENTS LONGTEXT NOT NULL,
                                    USER_NAME VARCHAR(40) NOT NULL,
                                    COMMENT_DATE DATETIME
                                    )";
                                    if($conn->query($QUERY)==True)
                                        {
                                            $success = 'New Blog has been created';
                                            header("Refresh:0; url=../index.php?msg=$success");
                                        }
                                        else
                                        {
                                            $err = 'Comment table not created, please update later...';
                                            header("Refresh:0; url=../index.php?err=$err");
                                        }
                                }
                                else
                                {
                                    $err = $conn->error;//'Blog not Created, please update later...';
                                    header("Refresh:0; url=../index.php?err=$err");
                                }
                        }
                }
                else
                {
                    $err = 'Photo not inserted, please try again later...';
                    header("Refresh:0; url=../index.php?err=$err");
                }
        }
        else
        {
            $err = 'Photo attachment extension not correct, please update attachment in jpg,jpeg or PNG format..';
            header("Refresh:0; url=../index.php?err=$err");
        }
    }

    if(isset($_POST['submit_blog_update']))
    {
    $current_dir = getcwd();
    $uploadDirectory = "/blog_content/";
    $errors = []; // Store all foreseen and unforseen errors here
    $fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions
    $fileName = $_FILES['myfile']['name'];
    $fileSize = $_FILES['myfile']['size'];
    $fileTmpName  = $_FILES['myfile']['tmp_name'];
    $fileExtension = strtolower(end(explode('.',$fileName)));
    $title =  $strip->strip_char($_POST['title_edit']);
    $category =  $_POST['categorynewblog_edit'];
    $id =  $_POST['id_edit'];
    $count_tag = count($_POST['tag_edit']);
    for($i=0;$i<$count_tag;$i++)
        {
            $tag .= $_POST['tag_edit'][$i];
            $tag .= '-';
        }
    $content = $strip->strip_char($_POST['contentnewblog_edit']);
    $event_date_time = $_POST['date_time_edit'];
    $auth = $strip->strip_char($_POST['authorname_edit']);
    $blog_stat = $_POST['status'][0];
    $admin_comment = $strip->strip_char($_POST['comments_edit']);

    $RunQuery = mysqli_query($conn,"SELECT BLOG_TITLE, BLOG_PHOTOS_PATH, FROM BLOG_INFO WHERE ID='$id'");
    $data = mysqli_Fetch_array($RunQuery);

    if (!in_array($fileExtension,$fileExtensions)) {
        $errors[] = "This file extension is not allowed.";
        }
        if(empty($errors)||!$fileName)
        {
            if($fileName)
            {
            $uploadPath = $current_dir . $uploadDirectory . basename($fileName);
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
            
            if($didUpload)
                {
                $QUERY = "UPDATE BLOG_INFO SET
                BLOG_TITLE='$title', BLOG_CATEGORY='$category', BLOG_CONTENT='$content', BLOG_DATE_TIME='$event_date_time',
                BLOG_UPDATED='$CreatedDate', BLOG_PHOTOS_PATH='$fileName', BLOG_AUTHOR='$auth', BLOG_TAGS='$tag',
                BLOG_STATUS='$blog_stat', BLOG_ADMIN_COMMENTS='$admin_comment' WHERE ID='$id'";

                if($conn->query($QUERY)===True)
                    {
                        unlink("blog_content/".$data[1]."");
                        $success = 'Blog Updated';
                        header("Refresh:0; url=../index.php?msg=$success");
                    }
                    else
                    {
                        $err = 'Blog not Updated, please update later...';
                        header("Refresh:0; url=../index.php?err=$err");
                    }
                        
                }
            }
            else
            {
                $QUERY = "UPDATE BLOG_INFO SET
                BLOG_TITLE='$title', BLOG_CATEGORY='$category', BLOG_CONTENT='$content', BLOG_DATE_TIME='$event_date_time',
                BLOG_UPDATED='$CreatedDate', BLOG_AUTHOR='$auth', BLOG_TAGS='$tag',
                BLOG_STATUS='$blog_stat', BLOG_ADMIN_COMMENTS='$admin_comment' WHERE ID='$id'";

                if($conn->query($QUERY)===True)
                    {
                        $success = 'Blog Updated';
                        header("Refresh:0; url=../index.php?msg=$success");
                    }
                    else
                    {
                        $err = 'Blog not Updated, please update later...';
                                    header("Refresh:0; url=../index.php?err=$err");
                    }
            }
        }
        else
        {
            $err = 'Photo attachment extension not correct, please update attachment in jpg,jpeg or PNG format..';
            header("Refresh:0; url=../index.php?err=$err");
        }
    }


if(isset($_POST['tagName']))
{
    $tag = $strip->strip_char($_POST['tagName']);
    $QUERY = "INSERT INTO BLOG_TAGS (BLOG_TAG) VALUES('$tag')";
    if($conn->query($QUERY)===True)
    {
        echo 'Y';
    }
    else
    {
        echo 'N';
    }
}

if(isset($_POST['categoryName']))
{
    $category = $strip->strip_char($_POST['categoryName']);
    $QUERY = "INSERT INTO BLOG_CATEGORIES (BLOG_CATEGORY) VALUES('$category')";
    if($conn->query($QUERY)===True)
    {
        echo 'Y';
    }
    else
    {
        echo 'N';
    }
}

if(isset($_POST['commenttable']))
{
    $table =  $_POST['commenttable'];
    $user =  $strip->strip_char($_POST['commentuser']);
    $comment =  $strip->strip_char($_POST['comments']);

    $QUERY = "SELECT BLOG_COMMENT_COUNT FROM BLOG_INFO WHERE ID='$table'";
                        $RunQuery = mysqli_query($conn, $QUERY);
                        if($data = mysqli_Fetch_array($RunQuery))
                        {
                            $value_count = $data[0]+1;
                        }
    $QUERY = "UPDATE BLOG_INFO SET BLOG_COMMENT_COUNT = '$value_count' WHERE ID = '$table'";
    $conn->query($QUERY);

    $QUERY = "INSERT INTO `$table` (USER_COMMENTS, USER_NAME, COMMENT_DATE) VALUES('$comment','$user','$CreatedDate')";
    if($conn->query($QUERY)===True)
    {
        echo 'Y';
    }
    else
    {
        echo 'N';
    }
}

if(isset($_POST['recommend']))
{
    $editorchoice = $strip->strip_char($_POST['recommend']);
    $QUERY = "UPDATE BLOG_INFO SET BLOG_RECOMMEND='Y' WHERE BLOG_TITLE = '$editorchoice'";
    if($conn->query($QUERY)===True)
    {
        echo 'Y';
    }
    else
    {
        echo 'N';
    }
}