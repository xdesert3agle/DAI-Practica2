<?php
	
	include('util.php');

	$loginError = false;
		
	if (isset($_POST['user']) && isset($_POST['password'])) {
		$inputUsername = $_POST['user'];
		$inputPwd = $_POST['password'];

		if ($inputUsername == 'miguelangel' && $inputPwd == '2018dai') {
			if(!isset($_SESSION)){ 
				session_start();
				$_SESSION['isLogged'] = 'logged';
			}
			header("Location: index.php");
		} else {
			$loginError = true;
		}
	}
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="./style/bootstrap.min.css" />
    </head>
    <body>
			<?php

				if (isLogged()) {

			?>
			<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
				<a class="navbar-brand" href="index.php">Taller</a>
				<div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2" id="navbarNav">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link" href="customers.php">Gestión de clientes</a>
						</li>
					</ul>
				</div>
				<div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<a class="nav-link" href="login.php">Acceso administrador</a>
						</li>
					</ul>
				</div>
			</nav>
			<div class="container" style="margin-top: 15px">
				<h1>Acceso administrador</h1>
				<hr>

				<div class="alert alert-success" role="alert" style="margin-top: 1.5em; margin-bottom: 2em;">
					<h3 class="mb-0">Bienvenido, miguelangel.</h3>
					<p class="mb-0">Haz click <a href="logout.php">aquí</a> para cerrar tu sesión.</p>
				</div>
					
			</div>
			<?php

				} else {

			?>
			<div class="container" style="margin-top: 15px">
				<h1>Acceso administrador</h1>
				<hr>

				<form action="" method="POST">
					<legend>Acceso administrador</legend>
					<div class="form-group">
						<label for="user">Usuario</label>
						<input type="text" class="form-control" id="user" name="user" placeholder="Nombre de usuario">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
					</div>
					<button type="submit" class="btn btn-primary">Identificarse</button>
				</form>
			<?php

					if ($loginError) {
						echo '<div class="alert alert-danger" role="alert" style="margin-top: 1.5em; margin-bottom: 2em;">'
							. '<p class="mb-0"><strong>Error en el login</strong>: Credenciales incorrectas.</p>'
							. '</div>';
					}

			?>
			</div>
			<?php
			
				}

			?>
	</body>
</html>