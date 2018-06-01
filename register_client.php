<?php
	
	include "classes/database.php";
    include "classes/client_class.php";
    include "classes/vehicle_class.php";
    include "util/util.php";

    controlAccess();
    
    $db = Database::getInstance();

    $imageError = false;

    // Insertar nuevo cliente
    if (isset($_POST['add_client'])){
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

        if (is_uploaded_file($_FILES["photo"]["tmp_name"])) {
            $uploaded_photo = $_FILES["photo"]["tmp_name"];

            // Formatos de imagen soportados
            switch (exif_imagetype($_FILES["photo"]["tmp_name"])) {
                case IMAGETYPE_JPEG:
                    $created_photo = imagecreatefromjpeg($uploaded_photo);
                    
                    ob_start();
                    
                    imagejpeg($created_photo);
                    
                    $photo = ob_get_contents();
                    
                    ob_end_clean();
                    
                    $photo = str_replace('##', '\##', $db->real_escape_string($photo));
                    break;

                case IMAGETYPE_PNG:
                    $created_photo = imagecreatefrompng($uploaded_photo);
                    
                    ob_start();
                    
                    imagepng($created_photo);
                    
                    $photo = ob_get_contents();
                    
                    ob_end_clean();
                    
                    $photo = str_replace('##', '\##', $db->real_escape_string($photo));
                    break;

                default:
                    $imageError = true;
                    break;
            }
        }

        // Si no ha habido ningún error se inserta el nuevo cliente, evaluando si se ha subido una foto o no
        if (!$imageError) {
            if (isset($uploaded_photo)) {
                $insert_query = "INSERT INTO CLIENTES VALUES ('$dni', '$name', '$surname1', '$surname2', '$address', '$postal_code', '$location', '$province', '$telephone', '$email', '$photo')";
            } else {
                $insert_query = "INSERT INTO CLIENTES (dni, nombre, apellido1, apellido2, direccion, cp, poblacion, provincia, telefono, email) VALUES ('$dni', '$name', '$surname1', '$surname2', '$address', '$postal_code', '$location', '$province', '$telephone', '$email')";
            }

            $db->conn()->query($insert_query);
            header("Location: client_list.php");
        }
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

        <div class="container" style="margin-top: 15px">
            <h1>Nuevo cliente</h1>
            <hr>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-3 text-left">
                        <div class="image-upload">
                            <label for="photo">
                                <img class="client-img-big clickable" src="resources/img/no_photo.jpg" id="avatar" name="avatar" />
                            </label>
                            <input type="file" name="photo" id="photo" onChange="showNewPhoto(this);"/>
                        </div>
                    </div>
                    <div class="form-group col-9">
                        <div class="row">
                            <div class="form-group col-2">
                                <label for="id">ID</label>
                                <input type="text" class="form-control" name="id_disabled" value="<?php echo $db->getNewClientID(); ?>" disabled>
                            </div>
                            <div class="form-group col-2">
                                <label for="dni">DNI*</label>
                                <input type="text" class="form-control" name="dni" maxlength="9" required="required">
                            </div>
                            <div class="form-group col-sm">
                                <label for="email">E-mail*</label>
                                <input type="text" class="form-control" name="email" maxlength="50" required="required">
                            </div>
                            <div class="form-group col-sm">
                                <label for="telephone">Teléfono*</label>
                                <input type="text" class="form-control" name="telephone" maxlength="15" required="required">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm">
                                <label for="name">Nombre*</label>
                                <input type="text" class="form-control" name="name" id="name" maxlength="30" required="required">
                            </div>
                            <div class="form-group col-sm">
                                <label for="surname1">Primer apellido*</label>
                                <input type="text" class="form-control" name="surname1" id="surname1" maxlength="30" required="required">
                            </div>
                            <div class="form-group col-sm">
                                <label for="surname2">Segundo apellido*</label>
                                <input type="text" class="form-control" name="surname2" id="surname2" maxlength="30" required="required">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="address">Dirección*</label>
                                <input type="text" class="form-control" name="address" maxlength="50" required="required">
                            </div>
                            <div class="form-group col-2">
                                <label for="postal_code">Codigo postal*</label>
                                <input type="text" class="form-control" name="postal_code" maxlength="5" required="required">
                            </div>
                            <div class="form-group col-3">
                                <label for="location">Población*</label>
                                <input type="text" class="form-control" name="location" maxlength="30" required="required">
                            </div>
                            <div class="form-group col-3">
                                <label for="province">Provincia*</label>
                                <input type="text" class="form-control" name="province" maxlength="30" required="required">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <button type="submit" formaction="register_client.php?" class="btn btn-dark btn-block" name="add_client">Registrar nuevo cliente</button>
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