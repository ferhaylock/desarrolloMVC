<?php

class Validaciones
{
  
    function resultBlock($errors){
		if(count($errors) > 0)
		{
			echo "<div id='error' class='alert alert-danger' role='alert'>
			<a href='#' onclick=\"showHide('error');\">[X]</a>
			<ul>";
			foreach($errors as $error)
			{
				echo "<li>".$error."</li>";
			}
			echo "</ul>";
			echo "</div>";
		}
	}
    
    function isNull($nombre, $user, $pass, $pass_con, $email){
        if(strlen(trim($nombre)) < 1 || strlen(trim($user)) < 1 || strlen(trim($pass)) < 1 || strlen(trim($pass_con)) < 1 || strlen(trim($email)) < 1)
        {
        return true;
        } else {
        return false;
    }
}

function isEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    } else {
        return false;
    }
}

function validaPassword($var1, $var2)
{
    if (strcmp($var1, $var2) !== 0){
        return false;
    } else {
        return true;
    }
}

function minMax($min, $max, $valor){
    if(strlen(trim($valor)) < $min)
    {
        return true;
    }
    else if(strlen(trim($valor)) > $max)
    {
        return true;
    }
    else
    {
        return false;
    }
}


function isNullLogin($usuario, $password){
    if(strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1)
    {
        return true;
    }
    else
    {
        return false;
    }
}


}