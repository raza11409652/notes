<?php 
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

    date_default_timezone_set("Asia/Kolkata");

   /* define('user','root');
    define('server','localhost');
    define('pass','');
    define('dbName','noteskeeper');
    */
    class CONNECTION{
        protected $servername="localhost";
        protected $username = "root";
        protected $password = "";
        protected $dbname = "notekeeper";
        private $ip;
        function __construct()
        {
            
        }
        function getConnect(){
            $conn =mysqli_connect($this->servername , $this->username ,$this->password ,$this->dbname);
            if($conn)
            {
               # echo "Connection Established";
                return $conn;
            }
            else{
                die("Connection Failed:".mysqli_error());
            }
        }
        function getIp(){
            // Get real visitor IP behind CloudFlare network
            if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            }
            $client  = @$_SERVER['HTTP_CLIENT_IP'];
            $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
            $remote  = $_SERVER['REMOTE_ADDR'];

            if(filter_var($client, FILTER_VALIDATE_IP))
            {
            $this->ip = $client;
            }
            elseif(filter_var($forward, FILTER_VALIDATE_IP))
            {
            $this->ip = $forward;
            }
            else
            {
            $this->ip = $remote;
            }

            return $this->ip;
        }
        
    }
    #$con= new CONNECTION();
    #var_dump($con->getConnect());
   #var_dump($con->getIp());

?>