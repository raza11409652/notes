<?php
    include_once "../controller/Connection.php";
    include_once "../controller/Encryption.php";
    include_once "../controller/SendMail.php";

class REGISTER{
    protected $connection,$token;
    function __construct()
    {
        #default constructor to call connection method and create DB connection for further uses.
        $connect = new CONNECTION(); #creating object for Connection Class
        $this->connection =$connect->getConnect();
        #var_dump($this->connection);
    }
    function checkValidEmail($str){
            return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;

    }
    function generateOtp()
    {
        return mt_rand(10000,99999);
    }
    function checkEmailExist($email){
        $query="select * from user where user_email='$email'";
        $res= mysqli_query($this->connection , $query);
        $count=mysqli_num_rows($res);
        if($count == 1)
        {
            return true; #email already Exist
        }
        return false;
    }
    function getCurrentUserId($email)
    {
        $query="select * from temp_user where temp_user_email='$email'";
        $res= mysqli_query($this->connection , $query);
        $count= mysqli_num_rows($res);
        if($count >0)
        {
            $data=mysqli_fetch_array($res);
            $id =$data['temp_user_id'];
            return $id;
        }
        return 0;
    }
    function otpInsertion($id , $token)
    {
        $query="";
        #check whether their is any entry with this ref
        #if exist than update token value
        #else insert
        $str="select * from temp_otp where temp_otp_ref='$id'";
        $res= mysqli_query($this->connection , $str);
        $count = mysqli_num_rows($res);
        if($count>0)
        {
            $query="update temp_otp set temp_otp_value='$token' where temp_otp_ref='$id'";
        }
        else{
            $query="Insert into temp_otp (temp_otp_value , temp_otp_ref) values
            ('$token','$id')";
        }
        $res=mysqli_query($this->connection , $query);
        if($res)
        {
            return true;
        }
        return false;
    }
    function registerNewUser($name , $email , $password )
    {
        $query="Insert into temp_user (temp_user_name, temp_user_email , temp_user_password) values
        ('$name','$email','$password')";
        $res=mysqli_query($this->connection , $query);
        if($res)
        {
            return true;
        }
        return false;
    }
    function checkUserExistTemp($email)
    {
       $query="select * from temp_user where temp_user_email='$email'";
       $res=mysqli_query($this->connection , $query);
       $count=mysqli_num_rows($res);
       if($count > 0)
       {
        return true;
       } 
       return false;
    }
    
}

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $name=trim($_POST['name']);
        $email=trim($_POST['email']);
        $password=$_POST['password'];

        #create object for Encryption and Register Class
        $encryption =new Encryption();
        $register = new REGISTER();
        $mail=new SendMail();
        $password=$encryption->sha512($password);
        if(empty($name))
        {
            $error=array("Error"=>"Name Is Required" );
            echo json_encode($error);
        }
        else if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            $error=array("Error"=>"Only letters and white space allowed in Name"); 
            echo json_encode($error);
        }
        else if(empty($email))
        {
            $error=array("Error"=>"Email is Required" );
            echo json_encode($error);
        }
        else if(empty($password))
        {
            $error=array("Error"=>"Password  is Required" );
            echo json_encode($error);  
        }
        else{
          
           # echo $name . $email . $password;
            #check for valid Email Format
            if($register->checkValidEmail($email)==true)
            {   
                if($register->checkEmailExist($email) == false)
                {
                    #check whether user is temporary register or nor if 
                    #register in temp dataset resend an Email for verification of Email
                    #user
                    if($register->checkUserExistTemp($email)==false)
                    {
                        #register now new User in temp data and send an email for verification

                        if($register->registerNewUser($name , $email ,$password) ==true){
                            #generate OTP
                            $token=$register->generateOtp();
                            $token= $encryption->b_crypt($token);
                            $currentUserId=$register->getCurrentUserId($email);
                            if($currentUserId !=0)
                            {
                              if($register->otpInsertion($currentUserId , $token) == true)
                              {
                                  #send Mail 
                                  $msg='<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> <style> body {Margin: 0;padding: 0; min-width: 100%;background-color: #e2e2e2;} table {border-spacing: 0;font-family: sans-serif;color: #333333;} td {padding: 0;} a{text-decoration: none !important;} img {border: 0;} .wrapper {width: 100%;table-layout: fixed;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;} .webkit {max-width: 600px;} .outer {Margin: 0 auto; width: 100%;max-width: 600px;} .inner {padding: 10px;} a { color: #ee6a56; text-decoration: underline;} .h1 {font-size: 21px;font-weight: bold; Margin-bottom: 18px;} .h2 {font-size: 18px;font-weight: bold; Margin-bottom: 12px;} .full-width-image img {width: 100%; max-width: 600px;height: auto;} /* One column layout */ .one-column .contents { text-align: left;} .one-column p { font-size: 14px;Margin-bottom: 10px;} /*Media Queries*/ @media screen and (max-width: 400px) { .two-column .column, .three-column .column { max-width: 100% !important; } .two-column img { max-width: 100% !important; } .three-column img { max-width: 50% !important; } } @media screen and (min-width: 401px) and (max-width: 620px) { .three-column .column { max-width: 33% !important; } .two-column .column { max-width: 50% !important; } } </style> <body> <center class="wrapper"> <div class="webkit"> <!--[if (gte mso 9)|(IE)]> <table width="600" align="center"> <tr> <td> <![endif]--> <table class="outer" align="center"> <tr> <td class="full-width-image"> <img src="https://tutsplus.github.io/creating-a-future-proof-responsive-email-without-media-queries/images/header.jpg" width="600" alt="Gaadiexpert ogo" /> </td> </tr> <tr> <td class="one-column"> <table width="100%"> <tr> <td class="inner contents" bgcolor="ffffff"> <p class="h1">Welcome To Notes Keeper By Khalid </p> <!--p>We received a request to reset your instagrams password.</p--> <p>To Continue to your Account Please Verify your Account. The link will be active for one hour. </p> <p>If your ignore, Account will not be Active.</p> <p> <a target="_blank" href="http://localhost/practice/notes/index.php?view=verify&email='.$email.'&token='.$token.'" class="btn btn-info">Verify Your Account</a> </p> </td> </tr> </table> </td> </tr> <tr> <td class="one-column" bgcolor="#f2f2f2"> <table width="100%"> <tr> <td class="inner contents"> <p>All Rights Reserved to hackdroidbykhan</p> </td> </tr> </table> </td> </tr> </table> </div> </center> </body>'; 
                                    if($mail->sendEmail($email,"no-reply@hackdroidbykhan.com","Your verificiation Email",$msg) ==true)
                                    {
                                        #success Message
                                        $succ=array("Success"=>"User Registration Successfull Plaese Verify Your Email. Email is sent to ".$email);
                                        echo json_encode($succ);
                                    }
                              }  
                            }
                        }else{
                           
                            $error=array("Error"=>"Error Occured Try To Register Again");
                            echo json_encode($error);
                        }

                    }else{
                        $token=$register->generateOtp();
                        $token= $encryption->b_crypt($token);
                        $currentUserId=$register->getCurrentUserId($email);
                        if($register->otpInsertion($currentUserId , $token) ==true ){
                            $msg='<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> <style> body {Margin: 0;padding: 0; min-width: 100%;background-color: #e2e2e2;} table {border-spacing: 0;font-family: sans-serif;color: #333333;} td {padding: 0;} a{text-decoration: none !important;} img {border: 0;} .wrapper {width: 100%;table-layout: fixed;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;} .webkit {max-width: 600px;} .outer {Margin: 0 auto; width: 100%;max-width: 600px;} .inner {padding: 10px;} a { color: #ee6a56; text-decoration: underline;} .h1 {font-size: 21px;font-weight: bold; Margin-bottom: 18px;} .h2 {font-size: 18px;font-weight: bold; Margin-bottom: 12px;} .full-width-image img {width: 100%; max-width: 600px;height: auto;} /* One column layout */ .one-column .contents { text-align: left;} .one-column p { font-size: 14px;Margin-bottom: 10px;} /*Media Queries*/ @media screen and (max-width: 400px) { .two-column .column, .three-column .column { max-width: 100% !important; } .two-column img { max-width: 100% !important; } .three-column img { max-width: 50% !important; } } @media screen and (min-width: 401px) and (max-width: 620px) { .three-column .column { max-width: 33% !important; } .two-column .column { max-width: 50% !important; } } </style> <body> <center class="wrapper"> <div class="webkit"> <!--[if (gte mso 9)|(IE)]> <table width="600" align="center"> <tr> <td> <![endif]--> <table class="outer" align="center"> <tr> <td class="full-width-image"> <img src="https://tutsplus.github.io/creating-a-future-proof-responsive-email-without-media-queries/images/header.jpg" width="600" alt="Gaadiexpert ogo" /> </td> </tr> <tr> <td class="one-column"> <table width="100%"> <tr> <td class="inner contents" bgcolor="ffffff"> <p class="h1">Welcome To Notes Keeper By Khalid </p> <!--p>We received a request to reset your instagrams password.</p--> <p>To Continue to your Account Please Verify your Account. The link will be active for one hour. </p> <p>If your ignore, Account will not be Active.</p> <p> <a target="_blank" href="http://localhost/practice/notes/index.php?view=verify&email='.$email.'&token='.$token.'" class="btn btn-info">Verify Your Account</a> </p> </td> </tr> </table> </td> </tr> <tr> <td class="one-column" bgcolor="#f2f2f2"> <table width="100%"> <tr> <td class="inner contents"> <p>All Rights Reserved to hackdroidbykhan</p> </td> </tr> </table> </td> </tr> </table> </div> </center> </body>';
                            if($mail->sendEmail($email,"no-reply@hackdroidbykhan.com","Your verificiation Email",$msg))
                            {
                                $error=array("Error"=>"Email Verification for This Email Is Pending. Please verify to login Or Register With new Email");
                                echo json_encode($error);
                            }else{
                                $error=array("Error"=>"Error in sending Email contact to admin");
                                echo json_encode($error); 
                            }
                        }      
                    }
                    
                }else{
                    $error=array("Error"=>"Email Already In Use");
                    echo json_encode($error); 
                }

            }else{
                $error=array("Error"=>"Email Format is not Valid Please Check Email");
                echo json_encode($error);
            }

        }
    }else{
        $error=array("Error"=>"This is An API Call, Requirement not Full Filled" );
        echo json_encode($error);   
    }
?>