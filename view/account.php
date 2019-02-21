<?php
    include_once "includes/header.php";
    include_once "includes/sessionHandler.php";
    if($loggedInFlag ==false)
    {
        die(header('Location: '.$_SERVER['PHP_SELF']));
    }
?>

<section class="entry-wrapper">
    <div class="container">

        <div id="notes-error">
            
        </div>
        <div class="row" id="note-keeper-container">
            <!--single note wrapper -->
            
        </div>
    </div>
</section>
<?php 
    include_once "includes/footer.php";
?>