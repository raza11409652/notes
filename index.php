<?php
session_start();
$url="";
    function checkFileExist($url)
    {
        if(file_exists($url))
        {
            require_once $url;
        }
        else{
            require_once "view/error.php";
        }
    }
    if(isset($_REQUEST['view']))
    {
        $url="view/".$_REQUEST['view'].".php";
    }else{
        $url="view/home.php";
    }
    checkFileExist($url)
?>
    
