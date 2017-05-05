<?php

require 'classes.php';
?>


<! doctype html>
<html>
    <head>
        <title>changePassword</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/animate.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Neucha" rel="stylesheet"> 
        
        <style>
            label{
                display: inline-block;
                font-size: 20px;
            }
            i{
                padding-right: 5px;
            }
            body{
                color: aliceblue;
                background-image: url(../project2/imges/b.jpg);
                background-repeat: no-repeat;
                background-size: cover;
                background-attachment: fixed;
                background-position: 50% 50%;
                font-size: 20px;
            }
        
        </style>
    </head>

    <body>
        <div class="container" style="margin-top:2%;">
            <div class="row text-center">
                <div class="col-md-12">
                    <h1><i class="fa fa-unlock-alt"></i>change data</h1>
                </div>
            </div>
            
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form method="post">
                        <br>
                        <label for="email">Email</label>
                        <input name="email_n" id="email_n"  type="email" class="form-control">
                        <br>
                        <label for="user_name">user_name</label>
                        <input name="user_name" id="user_name"  type="text" class="form-control">
                        <br>
                         <br>
                        <label for="password">new-password</label>
                        <input name="password" id="password"  type="password" class="form-control">
                        <br>
                        <label for="password">re-password</label>
                        <input name="re" id="repassword"  type="password" class="form-control" >
                        <br>
                       <?php $change_button=new buttonFactory();
                        $change_obj=$change_button->creatButton(4);
                        
                        if(isset($_POST['ch']))
                        {
                                $variable=array(
                                    "email"=>$_POST['email_n'],
                                    "username"=>$_POST['user_name'],
                                    "password"=>$_POST['password'],
                                    "re"=>$_POST['re']
                                );
                                $change_obj->onpress($variable,$var);                            
                        }
                        echo'<a href="index.php" class="btn btn-primary" style="margin-left:40%;" >Go to Home</a>';
                        ?>
                    </form>
                </div>
            
            </div>
        
        </div>
    

    </body>


</html>