<?php
 require 'connection.php';
session_start();




/*------------------------------------------------------class interface button-----------------------------------------------------------------*/
 interface button{
     
     /*-------------------------------------------properities--------------------------------------*/
     
     
     public function set_margin($top,$bottom,$right,$left);
     
     public function set_padding($top,$bottom,$right,$left);
     
     
     public function get_marign();
     public function get_padding();

        function onpress($variable,$var);
        
    }
/*------------------------------------------------------------login class----------------------------------------------------------------------*/
     class login implements button{
         
    public $color;
      public $margin = array(
        "top" => 0,
        "bottom" => 0,
        "right" => 0,
        "left" => 0,
    );
    public $padding=array(
        "top" =>0,
        "bottom" =>0,
        "right"=>0,
        "left"=>0
    );
     public function set_margin($top,$bottom,$right,$left)
     {
        $margin["top"]=$top;
        $margin["bottom"]=$bottom;
        $margin["right"]=$right;
        $margin["left"]=$left;
     }
     
     public function set_padding($top,$bottom,$right,$left){
         
        $padding["top"]=$top;
        $padding["bottom"]=$bottom;
        $padding["right"]=$right;
        $padding["left"]=$left;
     } 
     
     
     public function get_marign(){
         return $margin;
     }
     public function get_padding(){
         return $padding;
     }
    
    
     public function __construct ($col,$margin,$padding){
         $t=$margin["top"];
         $b=$margin["bottom"];
         $r=$margin["right"];
         $l=$margin["left"];
         
        $tt=$padding["top"];
         $bb=$padding["bottom"];
         $rr=$padding["right"];
         $ll=$padding["left"];
         
         $this->col=$col;
         
         echo "<button name='login' type='submit' class='form-control s' style='color=$col; margin: $t $b $r $l; padding: $tt $bb $rr $ll;'>Login</button>";
         
     }
    
    public function onpress($variable,$var)
    {
        $check_validity=true;
        $u=$variable['name'];
        $p=$variable["pass"];
        $Cquery="select username,password from owner where username='$u' AND password='$p';";
        
        
                $result=$var->conn->prepare($Cquery);
                $result->execute();
        
    if($result->rowCount() > 0 )
        { 
            $_SESSION["login_in"] = true; 
            $_SESSION["name"] = $u; 
            $_SESSION["pass"] = $p; 
            header('Location:index.php');

        }
        else
        {   
           echo '<h3>'.'user name or password incorrect'.'</h3>';
        }
}
     }
/*---------------------------------------------------------------sign Up---------------------------------------------------------------------*/
   class sign_up implements button{
    // bootstrap classes
       public $color;
    public $margin = array(
        "top" => 0,
        "bottom" => 0,
        "right" => 0,
        "left" => 0,
    );
    public $padding=array(
        "top" =>0,
        "bottom" =>0,
        "right"=>0,
        "left"=>0
    );
       
         public function set_margin($top,$bottom,$right,$left)
     {
        $margin["top"]=$top;
        $margin["bottom"]=$bottom;
        $margin["right"]=$right;
        $margin["left"]=$left;
     }
     
     public function set_padding($top,$bottom,$right,$left){
         
        $padding["top"]=$top;
        $padding["bottom"]=$bottom;
        $padding["right"]=$right;
        $padding["left"]=$left;
     }
     
     
     public function get_marign(){
         return $margin;
     }
     public function get_padding(){
         return $padding;
     }
    public function __construct(){
        
        echo '<button name="signup" class="btn btn-primary btn-lg margin-left:" style="position: relative;
                left: 40%;">Sign Up</button>';
    }
       
    public $conf;
       
    function onpress($variable ,$var){
    if(isset($variable)){
        
        
        
        
        
        if($variable['password']==$_POST['rpassword']){
             $u_u=$variable['username'];
             $u_f=$variable['first'];
             $u_l=$variable['last'];
             $u_p=$variable['password'];
             $u_e=$variable['email'];
             echo $u_q=$variable['question'];
             $u_a=$variable['answer'];
    
                $sth=$var->conn->prepare("SELECT * FROM owner"); // to get last id of added buyer  
                $sth->execute();
          $result = $sth->fetchAll(PDO::FETCH_ASSOC);
           $counter=0;
       foreach($result as $Rows)
         {  
           $counter++;
         }                   
              if($counter==0) 
{
        $qq1="insert into owner(answer,email,Fname,Lname,password,question,username) values ('$u_a','$u_e','$u_f','$u_l','$u_p','$u_q','$u_u')";
            $var->conn->exec($qq1);
            $_SESSION['username']=$u_u;
            $_SESSION['login_in']=true;
            header("location:index.php"); 
              }
           
        
}
    else
    {
        
         echo $conf='password does not match';
    }
    }

}

        }
