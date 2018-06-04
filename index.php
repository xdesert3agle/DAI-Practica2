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
                <form action="" method="GET">
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
                    <button type="submit" class="btn btn-primary">Filtrar clientes</button>
                </form>
            </div>
            <div id="vehiclesForm" style="display: none">
                <form action="" method="GET">
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
                    <button type="submit" class="btn btn-primary">Filtrar vehículos</button>
                </form>
            </div>
            <div id="billsForm" style="display: none">
                <form action="" method="GET">
                    <input type="hidden" name="action" value="filter_bills">
                    <div class="form-group">
                        <h4>Emitidas entre dos fechas</h4>
                        <div class="row">
                            <div class="col-6">
                                <label for="billCreationStart">Fecha de inicio</label>
                                <input type="text" class="form-control" name="billCreationStart" id="billCreationStart">
                            </div>
                            <div class="col-6">
                                <label for="billCreationEnd">Fecha fin</label>
                                <input type="text" class="form-control" name="billCreationEnd" id="billCreationEnd">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <h4>Pagadas entre dos fechas</h4>
                        <div class="row">
                            <div class="col-6">
                                <label for="clientName">Fecha de inicio</label>
                                <input type="text" class="form-control" name="billPaymentStart" id="billPaymentStart">
                            </div>
                            <div class="col-6">
                                <label for="clientName">Fecha fin</label>
                                <input type="text" class="form-control" name="billPaymentEnd" id="billPaymentEnd">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <h4>Sólo pendientes de pago</h4>
                        <div class="row" style="margin-left: 20px;">
                            <input type="checkbox" class="form-check-input" id="onlyNonPayedBills" name="onlyNonPayedBills">
                            <label class="form-check-label" for="onlyNonPayedBills">Mostrar sólo facturas pendientes de pago</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <h4>De un determinado cliente</h4>
                        <?php

                            echo $db->getClientList(-1, 0, 1);

                        ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar facturas</button>
                </form>
            </div>

            <table class="table table-hover">
            <?php

                $action = isset($_GET['action']) ? $_GET['action'] : null;

                switch ($action) {
                    case "filter_clients":


            ?>
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

                        $fields = array("nombre", "apellido1", "apellido2", "poblacion", "provincia", "telefono");
                        $values = array($_GET['clientName'], $_GET['clientSurname1'], $_GET['clientSurname2'], $_GET['clientLocation'], $_GET['clientProvince'], $_GET['clientTelephone']);
                        $query = "SELECT * FROM clientes ";

                        $i = 0;
                        foreach ($fields as $key) {
                            if ($values[$i] != "") {
                                if ($i > 0) {
                                    $query .= " AND ";
                                } else {
                                    $query .= " WHERE ";
                                }

                                $query .= $key . " = '" . $db->conn()->real_escape_string($values[$i]) . "'";
                            }

                            $i++;
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

                        break;

                    case "filter_vehicles":

                ?>
                <thead class="thead-light">
                    <tr>
                        <th># Vehículo</th>
                        <th>Matrícula</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Año</th>
                        <th>Color</th>
                        <th>Propietario</th>
                    </tr>
                </thead>
                    <?php

                        $fields = array("marca", "modelo", "anio", "color");
                        $values = array($_GET['vehicleBrand'], $_GET['vehicleModel'], $_GET['vehicleYear'], $_GET['vehicleColor']);
                        $query = "SELECT * FROM vehiculos ";

                        $i = 0;
                        foreach ($fields as $key) {
                            if ($values[$i] != "") {
                                if ($i > 0) {
                                    $query .= " AND ";
                                } else {
                                    $query .= " WHERE ";
                                }

                                $query .= $key . " = '" . $db->conn()->real_escape_string($values[$i]) . "'";
                            }

                            $i++;
                        }

                        $result = $db->conn()->query($query);

                        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                            $vehicle = Vehicle::parseVehicle($result);

                    ?>
                <tbody>
                    <tr>
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
                </tbody>
                <?php
                        }

                        break;

                    case "filter_bills":

                ?>
                <thead class="thead-light">
                    <tr>
                        <th># Factura</th>
                        <th>Matricula</th>
                        <th>Horas</th>
                        <th>Precio/hora</th>
                        <th>Fecha emisión</th>
                        <th>Fecha pago</th>
                        <th>Base imponible</th>
                        <th>IVA</th>
                        <th>Total</th>
                    </tr>
                </thead>
                    <?php
                        $billCreationStart = isset($_GET['billCreationStart']) ? $_GET['billCreationStart'] : null;
                        $billCreationEnd = isset($_GET['billCreationEnd']) ? $_GET['billCreationEnd'] : null;
                        $billPaymentStart = isset($_GET['billPaymentStart']) ? $_GET['billPaymentStart'] : null;
                        $billPaymentEnd = isset($_GET['billPaymentEnd']) ? $_GET['billPaymentEnd'] : null;
                        $onlyNonPayedBills = isset($_GET['onlyNonPayedBills']) ? true : false;
                        $owner = $_GET['selectOwnerList'];

                        $query = "SELECT * FROM factura WHERE";

                        // Ha usado la opción de 'Emitidas entre dos fechas'
                        if ($billCreationStart != null || $billCreationEnd != null) {

                            if ($billCreationStart != null) {
                                if (substr($query, strrpos($query, ' ') + 1) !== "WHERE") {
                                    $query .= " AND";
                                }

                                $query .= " fecha_emision >= '$billCreationStart'";
                            }

                            if ($billCreationEnd != null) {
                                if (substr($query, strrpos($query, ' ') + 1) !== "WHERE") {
                                    $query .= " AND";
                                }

                                $query .= " fecha_emision <= '$billCreationEnd'";
                            }
                        }

                        // Ha usado la opción de 'Pagadas entre dos fechas'
                        if ($billPaymentStart != null || $billPaymentEnd != null) {
                            if ($billPaymentStart != null) {
                                if (substr($query, strrpos($query, ' ') + 1) !== "WHERE") {
                                    $query .= " AND";
                                }

                                $query .= " fecha_pago >= '$billPaymentStart'";
                            }

                            if ($billPaymentEnd != null) {
                                if (substr($query, strrpos($query, ' ') + 1) !== "WHERE") {
                                    $query .= " AND";
                                }

                                $query .= " fecha_pago <= '$billPaymentEnd'";
                            }
                        }

                        if ($onlyNonPayedBills) {
                            if (substr($query, strrpos($query, ' ') + 1) !== "WHERE") {
                                $query .= " AND";
                            }

                            $query .= " fecha_pago NOT NULL";
                        }

                        if ($owner != -1) {

                            $clientName = $db->conn()->query("SELECT * FROM clientes WHERE id_cliente = $owner")->fetch_assoc()['nombre'];
                            $plateList = $db->getPlateListFromClientID($owner);

                            if (substr($query, strrpos($query, ' ') + 1) !== "WHERE") {
                                $query .= " AND ";
                            }

                            for ($j = 0; $j < count($plateList); $j++) {

                                if ($j === 0 && count($plateList) > 1) {
                                    if (count($plateList) !== 1) {
                                        $query .= " (";
                                    }
                                }

                                if ($j === 0) {
                                    $query .= " matricula = '$plateList[$j]'";
                                } else {
                                    $query .= " OR matricula = '$plateList[$j]'";
                                }

                                if ($j === count($plateList) - 1 && count($plateList) !== 1){
                                    $query .= ")";
                                }
                            }
                        }

                        $lastWord = substr($query, strrpos($query, ' ') + 1);

                        $query = $lastWord !== "WHERE" ? $query : preg_replace('/\W\w+\s*(\W*)$/', '$1', $query);

                        $result = $db->conn()->query($query);

                        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                            $bill = $result->fetch_assoc();
                            ?>
                            <tbody>
                                <tr>
                                    <th scope="row" class="align-middle clickable" onclick="listElementDetails('edit_bill.php?bill_id=<?php echo $bill['numero_factura'] ?>')">
                                        <?php echo $bill['numero_factura'] ?>
                                    </th>
                                    <td class="align-middle clickable" onclick="listElementDetails('edit_bill.php?bill_id=<?php echo $bill['numero_factura'] ?>')">
                                        <?php echo $bill['matricula'] ?>
                                    </td>
                                    <td class="align-middle clickable" onclick="listElementDetails('edit_bill.php?bill_id=<?php echo $bill['numero_factura'] ?>')">
                                        <?php echo $bill['horas'] ?>
                                    </td>
                                    <td class="align-middle clickable" onclick="listElementDetails('edit_bill.php?bill_id=<?php echo $bill['numero_factura'] ?>')">
                                        <?php echo $bill['precio_hora'] ?>
                                    </td>
                                    <td class="align-middle clickable" onclick="listElementDetails('edit_bill.php?bill_id=<?php echo $bill['numero_factura'] ?>')">
                                        <?php echo parseDateToYMD($bill['fecha_emision']) ?>
                                    </td>
                                    <td class="align-middle clickable" onclick="listElementDetails('edit_bill.php?bill_id=<?php echo $bill['numero_factura'] ?>')">
                                        <?php echo parseDateToYMD($bill['fecha_pago']) ?>
                                    </td>
                                    <td class="align-middle clickable" onclick="listElementDetails('edit_bill.php?bill_id=<?php echo $bill['numero_factura'] ?>')">
                                        <?php echo $bill['base_imponible'] ?>
                                    </td>
                                    <td class="align-middle clickable" onclick="listElementDetails('edit_bill.php?bill_id=<?php echo $bill['numero_factura'] ?>')">
                                        <?php echo $bill['iva'] ?>
                                    </td>
                                    <td class="align-middle clickable" onclick="listElementDetails('edit_bill.php?bill_id=<?php echo $bill['numero_factura'] ?>')">
                                        <?php echo $bill['total'] ?>
                                    </td>
                                </tr>
                            </tbody>
                            <?php
                        }

                        break;
                    }

                ?>
            </table>
		</div>
	</body>
</html>