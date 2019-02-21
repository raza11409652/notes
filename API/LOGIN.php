<?php
    require_once "../controller/Connection.php";
    require_once "../controller/Encryption.php";
    session_start();
    class LOGIN{
        protected $connection , $table;  
        function __construct()
        {
            $this->table="user";
            #default constructor to call connection method and create DB connection for further uses.
            $connect = new Connection(); #creating object for Connection Class
            $this->connection =$connect->getConnect();
            #var_dump($this->connection);
        }
        function getCurrentUserId($email)
        {
            $query="select user_id from user where user_email='$email'";
            $res= mysqli_query($this->connection , $query);
            $count= mysqli_num_rows($res);
            if($count >0)
            {
                $data=mysqli_fetch_array($res);
                $id =$data['user_id'];
                return $id;
            }
            return 0;
        }
        function doLogin($email , $password)
        {
            $query="select * from user where user_email='$email' && user_password='$password'";
            $res=mysqli_query($this->connection , $query);
            $count=mysqli_num_rows($res);
            if($count>0)
            {
                $data=mysqli_fetch_array($res);
                $fecthed_email=$data['user_email'];
                $fecthed_password=$data['user_password'];

                #check for equals 
                if($fecthed_email == $email && $fecthed_password == $password)
                {
                    return true;
                }
            }
            return false;
        }
        function checkUserExistTemp($email)
        {
            $query="select * from temp_user where temp_user_email='$email'";
            $res=mysqli_query($this->connection , $query);
            $count=mysqli_num_rows($res);
            if($count==1)
            {
                return true;
            }
            return false;
        }
        function checkValidEmail($str)
        {
            return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;

        }
        function checkValidUser($email)
        {
            $query="select * from user where user_email='$email' ";
            $res=mysqli_query($this->connection , $query);
            #var_dump($res);
            $count=mysqli_num_rows($res);
            if($count ==1)
            {
                return true;
            }

            return false;
        }
    
    }


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        #object Creation goes here
        $encrypt= new Encryption(); #Encryption class object
        $login= new LOGIN(); #login class object
        #get All the Post variable
        $email=trim($_POST['email']);
        $password=$_POST['password'];
        $password = $encrypt->sha512($password);
        if($login->checkValidEmail($email)==true)
        {
           #check for temp_user
           if($login->checkUserExistTemp($email) == false)
           {
             #check for valid user
             if($login->checkValidUser($email) == true)
             {
                 #create login Session
                 if($login->doLogin($email , $password) ==true)
                 {
                     #session Hnadling Goes Here

                     $_SESSION['loggedIn']=true;
                     $_SESSION['userEmail']=$email;
                     $_SESSION['currentUserId']=$login->getCurrentUserId($email);
                     $succ=array("Success"=>"Login Success");
                     echo json_encode($succ);
                 }else{
                     $error=array("Error"=>"Login Failed Email and Password Combination is not matched" );
                     echo json_encode($error);
                 }
             }else{
                 $error=array("Error"=>"This Email is Not Registerd With Us Register Now Its Free" );
                 echo json_encode($error);
             }
           }else{
            $error=array("Error"=>"Your Account is not Active Now. Please Verify Your Email" );
            echo json_encode($error);
           }
        }
        else{
            $error=array("Error"=>"Email is not in valid Email Format" );
            echo json_encode($error); 
        }
    }else{
        $error=array("Error"=>"This is An API Call, Requirement not Full Filled" );
        echo json_encode($error);   
    }

?>