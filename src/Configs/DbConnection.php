<?php
    namespace App\Configs;
    
    use PDO;
    use App\Configs\Configurations;

    class DbConnection {
        //Declare global connection
       protected $servername = "";
       protected $db_name = "";
       protected $uname = "";
       protected $pword = "";
       protected $port = "";
        
       //Initialize varibles and set values
       public function __construct() {
            $env_vars = new Configurations();

            $conn_params = $env_vars-> GetDatabaseConfigs();

            $this->servername = $conn_params["db_host"];           
            $this->db_name = $conn_params["db_database"];
            $this->uname = $conn_params["db_username"];
            $this->pword = $conn_params["db_password"];
            $this->port = $conn_params["db_port"];
       }

       //handle connection
        public function Connect(){
            try {
                $conn = new PDO("mysql:host=$this->servername;port=$this->port;dbname=$this->db_name", $this->uname, $this->pword);
                
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                return $conn;

            } catch(PDOException $e) {
                //intitialize error logger
                $errLogger = new ErrorLogger();

                $errLogger->WriteError("Error: ".$e->getMessage());

                echo "Connection failed: " . $e->getMessage();
            }
        }  
    }
?>