<?php
    include_once "includes/header.php";

    include_once "controller/Connection.php";
    $flag=false;
    $err="";
    $succ="";
    #get Email and Token
    @ $email=$_GET['email'];
    @ $token=$_GET['token'];
    if(!empty($email) && !empty($token))
    {
        #start verification
        #create object for connection
        $connection = new CONNECTION();
        $connect= $connection->getConnect();
        #get Current User Id
        $id="select * from temp_user where temp_user_email='$email'";
        $currentId=0;
        $res=mysqli_query($connect , $id);
        $count=mysqli_num_rows($res);
        if($count>0)
        {
            $data=mysqli_fetch_array($res);
            $currentId=$data['temp_user_id'];
        }else{
            $flag=true;
             $err ="This Email is Already Active";
        }
        #echo $currentId;
        $query="select * from temp_otp where temp_otp_value='$token' && temp_otp_ref='$currentId'";
        $res=mysqli_query($connect , $query);
        $count=mysqli_num_rows($res);
        if($count ==1){
            #delete entry from temp_otp
            $del="delete from temp_otp where temp_otp_ref='$currentId'";

            if(mysqli_query($connect , $del))
            {
                #copy from one temp_user to user table
                $query="Insert into user (user_name , user_email ,user_password) select temp_user_name
                ,temp_user_email,temp_user_password from temp_user where temp_user_id='$currentId'";
                echo $query;
                if(mysqli_query($connect , $query))
                {
                    #delete from temp_user
                $del="delete from temp_user where temp_user_id='$currentId'";
                if(mysqli_query($connect , $del))
                {
                    $flag =true;
                    $succ="Your Email Has been Verified.Now Login to your Account to enjoy Note Kepper.";
                }

                }
            }
            
            
        }
    } 
    else{
    $flag=true;
    $err ="Link Is Not Valid OR Might be link has been tempered.";
    }
?>
    <div class="container">
            <div class="center-allign  verify-wrapper">
                <div class="loader <?php if($flag ==true){echo "hide";} ?>"></div>
                <p class="text-primary <?php if($flag ==true){echo "hide";} ?> "> <i class="fas fa-envelope"></i> Email is being verified</p>
                <?php
                    if($flag ==true && !empty($err))
                    {
                        echo  '<div class="alert alert-danger" role="alert">
                        <strong>
                        <i class="fas fa-exclamation-circle"></i>
                        Alert !!</strong> '.$err.'
                        
                      </div>
                      <div class="form-group">
                         <a href="./" class="btn btn-block btn-outline-prim">
                         <i class="fa fa-home"></i>
                         Home</a>
                        </div>
                       
                      ';
                    }else if($flag ==true && !empty($succ)){
                        echo  '<div class="alert alert-success" role="alert">
                        <strong>
                        <i class="fas fa-exclamation-circle"></i>
                        Alert !!</strong> '.$succ.'
                        
                      </div>
                      <div class="form-group">
                         <a href="index.php?view=login" class="btn btn-block btn-outline-sec">
                         <i class="fas fa-sign-in-alt"></i>
                         Login To Your Account</a>
                        </div>
                       
                      ';
                    }
                ?>
            </div>
    </div>
<?php
    include_once "includes/footer.php";
?>