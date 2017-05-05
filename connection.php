 <?php
final class UserFactory
{
    
    /**
     * Call this method to get singleton
     *
     * @return UserFactory
     */ 
   
    public static $inst;
    public $conn;
    public static function Instance()
    {
        if (!isset($inst)) {
            $inst = new UserFactory();
        }
        return $inst;
    }

    /**
     * Private ctor so nobody else can instance it
     *
     */
    private function __construct()
    {
try {
        $dsn = 'mysql:host=localhost;dbname=store';
         $username = 'root';
         $password = 'asd1234';
         $this->conn=new PDO($dsn,$username,$password);
    // set the PDO error mode to exception
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
    }
}
//echo"ahh";
$var=UserFactory::Instance();

?> 