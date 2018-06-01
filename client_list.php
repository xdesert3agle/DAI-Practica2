<?php
	
	include "classes/database.php";
	include "classes/client_class.php";
	include "classes/vehicle_class.php";
	include "util/util.php";

	controlAccess();

	$db = Database::getInstance();

	$client_list = $db->conn()->query("SELECT * FROM CLIENTES ORDER BY ID_CLIENTE");

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="./resources/style/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="./resources/style/custom.css" />
        <script src="./resources/js/lib.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a class="navbar-brand" href="index.php">Taller</a>
			<div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2" id="navbarNav">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="client_list.php">Gestión de clientes</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="vehicle_list.php">Gestión de vehículos</a>
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
		<div class="container-fluid">
			<form action="delete_element.php" method="POST" class="pt-0 mt-0">
				<input type='hidden' id='action' name='action' value='user_delete'>
				<input type="hidden" name="target" value="client">
				<table class="table table-hover no-top-thead">
					<thead>
						<tr>
							<th colspan="5">
								<h1>Listado de clientes</h1>
							</th>
							<th colspan="8" class="text-right">
								<form action="" method="POST" class="p-0 m-0">
									<input type="hidden" id="client_id" name="client_id" value="<?php echo $client['id_cliente']?>" />
									<button type="submit" class="btn btn-danger p-1 mr-2" value="delete_selected" onClick="return confirm('¿Estás segur@ de que quieres eliminar a los clientes seleccionados de la base de datos?');">Eliminar seleccionados</button>
								</form>
								<a href="register_client.php" class="btn btn-dark p-1 mr-0" value="add_new">Añadir nuevo</a>
							</th>
						</tr>
					</thead>
					<thead class="thead-light">
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

						$client = new Client();

						for ($i = 0; $i < mysqli_num_rows($client_list); $i++) {
							$client = Client::parseClient($client_list);
							
					?>
					
							<!-- El onClick va en todas las columnas menos en la de la checkbox para evitar missclicks -->
							<tr>
								<td class="align-middle">
									<input type="checkbox" name="id[]" value="<?php echo $client->getId(); ?>" onClick="stopCheckbox(this);"/>
								</td>
								<th scope="row" class="align-middle clickable" onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
									<?php echo $client->getId(); ?>
								</th>
								<td class="align-middle clickable" onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
									<img class="client-img" src="<?php echo $client->getPhoto()?>" />
								</td>
								<td class="align-middle clickable" onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
									<?php echo $client->getDni()?>
								</td>
								<td class="align-middle clickable" onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
									<?php echo $client->getName()?>
								</td>
								<td class="align-middle clickable" onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
									<?php echo $client->getSurname1() . ' ' . $client->getSurname2()?>
								</td>
								<td class="align-middle clickable" onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
									<?php echo $client->getAddress()?>
								</td>
								<td class="align-middle clickable" onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
									<?php echo $client->getPostalCode()?>
								</td>
								<td class="align-middle clickable" onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
									<?php echo $client->getLocation()?>
								</td>
								<td class="align-middle clickable" onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
									<?php echo $client->getProvince()?>
								</td>
								<td class="align-middle clickable" onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
									<?php echo $client->getTelephone()?>
								</td>
								<td class="align-middle clickable" onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
									<?php echo $client->getEmail()?>
								</td>
							</tr>
							<?php
						
						}

					?>
					</tbody>
				</table>
			</form>
		</div>
	</body>
</html>