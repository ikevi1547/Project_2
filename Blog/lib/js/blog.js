
function signup()
{
    var name = document.getElementById('signupname').value;
    var email = document.getElementById('signupemail').value;
    var num = document.getElementById('signupnumber').value;
    var pass = document.getElementById('signuppass').value;
    var code = 'USER';
    //Regex for Valid Characters i.e. Alphabets, Numbers and Space.
    var regex = /^[A-Za-z0-9 ]+$/;
    var emailcheck = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if(name=="" || email=="" || num=="" || pass=="")
        {
            document.getElementById('error').style.display = 'block';
            document.getElementById('box').style.display = 'block';
            document.getElementById('alertPage').style.display = 'block';
            document.getElementById('warnmsg').innerHTML = 'Inputs Missing, provide valid inputs to create an account..';
        }
        else if(!regex.test(name))
        {
            document.getElementById('error').style.display = 'block';
            document.getElementById('box').style.display = 'block';
            document.getElementById('alertPage').style.display = 'block';
            document.getElementById('warnmsg').innerHTML = 'Invalid Name... Please check...<br> <b> Note: Name shouldn\'t contain special character</b>';
        }
        else if(!emailcheck.test(email))
        {
            document.getElementById('error').style.display = 'block';
            document.getElementById('box').style.display = 'block';
            document.getElementById('alertPage').style.display = 'block';
            document.getElementById('warnmsg').innerHTML = 'Enter Valid Email Address...';    
        }
        else if(isNaN(parseInt(num)))
        {
            document.getElementById('error').style.display = 'block';
            document.getElementById('box').style.display = 'block';
            document.getElementById('alertPage').style.display = 'block';
            document.getElementById('warnmsg').innerHTML = 'Enter Valid Contact Number...';  
        }
        else
        {
            var signup = new XMLHttpRequest();
            signup.open("POST", "../db/inseruserinfo.php", true);
            signup.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            signup.send("name="+name+"&email="+email+"&number="+num+"&pass="+pass+"&code="+code+"");
            signup.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    switch(this.responseText)
                    {
                    case 'N':
                        document.getElementById('error').style.display = 'block';
                        document.getElementById('box').style.display = 'block';
                        document.getElementById('alertPage').style.display = 'block';
                        document.getElementById('warnmsg').innerHTML = 'Error in User Creation, please try again later..';  
                        break;
                    case 'Y':
                        document.getElementById('success').style.display = 'block';
                        document.getElementById('box').style.display = 'block';
                        document.getElementById('alertPage').style.display = 'block';
                        document.getElementById('successmsg').innerHTML = 'Profile has been created';  
                        break;
                    case 'D':
                            document.getElementById('error').style.display = 'block';
                            document.getElementById('box').style.display = 'block';
                            document.getElementById('alertPage').style.display = 'block';
                            document.getElementById('warnmsg').innerHTML = 'User Name already exist';  
                        break;
                    }
                }
              };
        }
}

function signupAdmin()
{
    var name = document.getElementById('signupname').value;
    var email = document.getElementById('signupemail').value;
    var num = document.getElementById('signupnumber').value;
    var pass = document.getElementById('signuppass').value;
    var code = document.getElementById('signupcode').value;
    //Regex for Valid Characters i.e. Alphabets, Numbers and Space.
    var regex = /^[A-Za-z0-9 ]+$/;
    var emailcheck = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if(name=="" || email=="" || num=="" || pass=="" || code=="")
        {
            document.getElementById('error').style.display = 'block';
            document.getElementById('box').style.display = 'block';
            document.getElementById('alertPage').style.display = 'block';
            document.getElementById('warnmsg').innerHTML = 'Inputs Missing, provide valid inputs to create an account..';
        }
        else if(!regex.test(name))
        {
            document.getElementById('error').style.display = 'block';
            document.getElementById('box').style.display = 'block';
            document.getElementById('alertPage').style.display = 'block';
            document.getElementById('warnmsg').innerHTML = 'Invalid Name... Please check...<br> <b> Note: Name shouldn\'t contain special character</b>';
        }
        else if(!emailcheck.test(email))
        {
            document.getElementById('error').style.display = 'block';
            document.getElementById('box').style.display = 'block';
            document.getElementById('alertPage').style.display = 'block';
            document.getElementById('warnmsg').innerHTML = 'Enter Valid Email Address...';    
        }
        else if(isNaN(parseInt(num)))
        {
            document.getElementById('error').style.display = 'block';
            document.getElementById('box').style.display = 'block';
            document.getElementById('alertPage').style.display = 'block';
            document.getElementById('warnmsg').innerHTML = 'Enter Valid Contact Number...';  
        }
        else
        {
            var signup = new XMLHttpRequest();
            signup.open("POST", "../db/inseruserinfo.php", true);
            signup.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            signup.send("name="+name+"&email="+email+"&number="+num+"&pass="+pass+"&code="+code+"");
            signup.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    switch(this.responseText)
                    {
                    case 'N':
                        document.getElementById('error').style.display = 'block';
                        document.getElementById('box').style.display = 'block';
                        document.getElementById('alertPage').style.display = 'block';
                        document.getElementById('warnmsg').innerHTML = 'Error in User Creation, please try again later..';  
                        break;
                    case 'Y':
                        document.getElementById('success').style.display = 'block';
                        document.getElementById('box').style.display = 'block';
                        document.getElementById('alertPage').style.display = 'block';
                        document.getElementById('successmsg').innerHTML = 'Profile has been created';  
                        break;
                    case 'D':
                            document.getElementById('error').style.display = 'block';
                            document.getElementById('box').style.display = 'block';
                            document.getElementById('alertPage').style.display = 'block';
                            document.getElementById('warnmsg').innerHTML = 'User Name already exist';  
                        break;
                    case 'FAIL':
                            document.getElementById('error').style.display = 'block';
                            document.getElementById('box').style.display = 'block';
                            document.getElementById('alertPage').style.display = 'block';
                            document.getElementById('warnmsg').innerHTML = 'Access Code not valid';  
                        break;
                    }
                }
              };
        }
}

