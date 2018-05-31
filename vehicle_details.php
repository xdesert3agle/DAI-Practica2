<?php
	
	include('dbconnection.php');
    include('client_class.php');
    include('vehicle_class.php');
    include('util.php');

	if (!isLogged()) {
		header("Location: login.php");
	}
    
    if (isset($_GET['vehicle_id'])) {
        $selVehicleID = $_GET['vehicle_id'];
        $vehicle = Vehicle::getVehicleWithID($selVehicleID);
    }

    // Botón de editar cliente
    if (isset($_POST['edit_client'])){
        $id = $_POST['id'][0];
        $dni = $_POST['dni'];
        $name = $_POST['name'];
        $surname1 = $_POST['surname1'];
        $surname2 = $_POST['surname2'];
        $address = $_POST['address'];
        $postal_code = $_POST['postal_code'];
        $location = $_POST['location'];
        $province = $_POST['province'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];

        // Si el usuario ha subido una foto
        if (is_uploaded_file($_FILES["photo"]["tmp_name"])) {
            $uploaded_photo = $_FILES["photo"]["tmp_name"];

            // Formatos de imagen soportados: JPG, PNG.
            switch (exif_imagetype($_FILES["photo"]["tmp_name"])) {
                case IMAGETYPE_JPEG:
                    $created_photo = imagecreatefromjpeg($uploaded_photo);
                    
                    ob_start();
                    
                    imagejpeg($created_photo);
                    
                    $photo = ob_get_contents();
                    
                    ob_end_clean();
                    
                    $photo = str_replace('##', '\##', $conn->real_escape_string($photo));
                    break;

                case IMAGETYPE_PNG:
                    $created_photo = imagecreatefrompng($uploaded_photo);
                    
                    ob_start();
                    
                    imagepng($created_photo);
                    
                    $photo = ob_get_contents();
                    
                    ob_end_clean();
                    
                    $photo = str_replace('##', '\##', $conn->real_escape_string($photo));
                    break;

                default:
                    $imageError = true;
                    break;
            }
        }

        // Si no ha habido ningún error con la foto se actualizan los datos del cliente, evaluando si se ha subido una foto o no
        if (!$imageError) {
            if (isset($uploaded_photo)) {
                $update_query = "UPDATE CLIENTES SET dni = '$dni', nombre ='$name', apellido1 ='$surname1', apellido2 = '$surname2', direccion ='$address', cp = '$postal_code', poblacion ='$location', provincia = '$province', telefono = '$telephone', email = '$email', fotografia = '$photo' WHERE id_cliente = '$id'";
            } else {
                $update_query = "UPDATE CLIENTES SET dni = '$dni', nombre ='$name', apellido1 ='$surname1', apellido2 = '$surname2', direccion ='$address', cp = '$postal_code', poblacion ='$location', provincia = '$province', telefono = '$telephone', email = '$email' WHERE id_cliente = '$id'";
            }

            $conn->query($update_query);
            header("Location: clients.php");
        }
    }

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
						<a class="nav-link" href="clients.php">Gestión de clientes</a>
					<li class="nav-item active">
						<a class="nav-link" href="vehicles.php">Gestión de vehículos</a>
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
            <h1>Editar vehículo</h1>
            <hr>

            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id[]" value="<?php echo $vehicle->getId(); ?>">
                <div class="row">
                    <div class="form-group col-sm">
                        <label for="id">ID</label>
                        <input type="text" class="form-control" name="id_disabled" value="<?php echo $vehicle->getId(); ?>" disabled>
                    </div>
                    <div class="form-group col-sm">
                        <label for="plate">Matrícula</label>
                        <input type="text" class="form-control" name="plate" id="plate" value="<?php echo $vehicle->getPlate(); ?>" maxlength="10" required="required">
                    </div>
                    <div class="form-group col-sm">
                        <label for="location">Propietario</label>
                        <select class="form-control" name="selectOwnerList">
                        
                        <?php
                        $clientList = $conn->query("SELECT * FROM CLIENTES");

                        $client = new Client;
                        
                        for ($i = 0; $i < mysqli_num_rows($clientList); $i++) {
                            $client = Client::parseClient($clientList);
                        ?>
                            <option value="<?php echo $client->getId(); ?>"><?php echo "#" . $client->getID() . " - " . $client->getName() ?></option>
                        
                        <?php
                        
                        }

                        ?>
                        </select>
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
                        <button type="submit" class="btn btn-danger btn-block" name="delete_client">Eliminar vehículo</button>
                    </div>
                    <div class="form-group col-sm">
                        <button type="submit" class="btn btn-dark btn-block" name="edit_client">Editar vehículo</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>