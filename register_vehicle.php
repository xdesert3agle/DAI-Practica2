<?php
	
	include "classes/database.php";
    include "classes/client_class.php";
    include "classes/vehicle_class.php";
    include "util/util.php";

    controlAccess();
    
    $db = Database::getInstance();
    $imageError = false;

    // Insertar nuevo cliente
    if (isset($_POST['add_vehicle'])){
        $plate = $_POST['plate'];
        $owner = $_POST['selectOwnerList'];
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $color = $_POST['color'];

        $result = $db->conn()->query("INSERT INTO VEHICULOS (MATRICULA, MARCA, MODELO, ANIO, COLOR, ID_CLIENTE) VALUES ('$plate', '$brand', '$model', '$year', '$color', '$owner')");
        header("Location: vehicle_list.php");
    }

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
					<li class="nav-item">
						<a class="nav-link" href="client_list.php">Clientes</a>
                    </li>
                    <li class="nav-item active">
						<a class="nav-link" href="vehicle_list.php">Vehículos</a>
					</li>
                    <li class="nav-item">
						<a class="nav-link" href="replacement_list.php">Repuestos</a>
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
            <h1>Registrar un vehículo nuevo</h1>
            <hr>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-3">
                        <label for="id">ID</label>
                        <input type="text" class="form-control" name="id_disabled" value="<?php echo $db->getNewVehicleID(); ?>" disabled>
                    </div>
                    <div class="form-group col-2">
                        <label for="plate">Matrícula</label>
                        <input type="text" class="form-control" name="plate" id="plate" maxlength="10" required="required">
                    </div>
                    <div class="form-group col-sm">
                        <label for="selectOwnerList">Propietario</label>
                        <select class="form-control" name="selectOwnerList">
                        
                        <?php
                        $clientList = $db->conn()->query("SELECT * FROM CLIENTES");
                        
                        for ($i = 0; $i < mysqli_num_rows($clientList); $i++) {
                            $client = Client::parseClient($clientList);
                        ?>
                            <option value="<?php echo $client->getId(); ?>"><?php echo "#" . $client->getID() . " - " . $client->getSurname1() . " " . $client->getSurname2() . " " . $client->getName() ?></option>
                        
                        <?php
                        
                        }

                        ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <label for="name">Marca</label>
                        <input type="text" class="form-control" name="brand" id="brand" maxlength="20" required="required">
                    </div>
                    <div class="form-group col-sm">
                        <label for="surname1">Modelo</label>
                        <input type="text" class="form-control" name="model" id="model" maxlength="50" required="required">
                    </div>
                    <div class="form-group col-1">
                        <label for="surname2">Año</label>
                        <input type="text" class="form-control" name="year" id="year" maxlength="4" required="required">
                    </div>
                    <div class="form-group col-2">
                        <label for="address">Color</label>
                        <input type="text" class="form-control" name="color" id="color" maxlength="10" required="required">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="form-group col-sm">
                        <button type="submit" class="btn btn-dark btn-block" name="add_vehicle">Registrar vehículo</button>
                    </div>
                </div>
            </form>
            <?php

                if ($imageError) {
                    
            ?>
            <div class="alert alert-danger" role="alert" style="margin-top: 1.5em; margin-bottom: 2em;">
                <h4 class="mb-0">Error al editar la información del cliente.</h4>
                <p class="mb-0">Formato de imagen no soportado.</p>
            </div>
            <?php
            
                }

            ?>
        </div>
    </body>
</html>