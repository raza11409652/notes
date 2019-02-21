<?php
    include_once "../controller/Connection.php";
    include_once "../controller/Encryption.php";
    include_once "../controller/SendMail.php";
    class FORGET{
        protected $connection,$encryption ,$token,$currentUserId,$mail;
        function __construct()
        {
             #default constructor to call connection method and create DB connection for further uses.
             $connect = new Connection(); #creating object for Connection Class
             $this->connection =$connect->getConnect();
             #var_dump($this->connection);
             $this->encryption = new Encryption();
             $this->mail=new SendMail();
        }
        function generateOTP(){
            return mt_rand(10000,99999);
        }
        function getCurrentUserId($email){
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
        function checkValidEmail($email)
        {
            $query="select * from user where user_email='$email'";
            $res=mysqli_query($this->connection , $query);
            $count=mysqli_num_rows($res);
            if($count >0)
            {
                return true;
            }
            return false;
        }
        function storeToken($email)
        {   $query="";
             $this->token=$this->encryption->b_crypt($this->generateOTP());
             $this->currentUserId=$this->getCurrentUserId($email);
             #first check whether their is any entry with this user
             $check="select * from forget_otp where forget_otp_ref='$this->currentUserId'";
             #echo $check;
             $resC=mysqli_query($this->connection , $check);
             $count=mysqli_num_rows($resC);
             if($count==0)
             {
                $query="Insert into forget_otp (forget_otp_token,forget_otp_ref) values
                ('$this->token','$this->currentUserId')";

             }else{
                 $query="update forget_otp set forget_otp_token='$this->token' where forget_otp_ref='$this->currentUserId'";
             }
             #echo( $query);
             $res=mysqli_query($this->connection , $query);
                if($res)
                {
                    return true;
                }
                return false;
        }
        function emailSender($email)
        {
                 $msg='<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> <style> body {Margin: 0;padding: 0; min-width: 100%;background-color: #e2e2e2;} table {border-spacing: 0;font-family: sans-serif;color: #333333;} td {padding: 0;} a{text-decoration: none !important;} img {border: 0;} .wrapper {width: 100%;table-layout: fixed;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;} .webkit {max-width: 600px;} .outer {Margin: 0 auto; width: 100%;max-width: 600px;} .inner {padding: 10px;} a { color: #ee6a56; text-decoration: underline;} .h1 {font-size: 21px;font-weight: bold; Margin-bottom: 18px;} .h2 {font-size: 18px;font-weight: bold; Margin-bottom: 12px;} .full-width-image img {width: 100%; max-width: 600px;height: auto;} /* One column layout */ .one-column .contents { text-align: left;} .one-column p { font-size: 14px;Margin-bottom: 10px;} /*Media Queries*/ @media screen and (max-width: 400px) { .two-column .column, .three-column .column { max-width: 100% !important; } .two-column img { max-width: 100% !important; } .three-column img { max-width: 50% !important; } } @media screen and (min-width: 401px) and (max-width: 620px) { .three-column .column { max-width: 33% !important; } .two-column .column { max-width: 50% !important; } } </style> <body> <center class="wrapper"> <div class="webkit"> <!--[if (gte mso 9)|(IE)]> <table width="600" align="center"> <tr> <td> <![endif]--> <table class="outer" align="center"> <tr> <td class="full-width-image"> <img src="https://tutsplus.github.io/creating-a-future-proof-responsive-email-without-media-queries/images/header.jpg" width="600" alt="Gaadiexpert ogo" /> </td> </tr> <tr> <td class="one-column"> <table width="100%"> <tr> <td class="inner contents" bgcolor="ffffff"> <p class="h1">Welcome To Notes Keeper By Khalid </p> <!--p>We received a request to reset your instagrams password.</p--> <p>To Continue to your Account Please Verify your Account. The link will be active for one hour. </p> <p>If your ignore, Account will not be Active.</p> <p> <a target="_blank" href="http://localhost/practice/notes/index.php?view=passwordReset&email='.$email.'&token='.$this->token.'" class="btn btn-info">Verify Your Account</a> </p> </td> </tr> </table> </td> </tr> <tr> <td class="one-column" bgcolor="#f2f2f2"> <table width="100%"> <tr> <td class="inner contents"> <p>All Rights Reserved to hackdroidbykhan</p> </td> </tr> </table> </td> </tr> </table> </div> </center> </body>'; 
                    if($this->mail->sendEmail($email,"no-reply@hackdroidbykhan.com","Your Password Reset Link",$msg) ==true)
                        {
                           return true;
                        }
            return false;            
        }
        function validateEmail($str)
        {
            return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
        }
    }
    if($_SERVER['REQUEST_METHOD']== 'POST')
    {
        $forgetObj= new FORGET();
       
        $email=trim($_POST['email']);
        if(empty($email))
        {
            $err=array("Error"=>"Email is required");
             echo json_encode($err);
        }else{
            if($forgetObj->validateEmail($email)==true){
                if($forgetObj->checkValidEmail($email) == true)
                {
                    #get store and send verification email
                   if($forgetObj->storeToken($email) ==true)
                   {
                       #send Mail 
                       if($forgetObj->emailSender($email) ==true)
                       {
                           #success Message
                           $succ=array("Success"=>"Password Reset Link has been sent.");
                           echo json_encode($succ);
                       }
                   }

                }else{
                $err=array("Error"=>"This Email is not registered with us.Or may not be activated yet.");
                echo json_encode($err);
                }
            }else{
                $err=array("Error"=>"Please Enter a valid Email. Email format is not correct.");
                echo json_encode($err);
            }
        }
    }else{
        $err=array("Error"=>"API Call Failed..");
       echo  json_encode($err);
    }
?>
