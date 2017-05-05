
<?php
require 'classes.php';


?>

<! doctype html>

<html>
    <head>
        <title>SignUp</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/animate.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Neucha" rel="stylesheet"> 
        
        <style>
            
            h3{
                margin: 60px;
            }
            i{
                padding-right: 30px;
            }
            .mar{
                position: relative;
                left: 40%;
            }
            form{
                width: 90%;
                font-size: 20px;
                border: 3px solid #b0bae0;
                padding: 14px;
                border-radius:50px;;
            }
        
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                 <h3><i class="fa fa-user-plus"></i>Sign up</h3>
                        <?php if(isset(sign_up::$conf)){?><div class="row">
                        <div class="alert alert-danger" style="width:200px;" role="alert"><?php echo "password does not match";?></div>
                        </div><?php }?>   
                </div>
                <div class="col-md-6">
                <h1>Mega Store</h1>
                
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                   <form class="form" method="post" action="">
                        <label>User Name</label><br>
                        <input type="text" name="user" required class="form-control">
                        <label>first name:</label><br>
                        <input type="text" name="first" required class="form-control">
                        <label>last name:</label>
                        <input type="text" name="last" required class="form-control" >
                        <label>email:</label>
                        <input type="email" name="Email"  class="form-control" required>
                        <label>password:</label>
                        <input type="password" id="p" name="password" class="form-control" required>
                        <label>Re-password:</label>
                        <input type="password" id="rp" name="rpassword" class="form-control" required>
                        <label>Secure-Question:</label>
                        <select class="form-control" name="question" required>
                            <option disabled selected>Choose Your Secure Question?</option>
                            <option>What is your favourite club?</option>
                            <option>Where was you born?</option>
                            <option>What is you favourite sport?</option>
                            <option>Which primary school you joined to?</option>
                        </select>
                        <label>Answer:</label>
                        <input type="text" name="answer" required class="form-control"  >
                        <br>
                        <?php 
                        $Sign_up_button =new buttonFactory();
                        $signUp_obj=$Sign_up_button->creatButton(3);
                                if(isset($_POST['signup'])){
                            $variable=array(
                                        "username"=>$_POST['user'],
                                    "first"=>$_POST['first'],
                                    "last"=>$_POST['last'],
                                    "email"=>$_POST['Email'],
                                    "password"=>$_POST['password'],
                                    "question"=>$_POST['question'],
                                    "answer"=>$_POST['answer']);
                                    $signUp_obj->onpress($variable ,$var);
                                }
                        
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>