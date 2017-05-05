<?php
    require 'classes.php';

?>



<! doctype html>
<html>

    <head>
        <title>Login</title>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/animate.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Alegreya:400,700i" rel="stylesheet">         <style>
           *{

                font-family: 'Alegreya', serif;
               background-image: url(imges/15139-NQ17BQ.jpg);
               background-position: 50% 50%;
               background-attachment: fixed;
               background-repeat: no-repeat;
               background-size: cover;
;            }
        h1{
            font-weight: 700;
            font-family: 'Alegreya', serif;
            font-size: 40px;
            color: aliceblue;
        }
            form{
                color: aliceblue;
                display: block;
                margin-top: 100px;
                width: 70%;
                border: 2px solid #9bbbe4;
                border-radius: 5px;
                font-size: 26px;
                padding:50px;
            }
            .s{
                background-color: cornflowerblue;
                color: aliceblue;
                font-size: 25px;
                font-weight: 700;
                text-align: center;
                line-height: 20px;
            }
            .s:hover{
                background-color: #407ff0;
            }
            h1{
                padding-top: 100px;
            }
        i{
            padding-right: 43px;
        }
        a{
            font-size: 20px;
            padding-left: 30px;
            color: aliceblue;
        }
        .sign{
            padding-right: 20px;
            font-family: 'Alegreya', serif;
            font-weight: 700;
            text-align: right;
            font-size: 28px;
        }
        .ff{
            margin-top: -10px;
        }
        </style>
    
    
    </head>
    <body>
        <div class="container text-right">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $q="SELECT * FROM owner";
                    $result=$var->conn->prepare($q);
                    $result->execute();
                    if($result->rowCount()==0)
                    {
                        echo '<a class="sign" href="signUp.php">sign up</a>';
                    }
                            
                    ?>   
                </div>
            </div>
        </div>
        <h1 class="text-center"><i class="fa fa-shopping-bag"></i>Welcome To Mega Store</h1>
        <div class="container ff">
            <div class="row">
                <div class="col-md-6 col-md-offset-4">
                  <form action="" method="post" class=" form">
                        <label>username:</label>
                        <input type="text" name="name" placeholder="Your user name" class="form-control" required autocomplete="off"><br>
                            <label>Password:</label>
                            <input type="password" name="pass" placeholder="Your password" class="form-control" required autocomplete="off"><br>
                            <?php 
                             $margin_array=array(
                                        "top"=>0,
                                        "bottom"=>0,
                                        "left"=>0,
                                        "right"=>0,
                                    );
                                    $padding_array=array(
                                        "top"=>0,
                                        "bottom"=>0,
                                        "left"=>0,
                                        "right"=>0,
                                    );
                                   $login_button=new buttonFactory("#fff",$margin_array,$padding_array);
                                $login_obj=$login_button->creatButton(1);
                                if(isset($_POST['login']))
                                {
                                    $user_password=array(
                                    "name"=> $_POST['name'],
                                    "pass"=> $_POST['pass']
                                );
                                $login_obj->onpress($user_password,$var);
                                }

                            ?> 
                      <br>
                            <a href="forgetPassword.php" class="text-center">forget password?</a>
                    </form>
                </div>
            </div>
        </div>
    </body>

</html>