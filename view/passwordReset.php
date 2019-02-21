<?php
    include_once "includes/header.php";
    @ $token=$_GET['token'];
    @ $email=$_GET['email'];
?>
    <div class="entry-wrapper">
        <div class="container">
            <div id="alert-box-reset"></div>
            <div class="card">
                <div class="card-header">
                    Reset Your Password
                </div>
                <div class="card-body">
                   <form method="POST" id="resetPasswordForm">
                    <div class="form-group">
                            <input type="password" required name="password" id="password" class="form-control" placeholder="Enter New Password">
                        </div>
                        <div class="form-group">
                            <input type="password" required name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Enter Confirm Password">
                        </div>
                        <input type="email" name="email" hidden value="<?php echo $email; ?>">
                        <input type="text" hidden  name="token" value="<?php echo $token; ?>">
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-danger">
                                reset
                            </button>
                        </div>
                        <center> <div class="loader hide"></div> </center>

                   </form>
                </div>
            </div>
        </div>
    </div>
<?php
    include_once "includes/footer.php";
?>