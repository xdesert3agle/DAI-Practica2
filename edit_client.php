<?php
	
	include('dbconnection.php');
    include('client_class.php');
    include('vehicle_class.php');
    include('util.php');

	controlAccess();
    
    if (isset($_GET['client_id'])) {
        $selClientID = $_GET['client_id'];

        $client = Client::getClientWithID($selClientID);
    }

    $imageError = false;

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
            header("Location: client_list.php");
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
					<li class="nav-item active">
						<a class="nav-link" href="client_list.php">Gestión de clientes</a>
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

        <div class="container" style="margin-top: 15px">
            <h1>Editar cliente</h1>
            <hr>
            
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id[]" value="<?php echo $client->getId(); ?>">
                <input type="hidden" name="target" value="client">
                <div class="row">
                    <div class="form-group col-3 text-left">
                        <div class="image-upload">
                            <label for="photo">
                                <img class="client-img-big clickable" src="<?php echo $client->getPhoto()?>" id="avatar" name="avatar" />
                            </label>
                            <input type="file" name="photo" id="photo" onChange="showNewPhoto(this);"/>
                        </div>
                    </div>
                    <div class="form-group col-9 align-middle">
                        <div class="row">
                            <div class="form-group col-2">
                                <label for="id">ID</label>
                                <input type="text" class="form-control" name="id_disabled" value="<?php echo $client->getId(); ?>" disabled>
                            </div>
                            <div class="form-group col-2">
                                <label for="dni">DNI*</label>
                                <input type="text" class="form-control" name="dni" value="<?php echo $client->getDni(); ?>" maxlength="9" required="required">
                            </div>
                            <div class="form-group col-sm">
                                <label for="email">E-mail*</label>
                                <input type="text" class="form-control" name="email" value="<?php echo $client->getEmail(); ?>" maxlength="50" required="required">
                            </div>
                            <div class="form-group col-4">
                                <label for="telephone">Teléfono*</label>
                                <input type="text" class="form-control" name="telephone" value="<?php echo $client->getTelephone(); ?>" maxlength="15" required="required">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm">
                                <label for="name">Nombre*</label>
                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $client->getName(); ?>" maxlength="30" required="required">
                            </div>
                            <div class="form-group col-sm">
                                <label for="surname1">Primer apellido*</label>
                                <input type="text" class="form-control" name="surname1" id="surname1" value="<?php echo $client->getSurname1(); ?>" maxlength="30" required="required">
                            </div>
                            <div class="form-group col-sm">
                                <label for="surname2">Segundo apellido*</label>
                                <input type="text" class="form-control" name="surname2" id="surname2" value="<?php echo $client->getSurname2(); ?>" maxlength="30" required="required">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm">
                                <label for="address">Dirección*</label>
                                <input type="text" class="form-control" name="address" value="<?php echo $client->getAddress(); ?>" maxlength="50" required="required">
                            </div>
                            <div class="form-group col-2">
                                <label for="postal_code">Codigo postal*</label>
                                <input type="text" class="form-control" name="postal_code" value="<?php echo $client->getPostalCode(); ?>" maxlength="5" required="required">
                            </div>
                            <div class="form-group col-3">
                                <label for="location">Población*</label>
                                <input type="text" class="form-control" name="location" value="<?php echo $client->getLocation(); ?>" maxlength="30" required="required">
                            </div>
                            <div class="form-group col-3">
                                <label for="province">Provincia*</label>
                                <input type="text" class="form-control" name="province" value="<?php echo $client->getProvince(); ?>" maxlength="30" required="required">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <button type="submit" class="btn btn-dark btn-block" name="edit_client">Editar datos del cliente</button>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <button type="submit" formaction="delete_element.php?" class="btn btn-danger btn-block" name="delete_element" onClick="return confirm('¿Estás segur@ de que quieres eliminar este cliente de la base de datos?');">Eliminar cliente</button>
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