/*-------------------------------------------------------------------change password------------------------------------------------------*/
class change_password implements button{
    // bootstrap classes
    public $color;
         public function set_margin($top,$bottom,$right,$left)
     {
        $margin["top"]=$top;
        $margin["bottom"]=$bottom;
        $margin["right"]=$right;
        $margin["left"]=$left;
     }
     
     public function set_padding($top,$bottom,$right,$left){
         
        $padding["top"]=$top;
        $padding["bottom"]=$bottom;
        $padding["right"]=$right;
        $padding["left"]=$left;
     }
     
     public function __construct() {
         
         echo'<button name="ch" class="btn btn-primary btn-lg">Change</button><br>';
         
     }
     public function get_marign(){
         return $margin;
     }
     public function get_padding(){
         return $padding;
     }
        function onpress($variable ,$var){
            
                  $o_name=$_SESSION["name"];
                if(  $variable['password']!='' )
                {
                    if($variable['password']==$variable['re'])
                    {
                    $c1="good";
                     $passw=$variable['password'];
                    $Cquery4="update owner set password='$passw' where username='$o_name';";  
                    $result=$var->conn->prepare($Cquery4);
                    $result->execute();
                    echo '<div class="text-center alert alert-success" style="width:30%; margin-left:50%;" >password successfully changed</div>'.'<a href="index.php" >Go to Home Page</a>';                        
                    }
                     else
                    {
                        $cvar='not good';
                        echo '<div width:30%; class="alert alert-danger" style="margin-left:50%; font-size:20px;">'.'password does not match'. '</div>';
                    } 
                   
                }
            
                      
            
            if($variable['username']!=''&& !isset($cvar))
            {
                // query executed
                    $c2="good";
                     $use=$variable['username'];                
                    $Cquery4="update owner set username='$use' where username='$o_name';";  
                    $result=$var->conn->prepare($Cquery4);
                    $result->execute();
                // set session to new username and set variable owner to new user name
                    $_SESSION["name"]=$use;
                
                    echo '<div class="text-center alert alert-success" style="width:30%; margin-left:50%;" >username successfully changed</div>';
            }
            if($variable['email']!=''&&!isset($cvar))
            {
                $c3="good";
                // query executed
                     $use=$variable['email'];   
                     $userr=$o_name=$_SESSION["name"];
                    $Cquery4="update owner set email='$use' where username='$userr';";  
                    $result=$var->conn->prepare($Cquery4);
                    $result->execute();

                    echo '<div class="text-center alert alert-success" style="width:30%; margin-left:50%;" >email successfully changed</div>';
                
            }
          if(isset($c1)||isset($c2)||isset($c3))
          {
              echo '<a href="index.php" >Go to Home Page</a>';
              //header("location:index.php");
          }
    }
    
}

/*------------------------------------------------------------delete button----------------------------------------------------*/
class delete_button implements button{
    
         public function set_margin($top,$bottom,$right,$left)
     {
        $margin["top"]=$top;
        $margin["bottom"]=$bottom;
        $margin["right"]=$right;
        $margin["left"]=$left;
     }
     
