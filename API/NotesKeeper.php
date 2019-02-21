<?php
require_once "../controller/Connection.php";
require_once "../controller/Encryption.php";
session_start();
class NotesKeeper{
    protected $currentEmail,$connection ;
    public  $currentUserId;
    function __construct()
    {#default constructor to call connection method and create DB connection for further uses.
        $connect = new Connection(); #creating object for Connection Class
        $this->connection =$connect->getConnect();
        #var_dump($this->connection);
    
       @ $this->currentEmail = $_SESSION['userEmail'];
    }
    function getNotes($id){
        //$products_arr=array();
        #$products_arr["records"]=array();
        $notesArray=array();
        $notesArray["records"]=array();
        $query="select * from notes where notes_posted_by='$id'";
        $res=mysqli_query($this->connection , $query);
        $count=mysqli_num_rows($res);
        if($count >0)
        {
                while($data=mysqli_fetch_assoc($res))
                {
                    $notesItem=array(
                        "id" => $data['notes_id'],
                        "notes" => $data['notes_value'],
                        "postedOn" => $data['notes_posted_on'],
                        "alertStatus" => $data['notes_alert_status'],
                    );
                    array_push($notesArray["records"],$notesItem);
                }
                
                echo json_encode($notesArray);
        }else{
            $error=array("Error"=>"You don't have any keeper !! ");
            echo json_encode($error);
        }
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
    function checkValidRequest($email)
    {
        if($email ==$this->currentEmail)
        {
            return true;
        }
        return false;
    }

}
   if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $currentEmail=$_POST['email'];
    if(!empty($currentEmail))
    {
        $notes=new NotesKeeper();


        #check for valid request
        if($notes->checkValidRequest($currentEmail) == true)
        {
            $notes->currentUserId=$notes->getCurrentUserId($currentEmail);
            #now fetch notes
            $notes->getNotes($notes->currentUserId);
        }else{
            $error=array("Error"=>"Your Session has been expired login again ");
            echo json_encode($error);
        }
    }
    #fetch email for curret user and make request for associated notes and disply in table format
   }else{
       $error=array("Error"=>"API Method Fail");
       echo json_encode($error);
   }
?>