<?php

require '../db/db.php';
require 'oop.php';

$strip = new special();

if(isset($_POST['tagName']))
{
    $tag = $strip->strip_char($_POST['tagName']);
    $QUERY = "DELETE FROM BLOG_TAGS WHERE BLOG_TAG = '$tag'";
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
    $QUERY = "DELETE FROM BLOG_CATEGORIES WHERE BLOG_CATEGORY = '$category'";
    if($conn->query($QUERY)===True)
    {
        echo 'Y';
    }
    else
    {
        echo 'N';
    }
}

if(isset($_POST['title_blog_delete']))
{
    $title = $strip->strip_char($_POST['title_blog_delete']);

    $RunQuery = mysqli_query($conn,"SELECT BLOG_PHOTOS_PATH,BLOG_COMMENT_TABLE_NAME FROM BLOG_INFO WHERE BLOG_TITLE='$title'");
    $data = mysqli_Fetch_array($RunQuery);

    $QUERY = "DELETE FROM BLOG_INFO WHERE BLOG_TITLE = '$title'";
    if($conn->query($QUERY)===True)
    {
        unlink("blog_content/".$data[0]."");
        
        $QUERY = "DROP TABLE `$data[1]`";
        $conn->query($QUERY);
        echo 'Y';
    }
    else
    {
        echo 'N';
    }
}

if(isset($_POST['recommend_delete']))
{
    $editorchoice = $strip->strip_char($_POST['recommend_delete']);
    $QUERY = "UPDATE BLOG_INFO SET BLOG_RECOMMEND='N' WHERE BLOG_TITLE = '$editorchoice'";
    if($conn->query($QUERY)===True)
    {
        echo 'Y';
    }
    else
    {
        echo 'N';
    }
}