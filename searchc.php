<?php
    require 'classes.php';

if(!$_SESSION['login_in']==true)
{
    session_destroy();
    header("location:login.php");
}
                                        $check=true;
                                        $customer_name=$_SESSION['cust'];
                                        
                                        $Cquery="select name from buyer where name='$customer_name'";
                                        $result=$var->conn->prepare($Cquery);
                                         $result->execute();
                                        echo    $result->rowCount();
                                        if($result->rowCount()>0)
                                            {
                                                $check=false;
                                            }

                            //// variables --------------------phone-------------------email--------------------->                
                                    $phone='';
                                    $bemail='';
                                    if(!$check==true){
                                        
                                             $sth =$var->conn->prepare("select phone,email from buyer where name='$customer_name'");
                                                $sth->execute();
                                                $result = $sth->fetchAll(PDO::FETCH_ASSOC);

                                        
                                      foreach($result as $Rows)
                                        {  
                                            $phone=$Rows['phone'];
                                            $bemail=$Rows['email'];
                                        }
                            // variables ---------------------------------------->
                                        $buyer_id='';
                                        
                                        
                                                $sth =$var->conn->prepare("select id from buyer where name='$customer_name'");
                                                $sth->execute();
                                                $result = $sth->fetchAll(PDO::FETCH_ASSOC);
                                      foreach($result as $Rows)
                                        {  
                                            $buyer_id=$Rows['id'];
                                        }
                                        
                                    }
?>
<html>
    <head>
        <title>customer</title>
         <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/animate.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Neucha" rel="stylesheet"> 
    </head>
    <style>
        body{
            background-attachment: fixed;
            background-image: url(../project2/imges/wood-1108307_1920.jpg);
            background-size: cover;
            background-color: rgba(31,31,31,.7);
            color: white;
        }
        h3{
            border: 2px solid white;
            border-radius: 9px;
            text-align: center;
        }
        tody.scrollcontent{
            overflow-x: hidden;
            overflow-y: auto;
        }
    </style>
    <body>
            <h1 style="font-family:'Neucha', cursive;">search for a customer</h1><br>
            <a href="index.php" style="font-size:20px; color:white; margin-left:45%;" >Go to Home Page</a><br><br>
                                    <?php if(!$check=="true") {?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                            <h3>Customer Info</h3><br>
                                                <table class="table table-stripped header-fixed" style="font-size:20px;">
                                                    <thead>
                                                        <tr>
                                                            <th>Customer Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?php echo $customer_name ; ?></td>
                                                            <td><?php echo $bemail ; ?></td>
                                                            <td><?php echo $phone ; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>                                    
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br><br>
        
        
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                                <h3>Product Info</h3><br>
                                                    <table class="table scrollcontent">
                                                        <thead>
                                                            <tr>
                                                                <th>Product Name</th>
                                                                <th>Sold Amount</th>
                                                                <th>Date Of Selling</th>
                                                                <th>price / unit</th>
                                                                <th>Total Price</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                             <?php
                                            // question about query        
                                              $sth =$var->conn->prepare("select DISTINCT  product.name,amount,price,DateOfSelling from bill,product,buyer where Bid='$buyer_id' AND Pid=product.id ;
                                             ");
                                             
                                                $sth->execute();
                                                $result = $sth->fetchAll(PDO::FETCH_ASSOC);                   
                                             
                                      foreach($result as $Rows)
                                        {   echo '<tr>';
                                            echo '<td>'.$Rows['name'].'</td>';
                                            echo '<td>'.$Rows['amount'].'</td>';
                                            echo '<td>'.$Rows['DateOfSelling'].'</td>';
                                            echo '<td>'.$Rows['price'].' LE'.'</td>';
                                            echo '<td>'.$Rows['amount']*$Rows['price'].' LE'.'<td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                                            
                                                        </tbody>
                                                    </table>                                    
                                                </div>
                                            </div>
                                        </div>
                                                                         
            
                              <?php } else echo 'Not Exist in DataBase';  ?>        
    </body>
    

</html>