     public function set_padding($top,$bottom,$right,$left){
         
        $padding["top"]=$top;
        $padding["bottom"]=$bottom;
        $padding["right"]=$right;
        $padding["left"]=$left;
     }
     
     
     public function get_marign(){
         return $margin;
     }
     public function get_padding(){
         return $padding;
     }
    
    
     public function __construct ($col,$margin,$padding){
         $t=$margin["top"];
         $b=$margin["bottom"];
         $r=$margin["right"];
         $l=$margin["left"];
         
        $tt=$padding["top"];
         $bb=$padding["bottom"];
         $rr=$padding["right"];
         $ll=$padding["left"];
         
         $this->col=$col;
         
         echo "<button style='color:$col; margin: $t $b $r $l; padding: $tt $bb $rr $ll ;  background-color: #154360   ;
         font-size: 20px;font-weight: 800;border-radius: 10px; '><i class='text-center fa fa-trash fa-2x'></i></button>";
         
     }
       function onpress($variable,$var){
        
    }
    
    
    
    
}
/*-----------------------------------------------------------------sell button-------------------------------------------------------------*/
class sell_button implements button{
    public function set_margin($top,$bottom,$right,$left)
     {
        $margin["top"]=$top;
        $margin["bottom"]=$bottom;
        $margin["right"]=$right;
        $margin["left"]=$left;
     }
     
     public function set_padding($top,$bottom,$right,$left){
         
        $padding["top"]=$top;
        $padding["bottom"]=$bottom;
        $padding["right"]=$right;
        $padding["left"]=$left;
     }
     
     
     public function get_marign(){
         return $margin;
     }
     public function get_padding(){
         return $padding;
     }
    
    
     public function __construct ($col,$margin,$padding,$ID){
         $t=$margin["top"];
         $b=$margin["bottom"];
         $r=$margin["right"];
         $l=$margin["left"];
         
         $tt=$padding["top"];
         $bb=$padding["bottom"];
         $rr=$padding["right"];
         $ll=$padding["left"];
         
         $this->col=$col;
         
         echo "<button style='color:$col; margin: $t $b $r $l; padding: $tt $bb $rr $ll ; background-color: #154360   ;
         font-size: 20px;font-weight: 800;border-radius: 10px; ' data-toggle='modal' onclick='return false' data-id='$ID'
         data-target='#myModal2'><i class='text-center fa fa-shopping-cart fa-2x'></i></button>";
         
     }
        function onpress($variable,$var){
        
        
        
        
    }
    
}

/*--------------------------------------------------------------------add product-----------------------------------------------------------*/

class add_product_button implements button{
     public function set_margin($top,$bottom,$right,$left)
     {
        $margin["top"]=$top;
        $margin["bottom"]=$bottom;
        $margin["right"]=$right;
        $margin["left"]=$left;
     }
     
     public function set_padding($top,$bottom,$right,$left){
         
        $padding["top"]=$top;
        $padding["bottom"]=$bottom;
        $padding["right"]=$right;
        $padding["left"]=$left;
     }
     
     
     public function get_marign(){
         return $margin;
     }
     public function get_padding(){
         return $padding;
     }
    
    
     public function __construct ($col,$margin,$padding){
         $t=$margin["top"];
         $b=$margin["bottom"];
         $r=$margin["right"];
         $l=$margin["left"];
         
        $tt=$padding["top"];
         $bb=$padding["bottom"];
         $rr=$padding["right"];
         $ll=$padding["left"];
         
         $this->col=$col;
                      
             
         echo "<i class='fa fa-plus hover-cont' style='color=$col; margin: $t $b $r $l; padding: $tt $bb $rr $ll ; background-color: #37a33f; 
         font-size: 30px;font-weight: 20;border-radius: 10px; ' data-toggle='modal' data-target='#myModal'></i>";
         
     }
        function onpress($variable,$var){
        
        
        
        
        }
    
    
    
}
/*--------------------------------------------------------------update button----------------------------------------------------------------*/
class update_button implements button{
    
    public $id;
    public function set_margin($top,$bottom,$right,$left)
     {
        $margin["top"]=$top;
        $margin["bottom"]=$bottom;
        $margin["right"]=$right;
        $margin["left"]=$left;
     }
     
