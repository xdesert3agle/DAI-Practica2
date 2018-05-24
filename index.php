<?php
	
	include('util.php');

	if (!isLogged()) {
		header("Location: login.php");
	}

?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="./style/bootstrap.min.css" />
    </head>
    <body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
			<a class="navbar-brand" href="index.php">Taller</a>
			<div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2" id="navbarNav">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="clients.php">Gestión de clientes</a>
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
			<div class="alert alert-primary" role="alert" style="margin-top: 1.5em; margin-bottom: 2em;">
				<h3 class="mb-0">Bienvenido a la gestión del taller.</h3>
			</div>
		</div>
	</body>
</html>