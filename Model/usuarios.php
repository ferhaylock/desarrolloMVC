<?php

require_once './conexiondb/database.php';
require_once './Model/mail.php';
require_once './Model/validaciones.php';

class Usuarios extends DATABASE{

	

    function usuarioExiste($usuario)
	{

		$stmt = $this->getConnection()->prepare("SELECT id FROM usuarios WHERE usuario = ? LIMIT 1");
		$stmt->execute([$usuario]);
		$num = $stmt->fetch(PDO::FETCH_NUM);

		if ($num > 0){
			return true;
			} else {
			return false;
		}
	}

	function registraUsuario($usuario, $nombre, $Apel, $email, $pass_hash, $ide, $activo, $prog, $tipo_usuario, $token){

		$stmt = $this->getConnection()->prepare("INSERT INTO usuarios (usuario, nombre, apellido, correo, password, identificacion, activacion, programa_dependencia, id_tipo, token) VALUES(?,?,?,?,?,?,?,?,?,?)");

		$query = $stmt->execute([$usuario, $nombre, $Apel, $email, $pass_hash, $ide, $activo, $prog, $tipo_usuario, $token]);
	
		if ($query){

			return $this->getConnection()->lastInsertId();
			} else {
			return 0;
		}
	}

	function activarUsuario($id)
	{
		$stmt = $this->getConnection()->prepare("UPDATE usuarios SET activacion=1 WHERE id = ?");
		$result = $stmt->execute([$id]);
		return $result;
	}

	function validaIdToken($token){
		

		$stmt = $this->getConnection()->prepare("SELECT activacion,id FROM usuarios WHERE token = ? LIMIT 1");
		$stmt->execute([$token]);
		$rows = $stmt->fetch(PDO::FETCH_NUM);

		if($rows > 0) {
		
			if($rows[0] == 1){
				$msg = "La cuenta ya se activo anteriormente.";
				} else {
				if($this->activarUsuario($rows[1])){
					$msg = 'Cuenta activada.';
					} else {
					$msg = 'Error al Activar Cuenta';
				}
			}
			} else {
			$msg = 'No existe el registro para activar.';
		}
		return $msg;
	}

