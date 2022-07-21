
<html>
	<head>
		<title>Registro usuario</title>
		<link rel="stylesheet" href="css/style.css">   
	</head>

	<body>
	<form class="form" action="./router.php?controller=Registro&action=registro" method="POST" autocomplete="off">
	<h2 class="form__title">Registro de usuario</h2>
        <p class="form__paragraph">Inicia sesión aqui: <a href="./index.php" class="form__link">Entra aquí</a></p>

		<div class="option">

		<div class="select">
            <div>Tipo usuario</div>
                <div>
                
                   
                    <select name="tipo">

                    <?php
                       require_once './Controllers/controllersRegistro.php';

                       $registro = new ControllerRegistros();

                       $registro->tipoUsuario();
                ?>
                        
                    </select>
		        </div>
        </div>


            <div class="select">
                <div>Programa/dependencia</div>

                <select name="programa">
                <?php
                       require_once './Controllers/controllersRegistro.php';

                       $registro = new ControllerRegistros();

                       $registro->dependecia();
                ?>
                </select>
            </div>
			</div>
			</div>
        <div class="form__container">
            <div class="form__group">
			<input type="number" name="identificacion" value="<?php if(isset($ide)) echo $ide; ?>" required class="form__input" placeholder=" ">
                <label for="identificacion" class="form__label">Identificacion:</label>
                <span class="form__line"></span>
            </div>
            <div class="form__group">
			<input type="text" maxlength="100" name="nombre" value="<?php if(isset($nombre)) echo $nombre; ?>" required class="form__input" placeholder=" ">
                <label for="nombre" class="form__label">Nombre:</label>
                <span class="form__line"></span>
            </div>
            <div class="form__group">
			<input type="text" maxlength="100" name="apellido" value="<?php if(isset($Apel)) echo $Apel; ?>" required class="form__input" placeholder=" ">
                <label for="apellido" class="form__label">Apellido:</label>
                <span class="form__line"></span>
            </div>
            <div class="form__group">
                <input type="email" maxlength="150" name="email" value="<?php if(isset($email)) echo $email; ?>" class="form__input" placeholder=" " required>
                <label for="email" class="form__label">Correo:</label>
                <span class="form__line"></span>
            </div>
            <div class="form__group">
                <input type="text" id="user" name="usuario" value="<?php if(isset($usuario)) echo $usuario; ?>" name="usuario"class="form__input" placeholder=" " required>
                <label for="usuario" class="form__label">Usuario:</label>
                <span class="form__line"></span>
            </div>
            <div class="form__group">
                <input type="password" id="password" name="password" class="form__input" placeholder=" ">
                <label for="password" class="form__label">Contraseña:</label>
                <span class="form__line"></span>
            </div>
            
            <input id="submit" type="submit" name="submit" class="form__submit" value="Registrar usuario">
        </div>
        <?php
		 isset($vali) ? $vali->resultBlock($errors) : '';
		?>
	   </form>
	</body>
</html>
