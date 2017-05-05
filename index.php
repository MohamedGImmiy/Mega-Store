<?php

require 'classes.php';

if(!$_SESSION['login_in']==true)
{
    session_destroy();
    header("location:login.php");
}


if(isset($_POST['del']))  
{
   // echo 'yeeeees';
    $ID=$_POST['del']; 
     echo $ID;



//don't delete from database as i need its information in selling process even it is not found     
$q2="UPDATE  product SET  Found='0' , number='0' where id='$ID'";
$var->conn->exec($q2);
                  


     
}


////////////////////////////////////////////////////*** sell ***/////////////////////////////////////////////////////////////////////

      $buyerUn="";
      $amounts="";
      $dat="";
      $productID="";
      $buyerem="";
      $buyerph="";
  
      
    if (isset($_POST['buyerName']))
    {
      $buyerUn=$_POST['buyerName'];         
    }
    if (isset($_POST['sellID']))
    {
      $productID=$_POST['sellID'];         
    }
    
     if (isset($_POST['amount_sold']))
    {
      $amounts=$_POST['amount_sold'];         
    } 
      
    if (isset($_POST['date']))
    {
      $dat=$_POST['date'];         
    }
    if (isset($_POST['buyerEmail']))
    {
      $buyerem=$_POST['buyerEmail'];         
    }
    if (isset($_POST['buyerPhone']))
    {
      $buyerph=$_POST['buyerPhone'];         
    }
        
    if($buyerUn!=""&&$amounts!=""&&$dat!="")
    {
    $sth=$var->conn->prepare("SELECT `number` FROM product where id='$productID' "); // to get last id of added buyer  
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        
    $newAmount;
    foreach($result as $Rows)
      {  
       $newAmount=$Rows['number']-$amounts;
      }
    
      if($newAmount>=0)
      {    
       $buyerid;
      $flag1=false;
      $sth=$var->conn->prepare("SELECT * FROM buyer");  
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      foreach($result as $Rows)
      {  
         if($buyerUn==$Rows['name'])
         {
             $buyerid=$Rows['id'];
             $q1="UPDATE  buyer SET  email='$buyerem' where id='$buyerid'";
             $var->conn->exec($q1);
             
             $q2="UPDATE  buyer SET  phone=' $buyerph' where id='$buyerid'";
             $var->conn->exec($q2);
             
             $flag1=true;  
         }
    
         }              
      if(!$flag1)   //create new buyer
      {
        
        $q3="INSERT INTO buyer (`name`,`email`,`phone`) VALUES ('$buyerUn','$buyerem','$buyerph')";
        $var->conn->exec($q3);
          
      $sth=$var->conn->prepare("SELECT * FROM buyer"); // to get last id of added buyer  
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
       $Id;
       foreach($result as $Rows)
         {  
           $Id=$Rows['id'];
         }   
        $buyerid=$Id;  
      }
      
      
    
    
    $q4="INSERT INTO bill (`Pid`,`Bid`,`amount`,`DateOfSelling`) VALUES ('$productID',' $buyerid','$amounts','$dat')";
    $var->conn->exec($q4);
        
    $q1="UPDATE  product SET  number='$newAmount' where id='$productID'";
    $var->conn->exec($q1);
    ////////////////////////////////////////////// adefha 
    if($newAmount==0)
    {
        $q1="UPDATE  product SET  Found='0' where id='$productID'";
        $var->conn->exec($q1);
    }
      }
      
      else
      {
          
          echo 'amount not available in the store';
      }
      
    }

    
     
