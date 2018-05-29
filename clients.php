<?php
	
	include('dbconnection.php');
	include('client_class.php');
	include('util.php');

	if (!isLogged()) {
		header("Location: login.php");
	}

	$query = 'SELECT * FROM CLIENTES ORDER BY ID_CLIENTE';
	$result = $conn->query($query);

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
					<li class="nav-item active">
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
		<?php
			if (isset($_POST['action'])) {
				$action = $_POST['action'];
			} else {
				$action = "";
			}
			
			switch ($action) {
				case "":
		?>
			<form action="">
				<input type='hidden' id='action' name='action' value='user_delete'>
				<div class="form-inline">
					<h2>Listado de clientes</h2>
					<form action="" method="POST" class="p-0 m-0">
						<input type="hidden" id="clientID" name="clientID" value="<?=$client['id_cliente']?>" />
						<button type="submit" class="btn btn-danger ml-auto p-1 m-0">Eliminar</button>
					</form>
				</div>
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
							<th>Detalles</th>
						</tr>
					</thead>
					<tbody>
					<?php

						$client = new Client($conn);

						for ($i = 0; $i < mysqli_num_rows($result); $i++) {
							$client = parseClient($result);
					?>
							<tr>
								<td class="align-middle">
									<input type="checkbox" />
								</td>
								<th scope="row" class="align-middle">
									<?=$client->getId();?>
								</th>
								<td class="align-middle">
									<img class="client-img" src="<?=$client->getAvatar()?>" />
								</td>
								<td class="align-middle">
									<?=$client->getDni()?>
								</td>
								<td class="align-middle">
									<?=$client->getName()?>
								</td>
								<td class="align-middle">
									<?=$client->getSurname1() . ' ' . $client->getSurname2()?>
								</td>
								<td class="align-middle">
									<?=$client->getAddress()?>
								</td>
								<td class="align-middle">
									<?=$client->getPostalCode()?>
								</td>
								<td class="align-middle">
									<?=$client->getLocation()?>
								</td>
								<td class="align-middle">
									<?=$client->getProvince()?>
								</td>
								<td class="align-middle">
									<?=$client->getTelephone()?>
								</td>
								<td class="align-middle">
									<?=$client->getEmail()?>
								</td>
								<td class="align-middle">
									<form action="client_details.php" method="POST" class="p-0 m-0">
										<input type="hidden" id="clientID" name="clientID" value="<?=$client->getID()?>" />
										<button type="submit" class="btn btn-primary ml-auto p-1 m-1">Detalles</button>
									</form>
								</td>
							</tr>
							<?php
						
						}

					?>
					</tbody>
				</table>
			</form>
			<?php
					break;

				case "delete_client":
					
					break;
			}

		?>
		</div>
	</body>
</html>