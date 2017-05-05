<?php

require 'classes.php';




?>
<! doctype html>
<html>
    <head>
        <title>ForgetPassword</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/animate.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Neucha" rel="stylesheet"> 
        
        <style>
            label{
                display: inline-block;
            }
            i{
                padding-right: 5px;
            }
        
        
        </style>
    </head>

    <body>
        <div class="container">
            <div class="row text-center">
                <div class="col-md-12">
                    <h1>Mega Store</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3><i class="fa fa-key"></i>Forget Password</h3>
                </div>
            </div>
            
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form method="post">
                        <br>
                        <br>
                        <br>
                        <label for="email">Email</label>
                        <input name="email" id="email"  type="email" class="form-control" required>
                        <br>
                        <label>Secure Question</label><br>
                        <select name="question" class="form-control" required >
                            <option disabled selected>Choose Your Secure Question?</option>
                            <option>What is your father's name?</option>
                            <option>Where was you born?</option>
                            <option>What is you favorite sport?</option>
                            <option>Which primary school you joined to?</option>
                        </select><br>
                        <label>Answer:</label>
                        <input name="answer" type="text" class="form-control" required >
                        <br>
                        <?php $forget_button = new buttonFactory();
                        
                        $forget_obj = $forget_button->creatButton(2);
                        
                        if(isset($_POST['forget']))
                        {
                        $variable=array(
                        "email"=>$_POST['email'],
                        "question"=>$_POST["question"],
                        "answer"=>$_POST["answer"]
                        );
                        $forget_obj->onpress($variable,$var);
                        }
                        ?>                    </form>
                </div>
            
            </div>
        
        </div>
    

    </body>


</html>