/**************************************************************update*////////////////////////////////////////////////////////    
    
    if(isset($_POST['subm']))
    {
        
  //   echo "gogogo";
    $Uid="";
    $Uname="";
    $Ucnam="";
    $Upric="";
    $Uam="";
    $uim="";
    
    $status=false;
    
       
    if(isset($_FILES['image']))
    {
    //      echo "aywaaaaaa";
     $file=$_FILES['image']['tmp_name'];
    $image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
     $image_name=addslashes($_FILES['image']['name']);
     $image_size= getimagesize($_FILES['image']['tmp_name']);  //check if img or not
     if($image_size==true)
         $status=true;
    }
    
    if (isset($_POST['updateID']))
    {
      $Uid=$_POST['updateID'];         
    }
    if (isset($_POST['upname']))
    {
      $Uname=$_POST['upname'];         
    }
    if (isset($_POST['ucname']))
    {
      $Ucnam=$_POST['ucname'];         
    }
    if (isset($_POST['uprice']))
    {
      $Upric=$_POST['uprice'];         
    }
    if (isset($_POST['upamount']))
    {
      $Uam=$_POST['upamount'];         
    }
    $catid;
    if($Ucnam!="")
    {
      $flag=false;
      $sth=$var->conn->prepare("SELECT * FROM category");  
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      foreach($result as $Rows)
      {  
         if($Ucnam==$Rows['name'])
         {
             $catid=$Rows['id'];
             $flag=true;  
         }
      }              
      if(!$flag)   //create new category
      {
        $q1="INSERT INTO category (`name`) VALUES ('$Ucnam')";
        $var->conn->exec($q1);
          
      $sth=$var->conn->prepare("SELECT * FROM category"); // to get last id of added category  
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
       $Id;
       foreach($result as $Rows)
         {  
           $Id=$Rows['id'];
         }   
        $catid=$Id;  
      }
    } 
    
    
    if($Uname!="")
    { 
        $q1="UPDATE  product SET  name='$Uname' where id='$Uid'";
        $var->conn->exec($q1);
    }
    if($Ucnam!="")
    { 
        $q1="UPDATE  product SET  categoryID='$catid' where id='$Uid'";
        $var->conn->exec($q1);
    }
    if($Uam!="")
    { 
         $q1="UPDATE  product SET   number='$Uam' where id='$Uid'";
             $var->conn->exec($q1);    
    }
    if($Upric!="")
    { 
        $q1="UPDATE  product SET   price='$Upric' where id='$Uid'";
             $var->conn->exec($q1);
  
    }
    if($status==true)
    { 

        
        $q1="UPDATE  product SET  image='$image' where id='$Uid'";
        $var->conn->exec($q1);
  
    }
    }
    
                   /*******************************************add new product****************************/ 
    if(isset($_POST['sub']))
    {
    $em="";        
    $sname="";
    $dph="";
    $pn="";
    $im="";
    $pr="";
    $pam="";
    $catname="";
    
    if (isset($_POST['email']))   
    {
      $em=$_POST['email']; 
    }
    if (isset($_POST['userName']))
    {
      $sname=$_POST['userName']; 
    }
    if (isset($_POST['dphone']))
    {
      $dph=$_POST['dphone']; 
    }
    if (isset($_POST['image']))
    {
      $im=$_POST['image'];         
    }
    if (isset($_POST['pamount']))
    {
      $pam=$_POST['pamount'];         
    }
    if (isset($_POST['price']))
    {
      $pr=$_POST['price'];         
    }
    if (isset($_POST['pname']))
    {
      $pn=$_POST['pname'];         
    }
    if (isset($_POST['cname']))
    {
      $catname=$_POST['cname'];         
    }
    $status=false;
    $image="";
       
    if(isset($_FILES['imag']))
    {
          //echo "aywaaaaaa";
     $file=$_FILES['imag']['tmp_name'];
    $image= addslashes(file_get_contents($_FILES['imag']['tmp_name']));
     $image_name=addslashes($_FILES['imag']['name']);
     $image_size= getimagesize($_FILES['imag']['tmp_name']);  //check if img or not
     if($image_size==true)
         $status=true;
    }
    
    if($em!=""&&$sname!=""&&$dph!=""&&$status==true&&$pam!=""&&$pr!=""&&$pn!=""&&$catname!="")
    {
      $catid;
      $flag=false;
      $sth=$var->conn->prepare("SELECT * FROM category");  
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      foreach($result as $Rows)
      {  
         if($catname==$Rows['name'])
         {
             $catid=$Rows['id'];
             $flag=true;  
         }
      }              
      if(!$flag)   //create new category
      {
        $q1="INSERT INTO category (`name`) VALUES ('$catname')";
        $var->conn->exec($q1);
          
      $sth=$var->conn->prepare("SELECT * FROM category"); // to get last id of added category  
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
       $Id;
       foreach($result as $Rows)
         {  
           $Id=$Rows['id'];
         }   
        $catid=$Id;  
      }
    // call onpress l button el add w a7ot feha el queries de
    $q2="INSERT INTO product (`image`, `number`,`price`,`name`,`categoryID`) VALUES ('$image', ' $pam','$pr','$pn','$catid')";
    $var->conn->exec($q2);
    
     $sth=$var->conn->prepare("SELECT * FROM product"); // to get last id of added product to be forign key for the distributer 
     $sth->execute();
     $result = $sth->fetchAll(PDO::FETCH_ASSOC);
     $ID;
    foreach($result as $Rows)
      {  
         $ID=$Rows['id'];
      }                              
    $q3="INSERT INTO distributer (`name`, `phone`, `email`,`productID`) VALUES ('$sname', '$dph', '$em','$ID')";  
    $var->conn->exec($q3);       
    
    }
    }
 ///////////////////////////////////////////////////////////////**////////////////////////////////////////////////////////////////////////////////////
