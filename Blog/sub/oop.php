<?php

error_reporting(0);
date_default_timezone_set('Asia/Kolkata');

// dashboard count variables

$blog_post_count = 0;
$blog_cat_count = 0;
$blog_tag_count = 0;
$blog_draft_count = 0;
$blog_publish_count = 0;
$editor_choice_count = 0;

// login status class

class login_update
    {
        public $userlogin_status_name = 'logininfo';
        function set_status($stat_value='N')
        {
            setcookie($this->userlogin_status_name,$stat_value,time()+(300),'../index.php');
        }
    }

// tags seperating class

class tag_seperate
    {
        public $tag_sep_arr = [];
        function sep($data="")
        {
            $dum_index = 0;
            for($i=0;$i<strlen($data);$i++)
                {
                    if($data[$i]!="-")
                        {
                            $this->tag_sep_arr[$dum_index] .= $data[$i];
                        }
                    elseif($data[$i]=="-")
                        {
                            $dum_index++;
                        }
                }
        }
    }

// title seperate and unseperate class

class tit_sep
    {
        public $title_inp;
        public $title_sep = "";
        function sep_title($input_title)
        {
            $this->title_inp = $input_title;
            $this->title_inp = trim($this->title_inp);
            for($i=0;$i<strlen($this->title_inp);$i++)
            {
                if($this->title_inp[$i]!=" ")
                    {
                        $this->title_sep .= $this->title_inp[$i];
                    }
                elseif($this->title_inp[$i]==" ")
                    {
                        $this->title_sep .= "_";
                    }
            }
        }
        function remove_sep_title($input_title)
        {
            $this->title_inp = $input_title;
            $this->title_inp = trim($this->title_inp);
            for($i=0;$i<strlen($this->title_inp);$i++)
            {
                if($this->title_inp[$i]!="_")
                    {
                        $this->title_sep .= $this->title_inp[$i];
                    }
                elseif($this->title_inp[$i]=="_")
                    {
                        $this->title_sep .= " ";
                    }
            }
        }
    }

// STRING REPLACE SPECIAL CHARACTER ' WITH \'

class special
    {
        function strip_char($data="")
            {
                $data = str_replace("'","\'",$data);
                return $data;
            }
    }