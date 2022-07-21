<?php

class ControllerRegistros{

    
    public function validaciones(){
        include_once('./Model/validaciones.php');
        $val = new validaciones();

        include_once './Vistas/registro.php';
    }

    
    public function registro(){
        include_once('./Model/registro.php');
        $reg = new Registro();
        $reg->registro();

        #include_once './registro.php';
    }

    public function tipoUsuario(){
        include_once('./Model/registro.php');
        $reg = new Registro();
        
        foreach ($reg->tipo_usuario() as $key => $value) {
            #echo $value;
            echo '<option value="'. $value->id .'">'.$value->tipo .'</option>';
        }

        #include_once './registro.php';
    }

    public function dependecia(){
        include_once('./Model/registro.php');
        $reg = new Registro();
        
        foreach ($reg->dependencia() as $key => $value) {
            #echo $value;
            echo '<option value="'. $value->id .'">'.$value->nombre .'</option>';
        }

        #include_once './registro.php';
    }



}