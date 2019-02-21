<?php 
require_once "../controller/Connection.php";
session_start();
    class DELETENOTES{
        protected $currentEmail,$connection ;
        public  $currentUserId;
        function __construct()
        {
           #default constructor to call connection method and create DB connection for further uses.
            $connect = new Connection(); #creating object for Connection Class
            $this->connection =$connect->getConnect();
            #var_dump($this->connection);
        
            @ $this->currentEmail = $_SESSION['userEmail']; 
         }
        function deleteNotes($notesId , $userId){
            $query="Delete  from notes where notes_id='$notesId' && notes_posted_by='$userId'";
            #first check whether Alert Exist for this particular notes
            if($this->alertExist($notesId)==true)
            {
                if($this->deleteAlert($notesId)==true)
                {
                    $res=mysqli_query($this->connection , $query);
                }
            }else{
                $res=mysqli_query($this->connection , $query);
            }

            if($res)
            {
                return true;
            }
            return false;
        }
        function alertExist($notesId)
        {

            $query="select * from notes_alert where notes_alert_ref='$notesId'";
            $res=mysqli_query($this->connection , $query);
            $count=mysqli_num_rows($res);
            if($count>0){
                return true;
            }
            return false;
        }

        function deleteAlert($notesId)
        {
            $query="delete from notes_alert where  notes_alert_ref='$notesId'";
            $res=mysqli_query($this->connection , $query);
            if($res)
            {
                return true;
            }
            return false;
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
        function validRequest($email){
            if($email ==$this->currentEmail)
            {
                return true;
            }
            return false;
        }


    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email=$_POST['email'];
        $notesId=$_POST['notes'];
        $deleteObj= new DELETENOTES();
        if($deleteObj->validRequest($email)==true){
            $deleteObj->currentUserId=$deleteObj->getCurrentUserId($email);
            if($deleteObj->deleteNotes($notesId , $deleteObj->currentUserId)==true)
            {
                $succ=array("Success"=>"Notes has been deleted");
                echo json_encode($succ);
            }
        }
    }
    else{
        $err=array("Error"=>"API Method Failed !!!");
        echo json_encode($err);
    }

?>