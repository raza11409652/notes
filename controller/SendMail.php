<?php
 // You need to install the sendgrid client library so run: composer require sendgrid/sendgrid
 require_once '../vendor/autoload.php';
 // contains a variable called: $API_KEY that is the API Key.
 // You need this API_KEY created on the Sendgrid website.
 include_once('SendGridApi.php');
 
 class SendMail{
     protected $api_key;
     function __construct()
     {      
            $this->api_key="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";
     }
     function sendEmail($to , $from , $subject , $body)
     {
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom($from, "Notes by Hackdroid");
        $email->setSubject($subject);
        $email->addTo($to, "$to");
        $email->addContent("text/plain", $body);
        $email->addContent(
            "text/html",$body
        );
        $sendgrid = new \SendGrid($this->api_key);
        try {
            $response = $sendgrid->send($email);
           if($response->statusCode()==202)
            {
                return true;
            }else{
                return false;
            }
            /*print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
            */
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
             #return false;
        }
       
     }
 }
 
 /*$email = new \SendGrid\Mail\Mail(); 
$email->setFrom("raza.11409652@lpu.in", "Example User");
$email->setSubject("Sending with SendGrid is Fun");
$email->addTo("hackdroidbykhan@gmail.com", "Example User");
$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
$email->addContent(
    "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
);
$sendgrid = new \SendGrid($API_KEY);
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}

*/

?>