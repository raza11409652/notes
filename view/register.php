<?php
    include_once "includes/header.php";
    include_once "includes/sessionHandler.php";
    if($loggedInFlag ==true)
    {
        die(header('Location: '.$_SERVER['PHP_SELF']));
    }
?>
    <section class="register-wrapper">
        <div class="container">
            <div class="register-form">
                <div id="alert-box"></div>
                <div class="form">
                    <div class="heading-text">Register</div>
                    <form action="#" name="register-form" id="register-form" method="post">
                        <div class="form-group">
                            <label for="name">
                            </label>
                            <input type="text" required name="name" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" required name="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" required name="password" class="form-control" placeholder="Enter Password">
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-outline-sec">Register</button>
                        </div>
                    </form>
                    <div class="form-group">
                        <a href="?view=login" class="btn btn-outline-prim btn-block">
                            <i class="fa fa-arrow-left"></i>    
                            Back To Login
                        </a>
                    </div>
                   <center> <div class="loader hide"></div> </center>
                </div>
            </div>
        </div>
    </section>
<?php
    include_once "includes/footer.php";
?>