function closewarning()
{
    document.getElementById('error').style.display = 'none';
    document.getElementById('success').style.display = 'none';
    document.getElementById('box').style.display = 'none';
    document.getElementById('alertPage').style.display = 'none';
    location.reload();
}
function closewarning_main()
{
    document.getElementById('error').style.display = 'none';
    document.getElementById('success').style.display = 'none';
    document.getElementById('box_main').style.display = 'none';
    document.getElementById('alertPage').style.display = 'none';
    location.reload();
}

function signin()
{
    var name = document.getElementById('signinname').value;
    var pass = document.getElementById('signinpass').value;
    var signin = new XMLHttpRequest();
    signin.open('POST','../db/userloginvalidation.php', true);
    signin.setRequestHeader('content-type','application/x-www-form-urlencoded');
    signin.send('name='+name+'&pass='+pass+'');
    signin.onreadystatechange = function(){
        if(this.readyState==4 && this.status==200)
        {
            switch(this.responseText)
            {
                case 'Y':
                    var login = new XMLHttpRequest();
                    login.open('GET','../index.php?namelogin='+name+'',true);
                    login.send();
                    login.onreadystatechange = function(){
                        console.log(this.responseText);
                        if(this.readyState==4 && this.status==200)
                        {
                            switch(this.responseText)
                            {
                                case 'Y':
                                    window.open('../index.php','_self');
                                    break;
                            }
                        }
                    }
                    break;
                case 'N':
                    document.getElementById('error').style.display = 'block';
                    document.getElementById('box').style.display = 'block';
                    document.getElementById('alertPage').style.display = 'block';
                    document.getElementById('warnmsg').innerHTML = 'Invalid Password';  
                    break;
                case 'NA':
                    document.getElementById('error').style.display = 'block';
                    document.getElementById('box').style.display = 'block';
                    document.getElementById('alertPage').style.display = 'block';
                    document.getElementById('warnmsg').innerHTML = 'No Profile Created against this User Name, please check or create a new blog account to access'; 
                    break; 
            }
        }
    }
}

function logout()
{
    var logout = new XMLHttpRequest();
    logout.open('POST','../Blog/',true);
    logout.setRequestHeader('content-type','application/x-www-form-urlencoded');
    logout.send('namelogout=R');
    logout.onreadystatechange = function(){
        if(this.readyState==4 && this.status==200)
        {
            location.reload();
        }
    }
}

function deltag()
{
    var tag = document.getElementById('tags_view_menu').value;
    var deltag = new XMLHttpRequest();
    deltag.open('POST','../Blog/sub/delete.php',true);
    deltag.setRequestHeader('content-type','application/x-www-form-urlencoded');
    deltag.send('tagName='+tag+'');
    deltag.onreadystatechange = function(){
        if(this.readyState==4 && this.status==200)
        {
            switch(this.responseText)
            {
                case 'Y':
                    document.getElementById('success').style.display = 'block';
                    document.getElementById('box_main').style.display = 'block';
                    document.getElementById('alertPage').style.display = 'block';
                    document.getElementById('successmsg').innerHTML = 'Tag has been deleted Successfully';  
                    break;
                case 'N':
                    document.getElementById('error').style.display = 'block';
                    document.getElementById('box_main').style.display = 'block';
                    document.getElementById('alertPage').style.display = 'block';
                    document.getElementById('warnmsg').innerHTML = 'Not Deleted, please try again later..'; 
                    break; 
            }
        }
    }
}

