<?php
    require 'classes.php';

if(!$_SESSION['login_in']==true)
{
    session_destroy();
    header("location:login.php");
}
                                        $check=true;
                                        echo $product_name=$_SESSION['ppname'];
                                        
                                        $Cquery="select name from product where name='$product_name'";
                                        $result=$var->conn->prepare($Cquery);
                                         $result->execute();
                                        echo    $result->rowCount();
                                        if($result->rowCount()>0)
                                            {
                                                $check=false;
                                            }

                            //// variables -----------phone------email--------------------->                
                                    $num='';
                                    $price='';
                                    $image='';
                                    if(!$check==true){
                                        
                                             $sth =$var->conn->prepare("select number,price,image from product where name='$product_name' AND Found=1");
                                                $sth->execute();
                                                $result = $sth->fetchAll(PDO::FETCH_ASSOC);

                                        
                                      foreach($result as $Rows)
                                        {  
                                            $num=$Rows['number'];
                                            $price=$Rows['price'];
                                            $image=$Rows['image'];
                                        }
                                    }
?>
<?php 
 
                                        $Cquery="select name from product where name='$product_name' AND found=1";
                                        $result=$var->conn->prepare($Cquery);
                                         $result->execute();
                                            if($result->rowCount()!=1)
                                            require 'not_found.php';
else{
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
                 background-attachment: fixed;
            background-image: url(../project2/imges/c.jpg);
            background-size: cover;
            background-color: rgba(31,31,31,.7);
            color: white;
                
                       }

            table tr td, table tr th{
            }
        h3{
            border: 2px solid white;
            border-radius: 9px;
            text-align: center;
            width: 50%;
            margin-left: 25%;
            margin-top: 12px;;
        }
        </style>
        
    </head>
    <body>
            <h1 style="  font-family: 'Neucha', cursive; margin-left:13px;"><i style="margin-right:12px;" class="me fa fa-info"></i>Result Found</h1>
                                    <?php if(!$check=="true") {?>
                            <div class="container">
                                <div class="row">
                                    
                                    <div class="col-md-12" style="margin:auto;">
                                    <br>
                                        <div>
                                        <h3>Product Info</h3><br>   

                                            <div class="row">
                                              <div class="col-lg-6 col-md-offset-2">
                                                <div class="">
                                            <?php
                                               
		                            echo '<img width="50%" height="25%" style="margin-left:37%" border-radius:20px;" src="data:image/jpeg;base64,'.base64_encode( $Rows['image'] ).' "/>';
                                                ?>                                                  
                                                </div>
                                              </div>
                                            </div>                                            
                                            
                                            

                                        </div>
                                        
                                        <br><br><br>
                                        
                                        <table class="table table-responsive" style="font-size:18px; margin-top:100px;">
                                            <thead>
                                                <tr>
                                                    <th>product name</th>
                                                    <th>amount</th>
                                                    <th>price / unit</th>
                                                    <th>Total price</th>                                                
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $product_name;?></td>
                                                    <td><?php echo $num; ?></td>
                                                    <td><?php echo $price.' LE'; ?></td>
                                                    <td><?php echo $price*$num.' LE'; ?></td>                                                     
                                                </tr>
                                            </tbody>
                                        </table>
                                   
                                        </div> 
                                        
                                    </div>

                                </div>
                              <?php } else echo 'Not Exist in DataBase';  ?>      
        
        <?php }?>
    
    </body>

</html>