	public function activar(){
		if (isset($_GET['val']))
		{
		  $token = $_GET['val'];
		  
		  $mensaje = $this->validaIdToken($token);
		  echo $mensaje;
		}
	}
	
	
	function login($usuario, $password)
	{
		

		$stmt = $this->getConnection()->prepare("SELECT id, id_tipo, password FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
        $stmt->execute([$usuario, $usuario]);

        $rows = $stmt->fetch(PDO::FETCH_NUM);
		

		if($rows > 0) {

			if($this->isActivo($usuario)){

                $id = $rows[0];
                $id_tipo = $rows[1];
                $passwd = $rows[2];
				
				$validaPassw = password_verify($password, $passwd);

				if($validaPassw){

					$this->lastSession($id);
					$_SESSION['id_usuario'] = $id;
					$_SESSION['tipo_usuario'] = $id_tipo;
					switch($_SESSION['tipo_usuario']){
						case 1:
						header('location: ./Vistas/admin.php');
						break;
						case 2:
						header('location: ./Vistas/profesor.php');
						break;
						default:
						}
					} else {

					$errors = "La contrase&ntilde;a es incorrecta";
				}
				} else {
				$errors = 'El usuario no esta activo';
			}
			} else {
			$errors = "El nombre de usuario o correo electr&oacute;nico no existe";
		}
		return $errors;
	}

	
	function lastSession($id)
	{

		$stmt = $this->getConnection()->prepare("UPDATE usuarios SET last_session=NOW(), token_password='', password_request=1 WHERE id = ?");
		$stmt->execute([$id]);
	}

	function isActivo($usuario)
	{

		$stmt =$this->getConnection()->prepare("SELECT activacion FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        
        $a = $stmt->fetch(PDO::FETCH_OBJ);
        print_r($a);

		if ($a->activacion == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	
	function generaTokenPass($user_id)
	{

		$token = $this->generateToken();

		$stmt = $this->getConnection()->prepare("UPDATE usuarios SET token_password=?, password_request=1 WHERE id = ?");
		$stmt->execute([$token, $user_id]);
	
		return $token;
	}

	function getValorid($valor)
	{

		$stmt = $this->getConnection()->prepare("SELECT id FROM usuarios WHERE correo = ? ");
		$stmt->execute([$valor]);
		$num = $stmt->fetch(PDO::FETCH_NUM);

		if ($num > 0)
		{
			return $num[0];
		}
		else
		{
			return null;
		}
	}

	function getValornombre($valor)
	{

		$stmt = $this->getConnection()->prepare("SELECT nombre FROM usuarios WHERE correo = ? LIMIT 1");
		$stmt->execute([$valor]);
		$num = $stmt->fetch(PDO::FETCH_NUM);

		if ($num > 0)
		{
			return $num[0];
		}
		else
		{
			return null;
		}
	}

	function getPasswordRequest($id)
	{

		$stmt = $this->getConnection()->prepare("SELECT password_request FROM usuarios WHERE id = ?");
		$stmt->execute([$id]);
		$num = $stmt->fetch(PDO::FETCH_NUM);

		if ($num[0] == 1)
		{
			return true;
		}
		else
		{
			return null;
		}
	}

	function verificaTokenPass($user_id, $token){

		$stmt = $this->getConnection()->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token_password = ? AND password_request = 1 LIMIT 1");
		$stmt->execute([$user_id, $token]);
		$num = $stmt->fetch(PDO::FETCH_NUM);

		if ($num > 0)
		{
		
			if($num[0] == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function cambiaPassword($password, $user_id, $token){

		$stmt = $this->getConnection()->prepare("UPDATE usuarios SET password = ?, token_password='', password_request=0 WHERE id = ? AND token_password = ?");

		if($stmt->execute([$password, $user_id, $token])){
			return true;
			} else {
			return false;
		}
	}

    
	function emailExiste($email)
	{
		
		$stmt = $this->getConnection()->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
		$stmt->execute([$email]);
		$num = $stmt->fetch(PDO::FETCH_NUM);

		if ($num > 0){
			return true;
			} else {
			return false;
		}
	}


	function generateToken()
	{
		$gen = md5(uniqid(mt_rand(), false));
		return $gen;
	}

	function hashPassword($password)
	{
		$hash = password_hash($password, PASSWORD_DEFAULT);
		return $hash;
	}

	
	function recuperacion(){

		$mail = new Mail();
		$vali = new Validaciones();

		if(!empty($_POST)){
			$email = $_POST['email'];
		
			if (!$vali->isEmail($email)) {
				$errors[] = "Debe ingresar un correo electronico valido";
		}
				if($this->emailExiste($email)){
					$user_id = $this->getValorid($email);
					$nombre = $this->getValornombre($email);
		
					$token = $this->generaTokenPass($user_id);
					$url = 'http://'.$_SERVER["SERVER_NAME"].'/desarrollologinn/Vistas/cambiarcontra.php?&user_id='.$user_id.'&token='.$token;
					$asunto = 'Recuperar contraseña';
					$cuerpo = "Hola $nombre: <br /><br /> Solicitud para recuperar contraseña<br />
					Para restaurar la contraseña, presione en el siguiente enlace <br /> <a href='$url'>$url</a>";
		
					if($mail->enviarEmail($email, $nombre, $asunto,$cuerpo)){
						echo "Hemos enviado un correo electronico a la dirección $email para
						restablecer tu contraseña.<br />";
						echo "<a href ='index.php'>Iniciar sesión</a>";
						exit;
					}else{
						
					}
					}else{
					$errors[] = "No existe el correo electronico.";
	
					}
		}
	}

	public function cambiarContra(){
		if(empty($_GET['user_id'])){
			header('Location:index.php');
		}
		if(empty($_GET['token'])){
			header('Location:index.php');
		}
		$user_id = $_GET['user_id'];
		$token = $_GET['token'];
	
		if(!$this->verificaTokenPass($user_id, $token)){
			echo 'No se pudo verificar los datos';
			exit;
		}
	}

	public function modificarPass(){

		$vali = new Validaciones();

		$user_id= $_POST['user_id'];
		$token = $_POST['token'];
		$password = $_POST['password'];
		$con_password= $_POST['con_password'];

        if($vali->validaPassword($password, $con_password)){

            $pass_hash = $this->hashPassword($password);
            if ($this->cambiaPassword($pass_hash, $user_id, $token)) {

                echo "contraseña modificada";
                echo "<br> <a href='index.php' >Iniciar sesion</a>";

            } else{

                echo "error al modificar";
            }
                # code...
            } else{

                echo 'las contraseñas no coinciden';

            }
	}


}