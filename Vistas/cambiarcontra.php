
<html>
	<head>
		<title>Cambiar contraseña</title>
		<link rel="stylesheet" href="./../css/style.css">
		
	</head>
	<body>
	<form class="form" action="./../router.php?controller=Usuario&action=modificarPass" role="form" method="POST" autocomplete="off">
	<h2 class="form__title">Cambiar contraseña</h2>
        <p class="form__paragraph">Inicia sesion <a href="index.php" class="form__link">Entra aquí</a></p>
        <input type="hidden" id="user_id" name="user_id" value="<?php echo isset($_GET['user_id']) ? $_GET['user_id']: '' ?>" />

        <input type="hidden" id="token" name="token" value="<?php echo isset($_GET['token']) ? $_GET['token']: ''; ?>" />

        <div class="form__container">
            <div class="form__group">
                <input type="password" name="password"class="form__input" placeholder=" " value="<?php if(isset($usuario)) echo $usuario; ?>" required>
                <label for="email" class="form__label">Nueva contraseña:</label>
                <span class="form__line"></span> 
            </div>
            <div class="form__group">
                <input type="password" name="con_password" class="form__input" placeholder=" " value="<?php if(isset($usuario)) echo $usuario; ?>" required>
                <label for="con_password" class="form__label">Confirmar contraseña:</label>
                <span class="form__line"></span> 
            </div>
			<input type="submit" class="form__submit" value="Enviar">
        </div>
	   </form> 	
		
	</body>
</html>	