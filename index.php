<?php

    include "classes/database.php";
    include "classes/client_class.php";
    include "classes/vehicle_class.php";
    include "classes/replacement_class.php";
    include "util/util.php";

	controlAccess();

    $db = Database::getInstance();

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="./resources/style/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="./resources/style/custom.css" />
        <script src="./resources/js/lib.js"></script>
	</head>
    <body onLoad="showSelectedForm()">
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a class="navbar-brand" href="index.php">Taller</a>
			<div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2" id="navbarNav">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="client_list.php">Clientes</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="vehicle_list.php">Vehículos</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="replacement_list.php">Repuestos</a>
					</li>
                    <li class="nav-item">
						<a class="nav-link" href="bill_list.php">Facturas</a>
					</li>
				</ul>
			</div>
			<div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
				<ul class="navbar-nav ml-auto">
                    <li class="nav-item">
						<a class="nav-link" href="login.php">Acceso administrador</a>
					</li>
                    <li class="nav-item" style="margin-top: 6px">
                        <a href="logout.php">
                            <img src="resources/img/logout.png" width="20" height="20" alt="Logout">
                        </a>
                    </li>
				</ul>
			</div>
		</nav>
		
		<div class="container" style="margin-top: 15px">
			<div class="alert alert-dark" role="alert" style="margin-top: 1.5em; margin-bottom: 2em;">
				<h3>Bienvenido a la gestión del taller.</h3>
                <p class="mb-0">Aquí puedes ver, editar o añadir toda la información sobre los clientes, vehículos, piezas de repuesto o facturas.</p>
			</div>

            <h1>Interfaz de consultas</h1>
            <label for="selTarget">Tabla objetivo</label>
            <select class="form-control" name="selTarget" id="selTarget" onChange="showSelectedForm()">
                <option value="clientsForm">Clientes</option>
                <option value="vehiclesForm">Vehículos</option>
                <option value="billsForm">Facturas</option>
            </select>
            <hr>
            
            <div id="clientsForm" style="display: none">
                <form action="" method="POST">
                    <input type="hidden" name="action" value="filter_clients">
                    <div class="form-group">
                        <label for="clientName">Nombre</label>
                        <input type="text" class="form-control" name="clientName" id="clientName">
                    </div>
                    <div class="form-group">
                        <label for="clientName">Primer apellido</label>
                        <input type="text" class="form-control" name="clientSurname1" id="clientSurname1">
                    </div>
                    <div class="form-group">
                        <label for="clientName">Segundo apellido</label>
                        <input type="text" class="form-control" name="clientSurname2" id="clientSurname2">
                    </div>
                    <div class="form-group">
                        <label for="clientName">Localización</label>
                        <input type="text" class="form-control" name="clientLocation" id="clientLocation">
                    </div>
                    <div class="form-group">
                        <label for="clientName">Provincia</label>
                        <input type="text" class="form-control" name="clientProvince" id="clientProvince">
                    </div>
                    <div class="form-group">
                        <label for="clientName">Teléfono</label>
                        <input type="text" class="form-control" name="clientTelephone" id="clientTelephone">
                    </div>
                    <button type="submit" class="btn btn-primary" name="filter_clients">Filtrar clientes</button>
                </form>
            </div>
            <div id="vehiclesForm" style="display: none">
                <form action="" method="POST">
                    <input type="hidden" name="action" value="filter_vehicles">
                    <div class="form-group">
                        <label for="clientName">Marca</label>
                        <input type="text" class="form-control" name="vehicleBrand" id="vehicleBrand">
                    </div>
                    <div class="form-group">
                        <label for="clientName">Modelo</label>
                        <input type="text" class="form-control" name="vehicleModel" id="vehicleModel">
                    </div>
                    <div class="form-group">
                        <label for="clientName">Año</label>
                        <input type="text" class="form-control" name="vehicleYear" id="vehicleYear">
                    </div>
                    <div class="form-group">
                        <label for="clientName">Color</label>
                        <input type="text" class="form-control" name="vehicleColor" id="vehicleColor">
                    </div>
                    <button type="submit" class="btn btn-primary" name="filter_vehicles">Filtrar vehículos</button>
                </form>
            </div>
            <div id="billsForm" style="display: none">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="clientName">Fecha de inicio</label>
                        <input type="text" class="form-control" name="billCreationStart" id="billCreationStart">
                        <input type="text" class="form-control" name="billCreationEnd" id="billCreationEnd">
                    </div>
                    <div class="form-group">
                        <label for="clientName">Modelo</label>
                        <input type="text" class="form-control" name="clientSurname1" id="clientSurname1">
                    </div>
                    <div class="form-group">
                        <label for="clientName">Año</label>
                        <input type="text" class="form-control" name="clientSurname2" id="clientSurname2">
                    </div>
                    <div class="form-group">
                        <label for="clientName">Color</label>
                        <input type="text" class="form-control" name="clientLocation" id="clientLocation">
                    </div>
                    <button type="submit" class="btn btn-primary" name="filter_bills">Filtrar facturas</button>
                </form>
            </div>

            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
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
                <?php

                    if (isset($_POST['filter_clients'])) {
                        $clientName = isset($_POST['clientName']) ? $_POST['clientName'] : null;
                        $clientSurname1 = isset($_POST['clientSurname1']) ? $_POST['clientSurname1'] : null;
                        $clientSurname2 = isset($_POST['clientSurname2']) ? $_POST['clientSurname2'] : null;
                        $clientLocation = isset($_POST['clientLocation']) ? $_POST['clientLocation'] : null;
                        $clientProvince = isset($_POST['$clientProvince']) ? $_POST['$clientProvince'] : null;
                        $clientTelephone = isset($_POST['$clientTelephone']) ? $_POST['$clientTelephone'] : null;

                        if ($clientName != null && $clientSurname1 != null && $clientSurname2 != null && $clientLocation != null && $clientProvince != null && $clientTelephone != null) {
                            $query =  "SELECT * FROM clientes";

                        } else {
                            $query = "SELECT * FROM clientes WHERE";

                            if ($clientName != null) {
                                $pieces = explode(' ', $query);
                                $last_word = array_pop($pieces);

                                if ($last_word != "WHERE") {
                                    $query .= " AND";
                                }
                                $query .= " nombre = '$clientName'";
                            }

                            if ($clientSurname1 != null) {
                                $pieces = explode(' ', $query);
                                $last_word = array_pop($pieces);

                                if ($last_word != "WHERE") {
                                    $query .= " AND ";
                                }
                                $query .= " apellido1 = '$clientSurname1'";
                            }

                            if ($clientSurname2 != null) {
                                $pieces = explode(' ', $query);
                                $last_word = array_pop($pieces);

                                if ($last_word != "WHERE") {
                                    $query .= " AND ";
                                }
                                $query .= " apellido2 = '$clientSurname2'";
                            }

                            if ($clientLocation != null) {
                                $pieces = explode(' ', $query);
                                $last_word = array_pop($pieces);

                                if ($last_word != "WHERE") {
                                    $query .= " AND ";
                                }
                                $query .= " poblacion = '$clientLocation'";
                            }

                            if ($clientProvince != null) {
                                $pieces = explode(' ', $query);
                                $last_word = array_pop($pieces);

                                if ($last_word != "WHERE") {
                                    $query .= " AND ";
                                }
                                $query .= " provincia = '$clientProvince'";
                            }

                            if ($clientTelephone != null) {
                                $pieces = explode(' ', $query);
                                $last_word = array_pop($pieces);

                                if ($last_word != "WHERE") {
                                    $query .= " AND ";
                                }
                                $query .= " telefono = '$clientTelephone'";
                            }

                            $pieces = explode(' ', $query);
                            $last_word = array_pop($pieces);

                            if ($last_word == "WHERE") {
                                $query = preg_replace('/\W\w+\s*(\W*)$/', '$1', $query);
                            }

                            $result = $db->conn()->query($query);

                            for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                                $client = Client::parseClient($result);


                                ?>
                                <tbody>
                                <tr>
                                    <th scope="row" class="align-middle clickable"
                                        onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
                                        <?php echo $client->getId(); ?>
                                    </th>
                                    <td class="align-middle clickable"
                                        onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
                                        <img class="client-img" src="<?php echo $client->getPhoto() ?>"/>

                                    </td>
                                    <td class="align-middle clickable"
                                        onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
                                        <?php echo $client->getDni() ?>
                                    </td>
                                    <td class="align-middle clickable"
                                        onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
                                        <?php echo $client->getName() ?>
                                    </td>
                                    <td class="align-middle clickable"
                                        onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
                                        <?php echo $client->getSurname1() . ' ' . $client->getSurname2() ?>
                                    </td>
                                    <td class="align-middle clickable"
                                        onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
                                        <?php echo $client->getAddress() ?>
                                    </td>
                                    <td class="align-middle clickable"
                                        onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
                                        <?php echo $client->getPostalCode() ?>
                                    </td>
                                    <td class="align-middle clickable"
                                        onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
                                        <?php echo $client->getLocation() ?>
                                    </td>
                                    <td class="align-middle clickable"
                                        onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
                                        <?php echo $client->getProvince() ?>
                                    </td>
                                    <td class="align-middle clickable"
                                        onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
                                        <?php echo $client->getTelephone() ?>
                                    </td>
                                    <td class="align-middle clickable"
                                        onclick="listElementDetails('edit_client.php?client_id=<?php echo $client->getId(); ?>')">
                                        <?php echo $client->getEmail() ?>
                                    </td>
                                </tr>
                                </tbody>
                    <?php

                            }
                        }

                    } elseif (isset($_POST['filter_vehicles'])) {


                    } elseif (isset($_POST['filter_bills'])) {


                    }

                ?>
            </table>
		</div>
	</body>
</html>