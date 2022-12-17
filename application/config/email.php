<?php
if(! defined('BASEPATH')) exit('No direct script allowed');
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "smtp.gmail.com";
        // $config['protocol'] = "ssmtp";
        // $config['smtp_host'] = "ssl://ssmtp.googlemail.com";
        $config['smtp_port'] = 587;
        $config['smtp_user'] = "smartads.darshan@gmail.com"; 
        $config['smtp_pass'] = "Drshn@1710";
        $config['smtp_crypto'] = "tls";
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html'; 
        $config['newline'] = "\r\n";
?>