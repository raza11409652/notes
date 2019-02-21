<?php
    include_once "includes/header.php";
    include_once "includes/sessionHandler.php";
    if($loggedInFlag ==true)
    {
        die(header('Location: '.$_SERVER['PHP_SELF']));
    }
?>
    <section class="login-wrapper">
        <div class="container">
        <div id="alert-box-login"></div>

            <div class="login-form">
                <div class="form">
                    <div class="heading-text">Login</div>
                    <form action="#" method="post" id="login-form">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" required name="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="email">Password</label>
                            <input type="password" required name="password" class="form-control" placeholder="Enter Password">
                        </div>
                        <p class="padding-default">
                        <a href="?view=forget" class="btn btn-light margin-bottom float-right">Forget Password</a> 
                        </p>
                        <div class="form-group">
                            <button  type="submit" class="btn btn-block btn-outline-prim ">Login</button>
                        </div>
                    </form>
                    <div class="form-group">
                        <a href="?view=register" class="btn btn-block btn-outline-sec">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
    include_once "includes/footer.php";
?>