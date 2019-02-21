<?php
        include_once "../controller/Connection.php";
        include_once "../controller/Encryption.php";
        include_once "../controller/SendMail.php";
    class RESETPASSWORD{
        protected $connection ,$userId,$encryption ,$mail;
        function __construct()
        {
            #default constructor to call connection method and create DB connection for further uses.
             $connect = new Connection(); #creating object for Connection Class
             $this->connection =$connect->getConnect();
             #var_dump($this->connection);
             $this->encryption = new Encryption();
             $this->mail=new SendMail();
        }
        function validRequest($id,$token)
        {
            $query="select * from forget_otp where forget_otp_token='$token' && forget_otp_ref='$id'";
            $res=mysqli_query($this->connection , $query);
            $count=mysqli_num_rows($res);
            if($count==1)
            {
                return true;
            }
            return false;
        }
        function resetPassword($email , $token , $password , $confirmPassword)
        {   $this->userId=$this->getCurrentId($email);
            $password=$this->encryption->sha512($password);
            $confirmPassword=$this->encryption->sha512($confirmPassword);
            if($this->validPassword($password , $confirmPassword)==true)
            {
                if($this->validRequest($this->userId , $token)==true)
                {
                    #reset password and delete this entry
                    $query="update user set user_password='$password' where user_id='$this->userId'";
                    $res=mysqli_query($this->connection , $query);
                    if($res)
                    {
                        $delete="delete from forget_otp where forget_otp_ref='$this->userId'";
                        $res=mysqli_query($this->connection , $delete);
                        if($res)
                        {
                            if($this->emailSender($email)==true)
                            {
                                return true;
                            }
                        }
                    }
                }
            }
            return false;
        }
        function emailSender($email)
        {
                 $msg='<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> <style> body {Margin: 0;padding: 0; min-width: 100%;background-color: #e2e2e2;} table 
                 {border-spacing: 0;font-family: sans-serif;color: #333333;} td {padding: 0;} 
                 a{text-decoration: none !important;} img {border: 0;} .wrapper {width: 100%;table-layout: fixed;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;} .webkit {max-width: 600px;} .outer {Margin: 0 auto; width: 100%;max-width: 600px;} .inner {padding: 10px;} a { color: #ee6a56; text-decoration: underline;} .h1 {font-size: 21px;font-weight: bold; Margin-bottom: 18px;} .h2 {font-size: 18px;font-weight: bold; Margin-bottom: 12px;} .full-width-image img {width: 100%; max-width: 600px;height: auto;} /* One column layout */ .one-column .contents { text-align: left;} .one-column p { font-size: 14px;Margin-bottom: 10px;} /*Media Queries*/ @media screen and (max-width: 400px) { .two-column .column, .three-column .column { max-width: 100% !important; } .two-column img { max-width: 100% !important; } .three-column img { max-width: 50% !important; } } @media screen and (min-width: 401px) and (max-width: 620px) { .three-column .column { max-width: 33% !important; } .two-column .column { max-width: 50% !important; } } </style> <body> <center class="wrapper"> <div class="webkit"> <!--[if (gte mso 9)|(IE)]>
                  <table width="600" align="center"> <tr> <td> <![endif]--> <table class="outer" align="center"> <tr> <td class="full-width-image"> <img src="https://tutsplus.github.io/creating-a-future-proof-responsive-email-without-media-queries/images/header.jpg" width="600" alt="Gaadiexpert ogo" /> </td> </tr> 
                    <tr> <td class="one-column"> <table width="100%"> <tr> <td class="inner contents" bgcolor="ffffff"> <p class="h1">Welcome To Notes Keeper By Khalid </p>
                     <!--p>We received a request to reset your instagrams password.</p--> 
                    
                      <p>your Password has been Changed </p> <p>
                        Password changed from Ip Address'. $this->connection->getIp() .'</p> </td> </tr> </table> </td> </tr> <tr> <td class="one-column" bgcolor="#f2f2f2"> <table width="100%"> <tr> <td class="inner contents"> <p>All Rights Reserved to hackdroidbykhan</p>
                         </td> </tr> </table> </td> </tr> </table> </div> </center> </body>'; 
                    if($this->mail->sendEmail($email,"no-reply@hackdroidbykhan.com","Your Password Reset Link",$msg) ==true)
                        {
                           return true;
                        }
            return false;            
        }
        function getCurrentId($email){
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
        function validPassword($pass,$con)
        {
            if($pass == $con)
            {
                return true;
            }
            return false;
        }
        function validEmail($str)
        {
            return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
        }

    }
    if($_SERVER['REQUEST_METHOD']== 'POST')
    {
        $reset=new RESETPASSWORD();
        $password=$_POST['password'];
        $confirmPassword=$_POST['confirmPassword'];
        $email=trim($_POST['email']);
        $token=$_POST['token'];
        #echo $password .$confirmPassword;
        if(empty($password))
        {
            $error=array("Error"=>"Password is required");
            echo json_encode($error);
        }else if(empty($confirmPassword)){
            $error=array("Error"=>"Confirm password is required");
            echo json_encode($error);
        }else if(strlen($password)<6){
            $error=array("Error"=>"Password Length Must be Greater than 5 character");
                        echo json_encode($error);
        }
        else if(!empty($email) && !empty($token))
        {
            if($reset->validEmail($email)==true)
            {
                if($reset->validPassword($password , $confirmPassword)==true)
                {
                    if($reset->resetPassword($email , $token , $password , $confirmPassword))
                    {
                        $success=array("Success"=>"Your Password has been SuccessFully Changed");
                        echo json_encode($success);
                    }else{
                        $error=array("Error"=>"Some Error occured Might be URL Expired");
                        echo json_encode($error);
                    }
                }else{
                    $error=array("Error"=>"Password doesn't Match");
                    echo json_encode($error);
                }
            }else{
                $error=array("Error"=>"Their is problem with URL.. URL has been tempered..");
                echo json_encode($error);
            }
        }

    }else{
        $err=array("Error"=>"API Call Failed..");
       echo  json_encode($err);
    }
?>