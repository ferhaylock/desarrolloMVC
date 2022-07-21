

<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
	<form class="form" action="./router.php?controller=Login&action=login" method="POST" autocomplete="off">
	<h2 class="form__title">Inicia Sesión</h2>
        <p class="form__paragraph">Crea tu cuenta aqui: <a href="./router.php?controller=Registro&action=validaciones" class="form__link">Entra aquí</a></p>

        <div class="form__container">
		
            <div class="form__group">
                <input type="text" id="user" name="usuario"class="form__input" placeholder=" " value="<?php if(isset($usuario)) echo $usuario; ?>" required>
                <label for="usuario" class="form__label">Usuario:</label>
                <span class="form__line"></span>
            </div>
            <div class="form__group">
                <input type="password" id="password" name="password" class="form__input" placeholder=" ">
                <label for="password" class="form__label">Contraseña:</label>
                <span class="form__line"></span>
            </div>
            <input type="submit" class="form__submit" value="Entrar">
			<p class="form__paragraph">Recuperar contraseña: <a href="./Vistas/recuperar.php" class="form__link">Aqui</a></p>
        </div>
        <?php
		 isset($vali) ? $vali->resultBlock($errors) : '';
		?>
	  

		
	   </form> 		
	</body>
</html>
