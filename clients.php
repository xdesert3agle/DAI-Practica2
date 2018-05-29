<?php
	
	include('dbconnection.php');
	include('client_class.php');
	include('util.php');

	if (!isLogged()) {
		header("Location: login.php");
	}
	
	if (isset($_POST['edit_client'])){
	
	}

	$query = 'SELECT * FROM CLIENTES ORDER BY ID_CLIENTE';
	$result = $conn->query($query);

	

?>
	<html>

	<head>
		<link rel="stylesheet" type="text/css" href="./style/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="./style/custom.css" />
		<script src="./js/lib.js"></script>
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
			<form action="delete_client.php" method="POST">
				<input type='hidden' id='action' name='action' value='user_delete'>
				<table class="table table-hover no-top-thead">
					<thead>
						<tr>
							<th colspan="5">
								<h2>Listado de clientes</h2>
							</th>
							<th colspan="8" class="text-right">
								<form action="" method="POST" class="p-0 m-0">
									<input type="hidden" id="client_id" name="client_id" value="<?=$client['id_cliente']?>" />
									<button type="submit" class="btn btn-danger p-1 m-1" value="delete_selected">Eliminar selecc.</button>
								</form>
								<a href="new_client.php" class="btn btn-primary p-1 m-1" value="add_new">Añadir nuevo</a>
							</th>
						</tr>	
					</thead>
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
							<tr onclick="clientDetails('client_details.php?client_id=<?php echo $client->getId();?>')">
								<td class="align-middle">
									<input type="checkbox" name="id[]" value="<?php echo $client->getId();?>" onClick="stopCheckbox(this);"/>
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
									<form action="client_details.php" method="GET" id="formulario" class="p-0 m-0">
										<input type="hidden" id="client_id" name="client_id" value="<?=$client->getID()?>" />
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
			}

		?>
		</div>
	</body>
</html>