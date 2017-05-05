<?php
    require 'classes.php';

if(!$_SESSION['login_in']==true)
{
    session_destroy();
    header("location:login.php");
}
$check=true;
$num='';
$price='';
$image='';
?>
<html>
    <head>
        <title>product</title>
         <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/animate.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Neucha" rel="stylesheet"> 
        <style>
            body{
                color: white;
                background-image: url(../project2/imges/chair-505850_1920.jpg);
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            }
            h1{
                border: 2px solid white;
                border-radius: 5px;
                text-align: center;
                margin-left: 25%;
                width: 50%;
            }
        </style>
        
    </head>
    <body>
        <br><br>
        <a href="index.php" class="btn btn-primary text-center" style="margin-left:45%;">Go to Home</a><br><br>
        <h1 style="font-family: 'Neucha', cursive;">Category Name:  <?php
            
                              $myid=$_GET["minee"];
                    $sth =$var->conn->prepare("select distinct name from category where id='$myid'");
                                                 $sth->execute();
                                                 $result = $sth->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($result as  $num  )
                                    {
                                        echo $num['name'];
                                    }
                                ?> </h1><br>
        
                    <?php 
                                 
                            
        
                                  $sth =$var->conn->prepare("select name,number,price,image from product where categoryID='$myid'AND Found=1");
                                                $sth->execute();
                                                $result = $sth->fetchAll(PDO::FETCH_ASSOC);

                                        
                                      foreach($result as $Rows)
                                        {   
                                            $p_na=$Rows['name'];
                                            $num=$Rows['number'];
                                            $price=$Rows['price'];
                                            $image=$Rows['image'];
        
                                echo '<div class="container">
                                    <div class="row">
                                    <div class="col-md-3">
		                               <img width="50%" height="30%" src="data:image/jpeg;base64,'.base64_encode( $Rows['image'] ).' "/>
                                     </div>
                                     <div class="col-md-9" style="margin-top:5%;">
                                     <table class="table" style="font-size:20px;">
                                        <thead>
                                             <tr>
                                                <th>product name</th>
                                                 <th>amount</th>
                                                 <th>price/unit</th>
                                                 <th>total price</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                            <tr>
                                                 <th>'.$p_na.'</th>
                                                 <th>'.$num.'</th>
                                                 <th>'.$price.'</th>
                                                 <th>'.$num.'</th>
                                             </tr>
                                         </tbody>
                                     </table>
                                
                                              </div>                            
                                             </div>                              
                                
                                
                                
                                
                                </div>';    
                                        }
        
                           
                                        ?>

    
    </body>

</html>