<?php
	
	include('dbconnection.php');
	include('util.php');

	if (!isLogged()) {
		header("Location: login.php");
	}

	$query = 'SELECT * FROM CLIENTES';
	$queryResult = $conn->query($query);

?>
	<html>

	<head>
		<link rel="stylesheet" type="text/css" href="./style/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="./style/custom.css" />
	</head>

	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
			<a class="navbar-brand" href="index.php">Taller</a>
			<div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2" id="navbarNav">
				<ul class="navbar-nav mr-auto">
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
			<h2>Listado de clientes</h2>
			<form action="">
				<table class="table table-hover">
					<thead>
						<tr>
							<th></th>
							<th>#</th>
							<th>Foto</th>
							<th>DNI</th>
							<th>Nombre</th>
							<th>Apellidos</th>
							<th>Dirección</th>
							<th>CP</th>
							<th>Población</th>
							<th>Provincia</th>
							<th>Teléfono</th>
							<th>E-mail</th>
						</tr>
					</thead>
					<tbody>
					<?php
						
						while ($customer = $queryResult->fetch_assoc()) {

					?>
							<tr>
								<td>
									<input type="checkbox" />
								</td>
								<th scope="row" class="align-middle">
									<?=$customer['id_cliente']?>
								</th>
								<td class="align-middle">
									<img class="customer-img" src="data:image/jpeg;base64,<?=base64_encode($customer['fotografia'])?>" />
								</td>
								<td class="align-middle">
									<?=$customer['dni']?>
								</td>
								<td class="align-middle">
									<?=$customer['nombre']?>
								</td>
								<td class="align-middle">
									<?=$customer['apellido1'] . ' ' . $customer['apellido2']?>
								</td>
								<td class="align-middle">
									<?=$customer['direccion']?>
								</td>
								<td class="align-middle">
									<?=$customer['cp']?>
								</td>
								<td class="align-middle">
									<?=$customer['poblacion']?>
								</td>
								<td class="align-middle">
									<?=$customer['provincia']?>
								</td>
								<td class="align-middle">
									<?=$customer['telefono']?>
								</td>
								<td class="align-middle">
									<?=$customer['email']?>
								</td>
							</tr>
					<?php
						
						}

					?>
					</tbody>
				</table>

				<button type="button" class="btn btn-danger">Eliminar</button>
			</form>
		</div>
	</body>

	</html>