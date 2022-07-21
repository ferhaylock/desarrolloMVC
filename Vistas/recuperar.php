
<html>
	<head>
		<title>Recuperar contraseña</title>
		<link rel="stylesheet" href="./../css/style.css">
		
	</head>
	<body>
	<form class="form" action="./../router.php?controller=Usuario&action=recuperacion" method="POST" autocomplete="off">
	<h2 class="form__title">Recuperar contraseña</h2>
        <p class="form__paragraph">Inicia sesion <a href="./../index.php" class="form__link">Entra aquí</a></p>

        <div class="form__container">
            <div class="form__group">
                <input type="text" id="user" name="email"class="form__input" placeholder=" " value="<?php if(isset($usuario)) echo $usuario; ?>" required>
                <label for="email" class="form__label">Correo:</label>
                <span class="form__line"></span>
            </div>
			<input type="submit" class="form__submit" value="Enviar">
        </div>
	   </form> 	
		
	</body>
</html>							