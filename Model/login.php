<?php
require './Model/validaciones.php';
require './Model/usuarios.php';


class Login {
    
    function session_login() {
    
        session_start();

        if(isset($_GET['cerrarsesion'])){
            session_unset();
            session_destroy();
        }

        if(isset($_SESSION["tipo_usuario"])){ 
            switch($_SESSION['tipo_usuario']){
                case 1:
                header('location: ./Vistas/admin.php');
                break;
                case 2:
                header('location: ./Vistas/profesor.php');
                break;
                default:
            }
        }else {
            $this->Validaciones();
        }
}

    public function Validaciones(){
        
        $errors= array();
    
        $vali = new Validaciones();
        $user = new Usuarios();

        if (!empty($_POST)) {

            global $mysqli;

            $usuario = $_POST['usuario'];
            $password = $_POST['password'];
    
            if ($vali->isNullLogin($usuario, $password)) {
                $errors[] = "Debe llenar todos los campos";
            }
            $errors[] = $user->login($usuario,$password);
        }
        
        
        require_once 'index.php';

    }

    public function cerrarsesion(){
        session_start();
        session_destroy();

        header('location: ./index.php');
    }



}
