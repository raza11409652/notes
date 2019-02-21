<?php
    include_once "includes/header.php";
   
?>
    <section class="entry-wrapper">
        
        <div class="container <?php if($loggedInFlag!=true){echo "hide";} ?>">
            <form action="#" method="post" id="notes-form">
            <div class="form-group paper">
                <textarea name="notes" placeholder="Start Writing Your Notes .." id="notes" cols="30" rows="8" ></textarea>
                <div class="accordion" id="accordionExample">
                    <div class="card">
                            <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="fas fa-bell"></i>    
                                    Schedule Notification 
                                </button>
                            </h5>
                            </div>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                    <span class="switch-title">Notification</span>
                                        <div class="switch-field">
                                            <input type="radio" id="switch_left" name="alertStat" value="true" />
                                            <label for="switch_left">Yes</label>
                                            <input type="radio" id="switch_right" name="alertStat" value="false" checked />
                                            <label for="switch_right">No</label>
                                        </div>
                                    <div class="row margin-top">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                        <p>
                                                        <i class="fas fa-calendar"></i> Select Date
                                                        </p>
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control datepicker" name="date" placeholder="Date" aria-label="Date" aria-describedby="calender-addon" id='datePicker'>
                                                            <div class="input-group-append date" >
                                                                <span class="input-group-text" id="calender-addon"> <i class="fas fa-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <p> <i class="fas fa-clock"></i> Select Time</p>
                                                    <div class="input-group mb-3">
                                                            <input type="text" class="form-control timepicker" placeholder="Time" name="time" id='timePicker'>
                                                            <div class="input-group-append date" >
                                                                <span class="input-group-text" id="calender-addon"> <i class="fas fa-clock"></i></span>
                                                            </div>
                                                     </div>
                                                </div>
                                            </div>
                                        </div>     
                                    </div>
                            </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-outline-sec">
                   <i class="fas fa-save"></i> Keep
                </button>
            </div>
            </form>
        </div>
        <div class="container <?php if($loggedInFlag ==true){echo "hide";} ?>">
            <div class="jumbotron">
                <h1 class="display-4">Hello, world!</h1>
                <p class="lead">This is a simple Notes Keeper. You can keep your notes and enable notification to get notified at particular time</p>
                <hr class="my-4">
                <p class="text-dark">Your Will get Notified via  Email OR  Sms On Your Mobile. Start Using Service Via Registering With US it's Free Or Login Into Your Account </p>
                <a class="btn btn-outline-info btn-lg" href="?view=register" role="button">Register</a>
            </div>
        </div>
    </section>

    <?php
    //echo $_SESSION['loggedIn'].$_SESSION['userEmail'].$_SESSION['currentUserId'];
    //session_destroy(); 
    ?>
<?php
    include_once  "includes/footer.php";
?>