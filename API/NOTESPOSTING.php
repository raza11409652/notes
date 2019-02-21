<?php
    require_once "../controller/Connection.php";
    require_once "../controller/Encryption.php";
    session_start();
    class NOTESPOSTING{
        protected $currentUser , $currentUserId,$connection , $currentNotes;
        function __construct()
        {
            #default constructor to call connection method and create DB connection for further uses.
            $connect = new Connection(); #creating object for Connection Class
            $this->connection =$connect->getConnect();
            #var_dump($this->connection);
            $this->currentUser=$_SESSION['userEmail'];
            $this->currentUserId=$_SESSION['currentUserId'];
            $this->currentNotes=$this->getNotesId();
        }
        function postNotes($notes ,$postedOn , $notesStat ,$date , $time ){
            $query="Insert into notes (notes_id,notes_value,notes_posted_on , notes_alert_status,notes_posted_by) values
            ('$this->currentNotes','$notes','$postedOn','$notesStat','$this->currentUserId')";
            $res=mysqli_query($this->connection , $query);
            if($res)
            {
                if($notesStat =='true')
                {
                    if($this->addAlarm($date , $time ,$this->currentNotes) ==true)
                    {
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return true;
                }
            }


            return false;
        }
        function getNotesId()
        {
            $id=0;
            $sql="select max(notes_id) as max_id from  notes ";
            $res=mysqli_query($this->connection,$sql);
            if($res)
            {
                $data=mysqli_fetch_assoc($res);
                $id = $data['max_id'];
                return $id+=1;
            }
            return 1;
        }
        function addAlarm($date ,$time , $currentNotes)
        {
            $query="Insert into notes_alert (notes_alert_date, notes_alert_time , notes_alert_ref) values
            ('$date','$time','$currentNotes')";
            $res=mysqli_query($this->connection , $query);
            if($res)
            {
                return true;
            }  
            return false;
        }
        function convertDate($date)
        {
            #convert date into 2018-12-07
            $newDate = date("Y-m-d", strtotime($date));
            return $newDate;
        }
        function formatTime($date , $time)
        {
            $newDate=$this->convertDate($date);
            $date=new DateTime($newDate.$time);
            return $date->format("Y-m-d H:i:s");
        }
        function validateDate($currentDate , $requsetDate ){
            #date can't be back from todays date
            #echo $currentDate . $requsetDate;
            if(strtotime($requsetDate) < strtotime($currentDate))
            {
                #echo strtotime($requsetDate) .strtotime($currentDate);
                #echo "requested date is small" . strtotime($requsetDate);
                return true;
            }else{
                return false;
               # echo " requested date is large";
            }
        }
        
    }


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $error="";
        $notesObj= new NOTESPOSTING();
        $posetdOn = date('Y-m-d h:i:s a', time());
        $alertDate=$_POST['date'];
        $alertStat=$_POST['alertStat'];
        $notes=trim($_POST['notes']);
        $alertTime=$_POST['time'];
        #echo $alertStat;
       if($alertStat == 'true')
       {
        #date and Time is required
        if(empty($notes))
        {
            $error=array("Error"=>"You forget to write in your keeper");
            echo json_encode($error);
        }elseif(empty($alertDate))
        {
            $error=array("Error"=>"Date is Required.");
            echo json_encode($error);
        }else if(empty($alertTime))
        {
            $error=array("Error"=>"Time is Required.");
            echo json_encode($error);
        }else{
            #format date and time for use in databse;
             $formatedDate=$notesObj->convertDate($alertDate);
            #output2018-12-24
           $formatedTime=$notesObj->formatTime($alertDate , $alertTime);

            #output 2018-12-24 08:30:00 
           if($notesObj->validateDate($posetdOn , $formatedTime) == false)
           {
            if( $notesObj->postNotes($notes , $posetdOn , $alertStat , $formatedDate ,$formatedTime) ==true)
            {
                $succ=array("Success"=>"Notes has been Saved With Scheduled Notification");
                echo json_encode($succ);
            }

           }else{
               $error = array('Error'=>'Please select Date and Time which is greater than current Date and Time.');
                echo json_encode($error);
            }
        }

       }else{
        $alertDate=null;
        $alertTime=null;
        #date and time is optional
            if(empty($notes))
            {
                $error=array("Error"=>"You forget to write in your keeper");
                echo json_encode($error);
            }else if($notesObj->postNotes($notes , $posetdOn , $alertStat , $alertDate ,$alertTime)==true)
            {
                $succ=array("Success"=>"Notes has been Saved.");
                echo json_encode($succ);
            }
        #$notesObj->postNotes($notes , $posetdOn , $alertStat);
       
       }   
    }
    else{
        $error=array("Error"=>"API CALL FIALED!....");
        echo json_encode($error);
    }
?>