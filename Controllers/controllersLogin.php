<?php

class ControllerLogins{
    

    public function Login(){

        include_once('./Model/login.php');
        $login = new Login();
        $login->session_login();
    }

    public function cerrarsesion(){
        include_once('./Model/login.php');
        $login = new Login();
        $login->cerrarsesion();
    }

}