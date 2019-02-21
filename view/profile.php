<?php
    include_once "includes/header.php";
    include_once "includes/sessionHandler.php";
    if($loggedInFlag ==false)
    {
        die(header('Location: '.$_SERVER['PHP_SELF']));
    }
?>

<section class="entry-wrapper">
   
</section>
<?php 
    include_once "includes/footer.php";
?>