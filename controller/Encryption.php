<?php
    class Encryption {
        function sha512($string) {
            return hash('sha512', $string);
        }
        function b_crypt($string)
        { $options = [
            'cost' => 11,
           
        ];
            $salt = '$2a$07$R.gJb2U2N.FmZ4hPp1y2CN$';
            #$string=bcrypt($string, $salt);
            $string=password_hash($string, PASSWORD_BCRYPT, $options);
            //echo $string;
            return $string;
        }
    }
?>