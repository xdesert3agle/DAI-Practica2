<?php
	
	include "classes/database.php";
    include "classes/client_class.php";
    include "classes/vehicle_class.php";
    include "util/util.php";

    controlAccess();
    
    $db = Database::getInstance();
    
    if (isset($_GET['vehicle_id'])) {
        $selVehicleID = $_GET['vehicle_id'];
        $vehicle = $db->getVehicleWithID($selVehicleID);
    }

    // Botón de editar vehículo
    if (isset($_POST['edit_client'])){
        $id = $_POST['id'][0];
        $plate = $_POST['plate'];
        $owner = $_POST['selectOwnerList'];
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $color = $_POST['color'];

        $db->conn()->query("UPDATE VEHICULOS SET MATRICULA = '$plate', MARCA ='$brand', MODELO ='$model', ANIO = '$year', COLOR ='$color', ID_CLIENTE = '$owner' WHERE ID_VEHICULO = '$id'");
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
            <h1>Editar vehículo</h1>
            <hr>

            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id[]" value="<?php echo $vehicle->getId(); ?>">
                <input type="hidden" name="target" value="vehicle">
                <div class="row">
                    <div class="form-group col-3">
                        <label for="id">ID</label>
                        <input type="text" class="form-control" name="id_disabled" value="<?php echo $vehicle->getId(); ?>" disabled>
                    </div>
                    <div class="form-group col-2">
                        <label for="plate">Matrícula</label>
                        <input type="text" class="form-control" name="plate" id="plate" value="<?php echo $vehicle->getPlate(); ?>" maxlength="10" required="required">
                    </div>
                    <div class="form-group col-sm">
                        <?php echo $db->getClientList($vehicle->getClientID()) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <label for="name">Marca</label>
                        <input type="text" class="form-control" name="brand" id="brand" value="<?php echo $vehicle->getBrand(); ?>" maxlength="20" required="required">
                    </div>
                    <div class="form-group col-sm">
                        <label for="surname1">Modelo</label>
                        <input type="text" class="form-control" name="model" id="model" value="<?php echo $vehicle->getModel(); ?>" maxlength="50" required="required">
                    </div>
                    <div class="form-group col-1">
                        <label for="surname2">Año</label>
                        <input type="text" class="form-control" name="year" id="year" value="<?php echo $vehicle->getYear(); ?>" maxlength="4" required="required">
                    </div>
                    <div class="form-group col-2">
                        <label for="address">Color</label>
                        <input type="text" class="form-control" name="color" id="color" value="<?php echo $vehicle->getColor(); ?>" maxlength="10" required="required">
                    </div>
                    
                </div>  
                <div class="row mt-2">
                    <div class="form-group col-sm">
                        <button type="submit" formaction="delete_element.php?" class="btn btn-danger btn-block" name="delete_vehicle" onClick="return confirm('¿Estás segur@ de que quieres eliminar este vehículo de la base de datos?');">Eliminar vehículo</button>
                    </div>
                    <div class="form-group col-sm">
                        <button type="submit" class="btn btn-dark btn-block" name="edit_client">Editar vehículo</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>