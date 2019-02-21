<?php
    include_once "includes/header.php";
?>
    <section class="forget-wrapper">
        <div class="container">
        <div id="alert-box-forget"></div>
            <div class="forget-form">
                <div class="form">
                    <div class="heading-text">Reset Your Password</div>
                    <form action="#" method="post" id="password-reset-form">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" required name="email" class="form-control" placeholder="Email">
                        </div>
                       
                        <div class="form-group">
                            <button  type="submit" class="btn btn-block btn-outline-prim ">
                                <i class="fas fa-paper-plane"></i>    
                            Send Reset Link </button>
                        </div>
                    </form>
                    <div class="form-group">
                        <a href="?view=login" class="btn btn-block btn-outline-sec">
                            <i class="fa fa-arrow-left"></i>
                            Back To Login</a>
                    </div>
                    <center> <div class="loader hide"></div> </center>
                </div>
            </div>
        </div>
    </section>
<?php
    include_once "includes/footer.php";
?>