function addtag()
{
    var tag = document.getElementById('tagname_new').value;
    var addtag = new XMLHttpRequest();
    addtag.open('POST','../Blog/sub/upload.php',true);
    addtag.setRequestHeader('content-type','application/x-www-form-urlencoded');
    addtag.send('tagName='+tag+'');
    addtag.onreadystatechange = function(){
        if(this.readyState==4 && this.status==200)
        {
            switch(this.responseText)
            {
                case 'Y':
                    document.getElementById('success').style.display = 'block';
                    document.getElementById('box_main').style.display = 'block';
                    document.getElementById('alertPage').style.display = 'block';
                    document.getElementById('successmsg').innerHTML = 'Tag has been added Successfully';  
                    break;
                case 'N':
                    document.getElementById('error').style.display = 'block';
                    document.getElementById('box_main').style.display = 'block';
                    document.getElementById('alertPage').style.display = 'block';
                    document.getElementById('warnmsg').innerHTML = 'Not Added, please try again later..'; 
                    break; 
            }
        }
    }
}

function addcategory()
{
    var category = document.getElementById('categoryname_new').value;
    var addcategory = new XMLHttpRequest();
    addcategory.open('POST','../Blog/sub/upload.php',true);
    addcategory.setRequestHeader('content-type','application/x-www-form-urlencoded');
    addcategory.send('categoryName='+category+'');
    addcategory.onreadystatechange = function(){
        if(this.readyState==4 && this.status==200)
        {
            switch(this.responseText)
            {
                case 'Y':
                    document.getElementById('success').style.display = 'block';
                    document.getElementById('box_main').style.display = 'block';
                    document.getElementById('alertPage').style.display = 'block';
                    document.getElementById('successmsg').innerHTML = 'Category has been added Successfully';  
                    break;
                case 'N':
                    document.getElementById('error').style.display = 'block';
                    document.getElementById('box_main').style.display = 'block';
                    document.getElementById('alertPage').style.display = 'block';
                    document.getElementById('warnmsg').innerHTML = 'Not Added, please try again later..'; 
                    break; 
            }
        }
    }
}

function delcategory()
{
    var category = document.getElementById('category_view_menu').value;
    var delcategory = new XMLHttpRequest();
    delcategory.open('POST','../Blog/sub/delete.php',true);
    delcategory.setRequestHeader('content-type','application/x-www-form-urlencoded');
    delcategory.send('categoryName='+category+'');
    delcategory.onreadystatechange = function(){
        if(this.readyState==4 && this.status==200)
        {
            switch(this.responseText)
            {
                case 'Y':
                    document.getElementById('success').style.display = 'block';
                    document.getElementById('box_main').style.display = 'block';
                    document.getElementById('alertPage').style.display = 'block';
                    document.getElementById('successmsg').innerHTML = 'Category has been deleted Successfully';  
                    break;
                case 'N':
                    document.getElementById('error').style.display = 'block';
                    document.getElementById('box_main').style.display = 'block';
                    document.getElementById('alertPage').style.display = 'block';
                    document.getElementById('warnmsg').innerHTML = 'Not Deleted, please try again later..'; 
                    break; 
            }
        }
    }
}

function edit_blog_icon(title="",category="",content="",image_path="",author="",tags="",status="",event_time="",admin_comments="",id="")
{
    document.getElementById('title_edit').value = title;
    document.getElementById('categorynewblog_edit').value = category;
    document.getElementById('contentnewblog_edit').value = content;
    document.getElementById('date_time_edit').value = event_time;
    document.getElementById('authorname_edit').value = author;
    var stat = document.getElementsByName('status[]');
    document.getElementById('id_edit').value = id;
    document.getElementById('comments_edit').value = admin_comments;

    for(let i=0;i<2;i++)
    {
        stat[i].checked = false;
    }
    for(let i=0;i<2;i++)
    {
        if(stat[i].value==status)
            {
                stat[i].checked = true;
            }
    }
    var tag = [];
    var dum_indx = 0;    
    var get_tag_el = document.getElementsByName("tag_edit[]");
    
    for(let i=0;i<tags.length;i++)
    {
        if(tags[i]!="-")
        {           
            tag[dum_indx] += tags[i];
        }
        else if(tags[i]=="-")
        {
            tag[dum_indx] = tag[dum_indx].replace('undefined',"");            
            dum_indx++;
        }
    }
    for(let i=0;i<get_tag_el.length;i++)
    {
        get_tag_el[i].checked = false;
    }
    for(let i=0;i<get_tag_el.length;i++)
    {
        for(let j=0;j<tag.length;j++)
        {
            if(get_tag_el[i].value==tag[j])
                {
                    get_tag_el[i].checked = true;
                }
        }
    }
    document.getElementById('edit_blog').style.display = 'block';
}

