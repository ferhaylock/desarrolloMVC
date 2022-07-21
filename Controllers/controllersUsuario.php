<?php



class ControllerUsuarios{


    public function activacion(){
        require_once './Model/usuarios.php';
        $user = new Usuarios();

        $user->activar();
    }

    public function recuperacion(){
        require_once './Model/usuarios.php';
        $user = new Usuarios();

        $user->recuperacion();
    }

    public function cambiarContra(){
        require_once './Model/usuarios.php';
        $user = new Usuarios();

        $user->cambiarContra();
    }

    public function modificarPass(){
        require_once './Model/usuarios.php';
        $user = new Usuarios();

        $user->modificarPass();
    }

}