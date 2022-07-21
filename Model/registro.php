
<?php

require_once './conexiondb/database.php';
require_once './Model/validaciones.php';
require_once './Model/usuarios.php';
require_once './Model/mail.php';


class Registro extends DATABASE{

	
	public function registro(){

        $errors = array();
	    if (!empty($_POST)) {
		$nombre = $_POST['nombre'];
		$usuario = $_POST['usuario'];
		$Apel = $_POST['apellido'];
		$password = $_POST['password'];
		$prog= $_POST['programa'];
        $ide= $_POST['identificacion'];
        $tipo_usuario = $_POST['tipo'];
		$email = $_POST['email'];
		
		$activo = 0;

        $vali = new Validaciones();
        
        $user = new Usuarios();

		if (!$vali->isEmail($email)) {
			$errors[] = "Direccion de correo inválida";
		}
		if (strlen($ide) > 20) {
           $errors[] = "Número de identifacion es mayor a 20 caracteres";
        }
        if (strlen($password) < 6 || strlen($password) > 20) {
           $errors[] = "Número de pasword invalido ";
         }
        if (!ctype_alnum($usuario)) {
            $errors[] = "exiten caracteres especiales en el username ";
         }

		if ($user->usuarioExiste($usuario)) {
			$errors[] = "El usuario $usuario ya existe";
		}
	
		if ($user->emailExiste($email)) {
			$errors[] = "El correo electronico $email ya existe";
		}

		if (count($errors) == 0) {
			$response = file_get_contents('mensaje.txt', true, NULL, 0, 36);

			var_dump($response);
			$arr = json_decode($response, true);

					
				$pass_hash = $user->hashPassword($password);
				$token = $user->generateToken();


				$registro = $user->registraUsuario($usuario, $nombre, $Apel, $email, $pass_hash, $ide, $activo, $prog, $tipo_usuario, $token);

					$url = 'http://'. $_SERVER["SERVER_NAME"].'/desarrollologinn/router.php?controller=Usuario&action=activacion&val='.$token;

					$asunto = 'Activar Cuenta';
					$cuerpo = "Hola $nombre ¿Cómo estás? <br /><br />Presione en el siguiente enlace para activar su cuenta <a href='$url'>$url</a>";

					$mail = new Mail();

					if ($mail->enviarEmail($email, $nombre, $asunto, $cuerpo)) {
						echo "Le enviamos los pasos para activar su cuenta al correo: $email";

						echo "<br><a href='index.php'>Iniciar Sesion</a>";
						exit;


					} else {
						$errors[] = "Error al enviar Email";
					}


			} 
		}

    }



	public function tipo_usuario(){

		$stmt = $this->getConnection()->prepare("SELECT * FROM tipo_usuario");	
		$stmt->execute([]);

		$obj = $stmt->fetchALL(PDO::FETCH_OBJ);

		return $obj;
	
	}

	public function dependencia(){

		$stmt = $this->getConnection()->prepare("SELECT * FROM progr_dependencia");	
		$stmt->execute([]);

		$obj = $stmt->fetchALL(PDO::FETCH_OBJ);

		return $obj;
	
	}
	
}