?>
<!DOCTYPE html>
<html>
    <head>
    
        <title>Mega Store</title>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/animate.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Neucha" rel="stylesheet"> 
    </head>
    <style>
        
    table {
  border-collapse: separate;
  border-spacing: 50px 0px;
}

td {
  padding: 10px 0px;
} 
 

ul {

  list-style: none;

  padding: 0;

  margin: 0;

  

}

ul li {

  display: block;

  position: relative;

  float: left;

  background:none;

}

li ul { display: none; }

 

ul li a {

  display: block;

  padding: 1em;

  text-decoration: none;

  white-space: nowrap;

  color:aqua;

}

 

ul li a:hover { background:cross-fade; }

li:hover > ul {

  display: block;

  position: absolute;

}

 

li:hover li { float: none; }

 

li:hover a { background: #1bc2a2; }

 

li:hover li a:hover { background:azure; }

 

.main-navigation li ul li { border-top: 0; }

ul ul ul {

  left: 100%;

  top: 0;

}
ul:before,

ul:after {

  content: " "; /* 1 */

  display: table; /* 2 */

}

 

ul:after { clear: both; }

 #pagef
  {
      clear:both;
      margin-left: 500px;
      
  }
        #far{
            
        }
    </style>
    <body>
        
        
        <header class="header" id="HOME">
            <nav class="navbar navbar-default navbar-fixed-top nav">
              
                
                <div class="container">
                  
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#loso-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                          
                      </button>
                      <a class="navbar-brand" href="#">
                          <!-- small size logo -->
                          <img src="imges/1492733795_truck.png" width="40px;" height="40px;" class="img-responsive" alt="logo">
                        </a>
                        
                    </div>
                    
                       <li>
                          <form class="navbar-form navbar-left" method="post">
                                <div class="form-group">
                                  <input type="text" class="form-control" name="ppname" placeholder="Search" required>
                                    <select class="form-control" name="cu">
                                        <option disabled>seach for</option>
                                        <option>products</option>
                                        <option>customers</option>
                                    </select>
                                </div>
                                
                                <button type="submit" name="searchpp" class="btn btn-info"><i class="fa fa-search"></i></button>
                          </form>
                      </li>                   
                            <?php
                                  if(isset($_POST['searchpp']))
                                  {
                                      if($_POST['cu']=="customers")
                                      {
                                          $_SESSION['cust']=$_POST['ppname'];
                                          header("location:searchc.php");  
                                      }
                                      else if($_POST['cu']=="products")
                                      {
                                          $_SESSION['ppname']=$_POST['ppname'];
                                          header("location:searchp.php");  
                                      }

                                  }
                              ?>       
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="loso-navbar-collapse-1">
                
                 <ul class="main-navigation">
 <li><a href="#HOME" class="nav-item"><i class="fa fa-home"></i>HOME</a></li>
                        <li><a href="#PRODUCTS" class="nav-item"><i></i>PRODUCTS</a>
                     <ul id="far">
                            <li><a href="#PRODUCTS">Exist Products</a></li>
                            <li><a href="#finish">Finished Products</a></li>
                            </ul>
                     
                     
                     </li>
                        <li><a href="#ABOUT" class="nav-item">ABOUT</a></li>
                        <li><a href="#CUSTOMER-SELLS" class="nav-item">CUSTOMER SELLS</a></li>
                        <li><a href="#STATISTICS" class="nav-item">STATISTICS</a></li>
                        <li><a href="changePassword.php" class="nav-item">Ch-data</a></li>    
                        <li><a href="#">Categories</a>

    <ul>
      
        
        <?php
        $sthm=$var->conn->prepare("SELECT * FROM category");  
                          $sthm->execute();
                          $resultm = $sthm->fetchAll(PDO::FETCH_ASSOC);
        foreach($resultm as $Row)
        {
            $nm=$Row['name'];
            $catidq=$Row['id'];
        ?>
      <li><a href = '#'><?php echo $nm;?></a>
        <ul>
            <?php
        $cnt=0;
        $sth=$var->conn->prepare("SELECT * FROM product where categoryID='$catidq' AND Found=1");  
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
         foreach($result as $Rows)
         {
             $cnt++;
         }
        ?>
          <?php if($cnt==0) { ?>
            <li><a href="#" class='not-active' ><?php echo $cnt;?> Products</a></li>
          <?php } 
          else {
          ?>
         <li><a href = 'category_details.php?minee=<?php echo $catidq;?>'><?php echo $cnt;?> Products</a></li>
         <?php
          }
          ?>
        </ul>

      </li>
        
     <?php }?>


        </ul>
                        <script>

                            
                            
                        </script>
  
                        
                        
                        
                        <li><a href="logout.php" class="nav-item"><i class="fa fa-sign-out"></i>LOG OUT</a></li>
 

        </ul>
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
            </nav>
            <div class="over-lay">

            <div class="container header-container">
            
                <div class="row">
                    
                    <div  class="col-md-12 ">
                    
                        <div class="logo wow zoomIn">
                            <h1 class="desc " style="margin-top:25%;">
                                <i class="fa fa-cog fa-spin fa-lg fa-fw"></i>
                                Welcome to Mega Store </h1>
                            <hr style="background-color:blue; margin-left:43%;" width='24%'>
                        </div>
                    
                    </div>

                </div>
 
            </div>
   
        </div>
        </header>
        <section class="products" id="PRODUCTS"   >
            <div class="container" >
                <div class="row">
                    <div class="col-md-10">
                        <h2 class="wow fadeInDownBig fa-fa-info plus h" style="color : black; ">Exist_Products</h2>
                        <br><br>
                    </div>
                    
                    <div class="col-md-2">
                        <div>
                            <?php 
                             $margin_array=array(
                                        "top"=>0,
                                        "bottom"=>0,
                                        "left"=>0,
                                        "right"=>0,
                                    );
                                    $padding_array=array(
                                        "top"=>10,
                                        "bottom"=>10,
                                        "left"=>10,
                                        "right"=>10,
                                    );
                            $add=new add_product_button("#fff",$margin_array,$padding_array);
                            
                            
                            
                            ?></div>
                    </div>
                </div>
                <div class="row">
                      <?php
                     $sth =$var->conn->prepare("SELECT * FROM product where Found='1'");
                     $sth->execute();
                     $result = $sth->fetchAll(PDO::FETCH_ASSOC);
                     $totalRows=0;
                      foreach($result as $Rows)
                          {
                            $totalRows++;
                          }

                     if(isset($_GET['page']))
                     {
                         $currentpage=$_GET['page'];

                     }
                      else
                      {
                          $currentpage=1;
                      }

                      $prevpage=$currentpage-1;
                      $nextpage=$currentpage+1;

                      $perpage=4;
                      $start=($currentpage-1)*$perpage;
                      $lastpage=ceil($totalRows/$perpage);


                     $sth =$var->conn->prepare("SELECT * FROM product where Found='1' limit ".$start.",".$perpage );
                     $sth->execute();
                     $result = $sth->fetchAll(PDO::FETCH_ASSOC);
                     foreach($result as $Rows)
                     {
                         $ID=$Rows['id'];
                    ?>
            <div class="col-md-3">
                                
                               <?php 
                               
                                    if($Rows['Found']==1)
                                    {     
                                    echo '<div id="f1_container">';
                                    echo '<div id="f1_card" class="shadow">';
                                    
                                    
                            echo '                                       
                              <div class="front face">';
                            echo '<div class="thumbnail wow fadeInLeftBig hover-cont">';
                              echo"<h3 class='text-center'>".$Rows['name']."</h3><hr>";
                                
                              echo '   <img width="60%;" height="30%;" class="w3-hover-grayscale www text-center" src="data:image/jpeg;base64,'.base64_encode( $Rows['image'] ).' "/>';

                            echo '</br>';
                            echo '</br>';
                            echo '</br>';
                            echo '</br>';
                                  echo '</div>
                              </div>
                              <div class="back face center">';
                               echo"<h3>"."amount in store: ".$Rows['number']."</h3>";
                               echo"<h3>"."price:  ".$Rows['price']."</h3>";

                                 $sthm=$var->conn->prepare("SELECT * FROM category");  
                                 $sthm->execute();
                                 $results = $sthm->fetchAll(PDO::FETCH_ASSOC);
                                 $cat;
                                 $count=0;
                                foreach($results as $Row)
                                  {  
                                     if($Row['id']==$Rows['categoryID'])
                                         {
                                             $cat=$Row['name'];
                                         }
                                  }
                               echo"<h3>"."category name : ".$cat."</h3>";
                            echo '
                              </div>
                            </div>

                            </div>';
                                 echo '</br>';
                            echo '</br>';

                                     ?>
                            
                            <div class="row">
                                
                                
 <!-- ------------------------------------------- update button---------------------------------->
                                <div class="col-md-4">
                                
                                    <form  method="post" action="">
                                        <?php
                                        $margin_array=array(
                                            "top"=>0,
                                            "bottom"=>0,
                                            "left"=>0,
                                            "right"=>0,
                                        );
                                        $padding_array=array(
                                            "top"=>2,
                                            "bottom"=>2,
                                            "left"=>5,
                                            "right"=>5,
                                        );
                                        $col=' #2ecc71 ';
                                        $update=new update_button($col,$margin_array,$padding_array,$ID);    ?> <span class="pad"></span>
                                    </form>                                
                                </div>
                                  <div class="col-md-4">
                                
                                    <!------------------------------ sell button----------------------------------->
                                    <form  method="post" action="">
                                    <?php
                                    $margin_array=array(
                                        "top"=>0,
                                        "bottom"=>0,
                                        "left"=>0,
                                        "right"=>0,
                                    );
                                    $padding_array=array(
                                        "top"=>2,
                                        "bottom"=>2,
                                        "left"=>5,
                                        "right"=>5,
                                    );
                                    $col='#2ecc71';
                                    $selling= new sell_button($col,$margin_array,$padding_array,$ID);    ?>
                                    <span class="pad"></span>
          
                                    </form>                                
                                </div>
                                   <div class="col-md-4">
                                
                                    <!----------------------------------delete button------------------------------>
                                    <form  method="post" action="">
                                    <?php
                                    $margin_array=array(
                                        "top"=>0,
                                        "bottom"=>0,
                                        "left"=>0,
                                        "right"=>0,
                                    );
                                    $padding_array=array(
                                        "top"=>2,
                                        "bottom"=>2,
                                        "left"=>5,
                                        "right"=>5,
                                    );
                                    $col='#2ecc71';
                                    $delete=new delete_button($col,$margin_array,$padding_array);    ?>
                                       <?php echo"<input type='hidden' name='del' value="."$ID".">";?>
                                     </form>                                            
                                    </div>
                                </div>
                                
                                
                    <?php
                                    }
                        ?>
                                     </div>               <!--div here-->

            <?php
          }
       
          echo '<div id="page">';
          if($lastpage==0)
          {
              
              echo '
               <h1> NO products</h1>';
          }
          else{
           if($currentpage==1)
           {
              echo"<ul class='pager'>
             <li><a href='?page=$prevpage' class='not-active' >previous</a></li>
             </ul> ";
           }
          else
          {
            echo"<ul class='pager'>
             <li><a href='?page=$prevpage'>previous</a></li>
             </ul> ";
          }
          
          if($currentpage==$lastpage)
           {
              echo"<ul class='pager'>
             <li><a href='?page=$nextpage' class='not-active' >next</a></li>
             </ul> ";
               
           }
          else
          {
             
               echo"<ul class='pager'>
             <li><a href='?page=$nextpage' >next</a></li>
             </ul> ";
              
              
          }
          }
          
        ?>
                     
                </div>
            
                    
                 <h2 class="wow fadeInDownBig fa-fa-info plus h" style="color : black; " id="finish">Finished_Products</h2>
                
                <div class="row" >
                      <?php
                     $sth =$var->conn->prepare("SELECT * FROM product where Found='0'");
                     $sth->execute();
                     $result = $sth->fetchAll(PDO::FETCH_ASSOC);
                     $totalRowsf=0;
                      foreach($result as $Rows)
                          {
                            $totalRowsf++;
                          }

                     if(isset($_GET['pagef']))
                     {
                         $currentpagef=$_GET['pagef'];

                     }
                      else
                      {
                          $currentpagef=1;
                      }

                      $prevpagef=$currentpagef-1;
                      $nextpagef=$currentpagef+1;

                      $perpagef=4;
                      $startf=($currentpagef-1)*$perpagef;
                      $lastpagef=ceil($totalRowsf/$perpagef);


                     $sth =$var->conn->prepare("SELECT * FROM product where Found='0' limit ".$startf.",".$perpagef );
                     $sth->execute();
                     $result = $sth->fetchAll(PDO::FETCH_ASSOC);
                     foreach($result as $Rows)
                     {
                         $ID=$Rows['id'];
                    ?>
            <div class="col-md-3">
                                
                               <?php 
                               
                                    if($Rows['Found']==0)
                                    {     
                                    echo '<div id="f1_container">';
                                    echo '<div id="f1_card" class="shadow">';
                                    
                                    
                            echo '                                       
                              <div class="front face">';
                            echo '<div class="thumbnail wow fadeInLeftBig hover-cont">';
                              echo"<h3 class='text-center'>".$Rows['name']."</h3><hr>";
                                
                              echo '   <img width="60%;" height="30%;"    class="w3-hover-grayscale www text-center" src="data:image/jpeg;base64,'.base64_encode( $Rows['image'] ).' "/>';

                            echo '</br>';
                            echo '</br>';
                            echo '</br>';
                            echo '</br>';
                                  echo '</div>
                              </div>
                              <div class="back face center">';
                               echo"<h3>"."amount in store: ".$Rows['number']."</h3>";
                               echo"<h3>"."price:  ".$Rows['price']."</h3>";

                                 $sthm=$var->conn->prepare("SELECT * FROM category");  
                                 $sthm->execute();
                                 $results = $sthm->fetchAll(PDO::FETCH_ASSOC);
                                 $cat;
                                 $count=0;
                                foreach($results as $Row)
                                  {  
                                     if($Row['id']==$Rows['categoryID'])
                                         {
                                             $cat=$Row['name'];
                                         }
                                  }
                               echo"<h3>"."category name : ".$cat."</h3>";
                            echo '
                              </div>
                            </div>

                            </div>';
                                 echo '</br>';
                            echo '</br>';

                                     ?>
                   
                    <?php
                                    }
                        ?>
                                     </div>               <!--div here-->

            <?php
          }
           
          echo '<div id="pagef">';
          if($lastpagef==0)
          {
              
              echo '
               <h1> NO products</h1>';
          }
          else
          {
           if($currentpagef==1)
           {
              echo"<ul class='pager'>
             <li><a href='?pagef=$prevpagef' class='not-active' >previous</a></li>
             </ul> ";
           }
          else
          {
            echo"<ul class='pager'>
             <li><a href='?pagef=$prevpagef'>previous</a></li>
             </ul> ";
          }
          
          if($currentpagef==$lastpagef)
           {
              echo"<ul class='pager'>
             <li><a href='?pagef=$nextpagef' class='not-active' >next</a></li>
             </ul> ";
               
           }
          else
          {
             
               echo"<ul class='pager'>
             <li><a href='?pagef=$nextpagef' >next</a></li>
             </ul> ";
              
              
          }
          }
          echo '</div>';
        ?>
                     
                </div>
            
            
    <!-----------------------------------------this model which appers when selling or adding or updating a product-------->
          
            
            
 <!---------------------------------------------------------------- Modal add a product------------------------------------- -->
            
            
                    <div id="myModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header" style="background-color: #979a9a ;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">add a product</h4>
                          </div>
                          <div class="modal-body" style="background-color: #ecf0f1 ;">
                                <form method="post" action="" enctype="multipart/form-data">
                                  <div class="form-group">
                                      <!-- distributer information-->
                                      <h3 style="border-bottom:2px solid black; width:135px;">distributer info</h3>
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                  </div>
                                    
                                    <div class="form-group">
                                    <label for="userName">UserName</label>
                                    <input type="text" class="form-control" name="userName" placeholder="Enter User Name" required>
                                  </div>

                                    
                                  <div class="form-group">
                                    <label for="phone">your dphone</label>
                                    <input type="text" pattern="[0-9]{11}" class="form-control" name="dphone" placeholder="Enter Phone" required>
                                  </div>
                                <hr>
                                    <h3 style="border-bottom:2px solid black; width:110px;">product info</h3>
                                    <br>
                                    
                                  <div class="form-group">
                                    <label for="productName">Product Name</label>
                                    <input type="text" class="form-control" name="pname" placeholder="Enter product name" required>
                                  </div>                                    
                                    
                                   <div class="form-group">
                                    <label for="categoryName">Category Name</label>
                                    <input type="text" class="form-control" name="cname" placeholder="Enter Category name" required>
                                  </div> 
                                    <div class="form-group">
                                      <label for="upload">Upload updated image:</label>
                                      <input type="file" name="imag" id="imag" >
                                     </div> 
                                    
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="text" class="form-control" name="price" placeholder="Enter price" required>
                                    </div>  
                                    <div class="form-group">
                                        <label for="pamount">product amount</label>
                                        <input type="tel" class="form-control" name="pamount" placeholder="Enter amount" required>
                                    </div>  
                                    
                                  <button type="submit" name="sub" class="btn btn-primary">Submit</button>
                                </form>  
                            </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                    </div>
 <!---------------------------------------------------------------- Modal sell & update a product------------------------------------- -->
                    <!-- Modal -->
                    <div id="myModal2" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header" style="background-color: #979a9a ;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Bill of selling</h4>
                          </div>
                          <div class="modal-body" style="background-color: #ecf0f1 ;">
                                <form method="post" action="" >
                                  <div class="form-group">
                                      <!-- distributer information-->
                                      <h3 style="border-bottom:2px solid black; width:135px;">Bill info</h3>
                                       <input type="hidden" class="form_control" name="sellID" id="sellID" /> 
                                    <label for="buyer">Buyer UserName:</label>
                                    <input type="text" class="form-control" name="buyerName" aria-describedby="emailHelp" placeholder="Enter Buyer UserName" required>
                                  </div>
                                    
                                 
                                    <!------------------- el mafrod tb2a 3la 7sb el buyer dah mawgood 2bl kda wla la2    ----------->
                                    <div class="form-group">
                                    <label for="buyer">Buyer phone:</label>
                                    <input type="text" pattern="[0-9]{11}" class="form-control" name="buyerPhone" aria-describedby="emailHelp" placeholder="Enter Buyer UserName" required>
                                  </div>

                                    <div class="form-group">
                                    <label for="buyer">Buyer E-mail:</label>
                                    <input type="text" class="form-control" name="buyerEmail" aria-describedby="emailHelp" placeholder="Enter Buyer UserName" required>
                                  </div>
   
                                  <!-------------------------------------------------------------------------------------------------->
                                    
                                      <div class="form-group">
                                    <label for="dateOfSelling">date of selling</label>
                                    <input type="date" class="form-control" name="date" placeholder="Selling Date" required>
                                  </div>
              
                                   
                                  <div class="form-group">
                                      <div style="display:inline-block;">                                                     
                                    <label for="amount">amount</label>
                                    <input type="number" min="1" class="form-control" name="amount_sold" style="width:500px;" placeholder="Enter amount" required>
                                      
                                    </div>
                                  </div>
                                  <button type="submit" class="btn btn-primary">Submit</button>
                                </form>  
                            </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    
                    
                       <div id="myModal3" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header" style="background-color: #979a9a ;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">update product info</h4>
                          </div>
                          <div class="modal-body" style="background-color: #ecf0f1 ;">
                                <form method="post" action="" enctype="multipart/form-data">
                                    <h3 style="border-bottom:2px solid black; width:110px;">product info</h3>
                                    <br>
                                    
                                    <input type="hidden" class="form_control" name="updateID" id="updateID" /> 
                                  <div class="form-group">
                                     
                                    <label for="productName">Product Name</label>
                                    
                                    <input type="text" class="form-control" name="upname" placeholder="Enter new product name" optional>
                                  </div>                                   
                                    
                                   <div class="form-group">
                                    <label for="categoryName">Category Name</label>
                                    <input type="text" class="form-control" name="ucname" placeholder="Enter new Category name" optional>
                                  </div> 
                                   
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="text" class="form-control" name="uprice" placeholder="Enter new price" optional>
                                    </div>  
                                    <div class="form-group">
                                        <label for="pamount">product amount</label>
                                        <input type="tel" class="form-control" name="upamount" placeholder="Enter new amount" optional>
                                    </div>  
                                    
                                    <div class="form-group">
                <label for="upload">Upload updated image:</label>
                <input type="file" name="image" id="image" >
             </div>
                                    
                                  <button type="submit"  name="subm" class="btn btn-primary">Submit</button>
                                </form>  
                            </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                    </div>
                    
                      
                    
        </section>
        <section class="about" id="ABOUT">
                <div class="container">

                    <div class="row">

                        <div class="col-md-12">
                        <h2 class="wow bounceInRight fa-fa-info plus h">About</h2>
                        <br><br>
                        </div>

                    </div>
                    <div class="row">

                    <p class=" wow bounceInRight">Mega Store is A store serving people to store thier goods in a safe place. It costs low price to do so.
                    It has lot's of advantages represents in a lot of .............
                        </p>


                    </div>

                </div>
        
        
        </section>
        <section class="customer" id="CUSTOMER-SELLS">
                <div class="container" style="font-size:20px;">

                    <div class="row">

                        <div class="col-md-6">
                        <h2 class="wow bounceInRight fa-fa-info plus" style="color:black; h"> Sells</h2>
                        </div>
                        

                    </div>
                    <div class="row" style="padding-top:30px;">

                    <table class="table wow zoomIn" style="height:400px; overflow-y:scroll; display: inline-block;
 ">
                      <thead class="thead-inverse">
                        <tr>
                          <th>#</th>
                          <th>Customer Name</th>
                          <th>Date of selling</th>
                          <th>products (amount)</th>
                          <th>total price</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                       <?php   
                       
                      $tempp=0; 
                      $temp=array(); 
                      $count=1; 
                      $sth1=$var->conn->prepare("SELECT * FROM buyer ");  
                      $sth1->execute();
                      $result1 = $sth1->fetchAll(PDO::FETCH_ASSOC);
                      foreach($result1 as $Rows)
                        {  
                          $buyerid=$Rows['id'];
                          $name=$Rows['name'];
                          $sthm=$var->conn->prepare("SELECT * FROM bill where DateOfSelling >= now()-interval 3 month");  
                          $sthm->execute();
                          $resultm = $sthm->fetchAll(PDO::FETCH_ASSOC);
                          foreach($resultm as $Row)
                          {
                           if($Rows['id']==$Row['Bid']) 
                           {
                               $flag=true;
                               $var1=$name.$Row['DateOfSelling'];
                               for($y=0;$y<$tempp;$y++)
                               {
                                   if($var1==$temp[$y])
                                       $flag=false;
                               }
                              
                             $totPrice=0;  
                             if( $flag==true)
                             {
                                 $temp[$tempp]=$name.$Row['DateOfSelling'];
                               $tempp++;
                      
                               echo"<tr>
                          <th scope='row'>$count</th>";
                          
                               $productID=$Row['Pid'];
                               $date=$Row['DateOfSelling'];
                               echo"<td>$name</td>";
                               echo"<td>$date</td>";
                               $temp[$tempp]=$name.$Row['DateOfSelling'];
                           $arr=array(); 
                           $am=array();
                           $countt=0;
                           $sthd=$var->conn->prepare("SELECT `Pid`,`amount` FROM bill where Bid='$buyerid' AND DateOfSelling='$date'");  
                           $sthd->execute();
                           $resultd = $sthd->fetchAll(PDO::FETCH_ASSOC);
                            foreach( $resultd as $Rowd)
                            {
                               $am[$countt]=$Rowd['amount'];
                                $arr[$countt]=$Rowd['Pid'];
                                $countt++;
                            }
                             
                             echo'<td style="max-width:150px; white-space: nowrap; overflow-x:auto" >';
                             for($i=0;$i<$countt;$i++)
                             {
                               $productID=$arr[$i];
                               
                            $sthn=$var->conn->prepare("SELECT `name`,`price` FROM product where id='$productID' ");   
                            $sthn->execute();
                            $resultn = $sthn->fetchAll(PDO::FETCH_ASSOC);
                           
                            foreach($resultn as $Rown)
                             {  
                                echo $Rown['name']." ( ".$am[$i]." ) ";
                               $totPrice+=$Rown['price']*$am[$i];
                             }
                             
                             }
                             echo'</td>';   
                            $sth2=$var->conn->prepare("SELECT `name`,`price` FROM product where id='$productID' ");   
                            $sth2->execute();
                            $result2 = $sth2->fetchAll(PDO::FETCH_ASSOC);
                           
                            
                            $count++;
                               echo"<td>$totPrice</td>";
                             }
                            }
                           
                          }
                        
                        }
                                ?>
                      </tbody>
                    </table>
                    </div>
                     <div class="row">
                 
                    
                   
                </div>
                </div>
        
        
        </section>
        <!-- Counters -->
        <section class="counter" id="STATISTICS">
        
            <div class="counter-overlay">
            
                <div class="container wow bounceInLeft" data-wow-duration="1s">
                    
                    <div class="row text-center">
                    
                        <div class="col-md-3">
                        
                            <div class="counter-item">
                            
                                <div><i><img src="imges/category(1).png"></i></div>
                                <h3 ><span class="counter-num"> <?php
                                    $sth=$var->conn->prepare("SELECT * FROM category");  
                                    $sth->execute();                                    
                                    echo $sth->rowCount();
                                    
                                    
                                    ?> </span><span style="color:#fff;">+</span></h3>
                                <p>Categouries</p>
                            </div>
                        
                        </div>
                        
                        
                        <div class="col-md-3">
                        
                            <div class="counter-item">
                            
                                <div><i><img src="imges/buyer.png"></i></div>
                                <h3><span class="counter-num"> <?php
                                    $sth=$var->conn->prepare("SELECT * FROM buyer");  
                                    $sth->execute();                                    
                                    echo $sth->rowCount();
                                    
                                    
                                    ?> </span><span style="color:#fff;">+</span></h3>
                                <p >Customers</p>
                            </div>
                        
                        </div>
                        
                        <div class="col-md-3">
                        
                            <div class="counter-item">
                            
                                <div><i><img src="imges/products.png"></i></div>
                                <h3><span class="counter-num"> <?php
                                    $sth=$var->conn->prepare("SELECT * FROM product where found='1'");  
                                    $sth->execute();                                    
                                    echo $sth->rowCount();
                                    
                                    
                                    ?></span><span style="color:#fff;">+</span></h3>
                                <p style="">products</p>
                            </div>
                        
                        </div>
                        
                        
                        <div class="col-md-3">
                        
                            <div class="counter-item">
                            
                                <div><i><img src="imges/distributer.png"></i></div>
                                <h3 ><span class="counter-num"> <?php
                                    $sth=$var->conn->prepare("SELECT * FROM distributer");  
                                    $sth->execute();
                                    echo $sth->rowCount();
                                    
                                    ?> </span><span style="color:#fff;">+</span></h3>
                                <p>distributers</p>
                            </div>
                        
                        </div>
                    
                        
                    
                    </div>
                  
                
                
                </div>
            
            </div>
            </section>
        
        </section>
        <script src="js/jquiry.js"></script>
        
        <script src="js/bootstrap.min.js"></script>
        
        <!-- Add JS counter lib -->
        <script src="js/jquery.waypoints.min.js"></script>
        <script src="js/jquery.counterup.min.js"></script>
        
        <script src="js/wow.min.js"></script>

        <script src="js/custom.js"></script>

        <script src="js/myfile.js"></script>
         
    </body>

</html>