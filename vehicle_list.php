<?php
	
	include('dbconnection.php');
    include('client_class.php');
    include('vehicle_class.php');
	include('util.php');

	controlAccess();

	$query = 'SELECT * FROM VEHICULOS ORDER BY ID_CLIENTE';
	$result = $conn->query($query);

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="./style/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="./style/custom.css" />
        <script src="./js/lib.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a class="navbar-brand" href="index.php">Taller</a>
			<div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2" id="navbarNav">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="client_list.php">Gestión de clientes</a>
					</li>
					<li class="nav-item active">
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
		<div class="container">
			<form action="delete_element.php" method="POST" class="pt-0 mt-0">
				<input type='hidden' id='action' name='action' value='user_delete'>
				<input type="hidden" name="target" value="vehicle">
				<table class="table table-hover no-top-thead">
					<thead>
						<tr>
							<th colspan="5">
								<h1>Listado de vehículos</h1>
							</th>
							<th colspan="8" class="text-right">
								<form action="" method="POST" class="p-0 m-0">
									<input type="hidden" id="client_id" name="client_id" value="<?php echo $vehicle['id_cliente']?>" />
									<button type="submit" class="btn btn-danger p-1 mr-2" value="delete_selected" onClick="return confirm('¿Estás segur@ de que quieres eliminar los coches seleccionados de la base de datos?');">Eliminar seleccionados</button>
								</form>
								<a href="register_vehicle.php" class="btn btn-dark p-1 mr-0" value="add_new">Añadir nuevo</a>
							</th>
						</tr>
					</thead>
					<thead class="thead-light">
						<tr>
							<th></th>
							<th># Vehículo</th>
							<th>Matrícula</th>
							<th>Marca</th>
							<th>Modelo</th>
							<th>Año</th>
							<th>Color</th>
							<th>Propietario</th>
						</tr>
					</thead>
					<tbody>
					<?php

						$vehicle = new Vehicle;

						for ($i = 0; $i < mysqli_num_rows($result); $i++) {
							$vehicle = Vehicle::parseVehicle($result);
							
					?>
					
							<!-- El onClick va en todas las columnas menos en la de la checkbox para evitar missclicks -->
							<tr>
								<td class="align-middle">
									<input type="checkbox" name="id[]" value="<?php echo $vehicle->getId(); ?>" onClick="stopCheckbox(this);"/>
								</td>
								<th scope="row" class="align-middle clickable" onclick="listElementDetails('edit_vehicle.php?vehicle_id=<?php echo $vehicle->getId(); ?>')">
									<?php echo $vehicle->getId(); ?>
								</th>
								<td class="align-middle clickable" onclick="listElementDetails('edit_vehicle.php?vehicle_id=<?php echo $vehicle->getId(); ?>')">
									<?php echo $vehicle->getPlate() ?>
								</td>
								<td class="align-middle clickable" onclick="listElementDetails('edit_vehicle.php?vehicle_id=<?php echo $vehicle->getId(); ?>')">
									<?php echo $vehicle->getBrand() ?>
								</td>
								<td class="align-middle clickable" onclick="listElementDetails('edit_vehicle.php?vehicle_id=<?php echo $vehicle->getId(); ?>')">
									<?php echo $vehicle->getModel() ?>
								</td>
								<td class="align-middle clickable" onclick="listElementDetails('edit_vehicle.php?vehicle_id=<?php echo $vehicle->getId(); ?>')">
									<?php echo $vehicle->getYear() ?>
								</td>
								<td class="align-middle clickable" onclick="listElementDetails('edit_vehicle.php?vehicle_id=<?php echo $vehicle->getId(); ?>')">
									<?php echo $vehicle->getColor() ?>
								</td>
								<td class="align-middle clickable" onclick="listElementDetails('edit_vehicle.php?vehicle_id=<?php echo $vehicle->getId(); ?>')">
									<?php echo $vehicle->getClientID() ?>
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