function delete_blog_icon(title="")
{
    var delete_blog = new XMLHttpRequest();
    delete_blog.open('POST','../Blog/sub/delete.php',true);
    delete_blog.setRequestHeader('content-type','application/x-www-form-urlencoded');
    delete_blog.send('title_blog_delete='+title+'');
    delete_blog.onreadystatechange = function(){
        if(this.readyState==4 && this.status==200)
        {
            switch(this.responseText)
            {
                case 'Y':
                    document.getElementById('success').style.display = 'block';
                    document.getElementById('box_main').style.display = 'block';
                    document.getElementById('alertPage').style.display = 'block';
                    document.getElementById('successmsg').innerHTML = 'Blog Deleted';  
                    break;
                case 'N':
                    document.getElementById('error').style.display = 'block';
                    document.getElementById('box_main').style.display = 'block';
                    document.getElementById('alertPage').style.display = 'block';
                    document.getElementById('warnmsg').innerHTML = 'Not Deleted, please try again later..';
                    break;
            }  
        }
    }
}

function close_edit_blog()
{
    document.getElementById('edit_blog').style.display = 'none';
}

function close_comment_blog()
{
    history.back();
}

function submit_user_comments(table="",user="")
{
    var comment = document.getElementById(table).value; 
    if(comment=="")
        {
            document.getElementById('error').style.display = 'block';
            document.getElementById('box_main').style.display = 'block';
            document.getElementById('alertPage').style.display = 'block';
            document.getElementById('warnmsg').innerHTML = 'No Comments';
        }
        else
        {
            var commentreq = new XMLHttpRequest();
            commentreq.open('POST','../Blog/sub/upload.php',true);
            commentreq.setRequestHeader('content-type','application/x-www-form-urlencoded');
            commentreq.send('commenttable='+table+'&commentuser='+user+'&comments='+comment+'');
            commentreq.onreadystatechange = function(){
            if(this.readyState==4 && this.status==200)
            {
                switch(this.responseText)
                {
                    case 'Y':
                        document.getElementById('success').style.display = 'block';
                        document.getElementById('box_main').style.display = 'block';
                        document.getElementById('alertPage').style.display = 'block';
                        document.getElementById('successmsg').innerHTML = 'Comment Added';  
                        break;
                    case 'N':
                        document.getElementById('error').style.display = 'block';
                        document.getElementById('box_main').style.display = 'block';
                        document.getElementById('alertPage').style.display = 'block';
                        document.getElementById('warnmsg').innerHTML = 'Not Added, please try again later..';

                }
            }
            }
        }
    
}

function addtitleEditor()
{
    var recommend = document.getElementById('editor_title').value;
    var recom = new XMLHttpRequest();
    recom.open('POST','../Blog/sub/upload.php',true);
    recom.setRequestHeader('content-type','application/x-www-form-urlencoded');
    recom.send('recommend='+recommend+'');
    recom.onreadystatechange = function(){
            if(this.readyState==4 && this.status==200)
            {
                switch(this.responseText)
                {
                    case 'Y':
                        location.reload(); 
                        break;
                    case 'N':
                        document.getElementById('error').style.display = 'block';
                        document.getElementById('box_main').style.display = 'block';
                        document.getElementById('alertPage').style.display = 'block';
                        document.getElementById('warnmsg').innerHTML = 'Not Added, please try again later..';

                }
            }
            }
}

function removeeditorchoice(title="")
{
    var recommend = title;
    var recom = new XMLHttpRequest();
    recom.open('POST','../Blog/sub/delete.php',true);
    recom.setRequestHeader('content-type','application/x-www-form-urlencoded');
    recom.send('recommend_delete='+recommend+'');
    recom.onreadystatechange = function(){
            if(this.readyState==4 && this.status==200)
            {
                switch(this.responseText)
                {
                    case 'Y':
                        location.reload(); 
                        break;
                    case 'N':
                        document.getElementById('error').style.display = 'block';
                        document.getElementById('box_main').style.display = 'block';
                        document.getElementById('alertPage').style.display = 'block';
                        document.getElementById('warnmsg').innerHTML = 'Not Deleted, please try again later..';

                }
            }
            }
}

function closewarning_err()
{
    document.getElementById('alertBoxerr').style.display = 'none';
    document.getElementById('box_err').style.display = 'none';
    document.getElementById('alertcontent_err').style.display = 'none';
    window.open("../Blog/index.php","_self");
}