     public function set_padding($top,$bottom,$right,$left){
         
        $padding["top"]=$top;
        $padding["bottom"]=$bottom;
        $padding["right"]=$right;
        $padding["left"]=$left;
     }
     
     
     public function get_marign(){
         return $margin;
     }
     public function get_padding(){
         return $padding;
     }
    
    
     public function __construct ($col,$margin,$padding,$ID){
         $t=$margin["top"];
         $b=$margin["bottom"];
         $r=$margin["right"];
         $l=$margin["left"];
         
        $tt=$padding["top"];
         $bb=$padding["bottom"];
         $rr=$padding["right"];
         $ll=$padding["left"];
         
         $this->col=$col;
         $this->id=$ID;
         
        echo "<button style='color:$col; margin: $t $b $r $l; padding: $tt $bb $rr $ll ; background-color: #154360   ;  
         font-size: 20px;font-weight: 800;border-radius: 10px; ' data-toggle='modal' onclick='return false' data-id='$ID'
         data-target='#myModal3'><i class='text-center fa fa-pencil-square fa-2x'></i></button>"; 
         
     }
        function onpress($variable,$var){
        

    }
    
}

/*-------------------------------------------------------forget password --------------------------------------------------------------*/
class forget_password implements button{
    // bootstrap classes
         public function set_margin($top,$bottom,$right,$left)
     {
        $margin["top"]=$top;
        $margin["bottom"]=$bottom;
        $margin["right"]=$right;
        $margin["left"]=$left;
     }
     
     public function set_padding($top,$bottom,$right,$left){
         
        $padding["top"]=$top;
        $padding["bottom"]=$bottom;
        $padding["right"]=$right;
        $padding["left"]=$left;
     }
     
     
     public function get_marign(){
         return $margin;
     }
    
     public function get_padding(){
         return $padding;
     }
         public function __construct (){
         
         echo "<button name='forget' class='btn btn-primary'>Get Password</button>";
     }

        function onpress($variable,$var){
            
             $email=$variable['email'];
             $question = $variable['question'];
             $answer=$variable['answer'];
            
            $queryy="select email,question,answer from owner where email='$email' and question='$question' and answer='$answer'";
            
                $result=$var->conn->prepare($queryy);
                $result->execute();
                if($result->rowCount() > 0 )
                {
                    $queryy2="select password from owner where email='$email' and question='$question' and answer='$answer'";
                    $sth=$var->conn->prepare($queryy2);
                    $sth->execute();
                    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
                                        
                                      foreach($result as $Rows)
                                        {  
                                            $password=$Rows['password'];
                                        }
                    echo '<a href="login.php" style="margin-left:50%;font-size:20px;">Return</a>';
                    
                    echo '<br>'."<div style='width:20%; margin-left:50%;' class='alert alert-success text-center'>".$Rows['password']."</div>";
                }
            else
                echo 'wrong info';

            
        
        
        
    }
}
    /*----------------------------------------------------------------- owner ---------------------------------------------------------------*/
    
    class owner{

    private $username;
    private $Fname;
    private $Lname;
    private $password;
    private $email;
    private $pref_ques;
    private $ans;    
    public static $instance;
    private function __construct($username,$Fname,$Lname,$password,$email, $pref_ques,$ans)
    {
       $this->username=$username;
       $this->Fname=$Fname;
       $this->Lname=$Lname;
       $this->password=$password;
       $this->email=$email;
       $this->pref_ques=$pref_ques;
       $this->ans=$ans;
    }
    
    public static function getinstance($uname,$Fn,$Ln,$Ps,$em,$ques,$answer)
      {

         if(!isset(owner::$instance))
         {
           owner::$instance=new owner($uname,$Fn,$Ln,$Ps,$em,$ques,$answer);
         }   
        return owner::$instance;
      }    
    }    


/*-----------------------------------------------------------class button factory--------------------------------------------------------*/

class buttonFactory {
    
    const LOGIN_BUTTON=1;
    const FORGET_PASS=2;
    const SIGN_UP=3;
    const CH=4;
    
    public $col;
    public $margin;
    public $padding;
    
    public function __construct($coll="#fff",$margin=0,$padding=0){
        
        $this->col=$coll;
        $this->margin=$margin;   
        $this->padding=$padding;   
    } 
 
    public function creatButton($type){
        $v1=$this->col;
        $v2=$this->margin;
        $v3=$this->padding;
        switch($type)
        {
            case self::LOGIN_BUTTON:
            return new login($v1,$v2,$v3);
            
            case self::SIGN_UP:
            return new sign_up();
                
            case self::FORGET_PASS:
            return new forget_password();
                
            case self::CH:
            return new change_password();
                
        }

    }
  
    
}

?>