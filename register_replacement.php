<?php
	
	include "classes/database.php";
    include "classes/client_class.php";
    include "util/util.php";

    controlAccess();
    
    $db = Database::getInstance();

    $imageError = false;

    // Insertar nuevo repuesto
    if (isset($_POST['add_replacement'])){
        $reference = $_POST['reference'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $percent = $_POST['percent'];
        $photo = "";

        // Si el usuario ha subido una foto
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
                    
                    $photo = str_replace('##', '\##', $db->conn()->real_escape_string($photo));
                    break;

                case IMAGETYPE_PNG:
                    $created_photo = imagecreatefrompng($uploaded_photo);
                    
                    ob_start();
                    
                    imagepng($created_photo);
                    
                    $photo = ob_get_contents();
                    
                    ob_end_clean();
                    
                    $photo = str_replace('##', '\##', $db->conn()->real_escape_string($photo));
                    break;

                default:
                    $imageError = true;
                    break;
            }
        }

        // Si no ha habido ningún error con la foto se insertar el nuevo repuesto, evaluando si se ha subido una foto o no
        if (!$imageError) {
            $insert_query = "INSERT INTO REPUESTOS (REFERENCIA, DESCRIPCION, IMPORTE, PORCENTAJE, FOTOGRAFIA) VALUES ('$reference', '$description', '$price', '$percent', '$photo')";

            $db->conn()->query($insert_query);
            header("Location: replacement_list.php");
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
					<li class="nav-item">
						<a class="nav-link" href="client_list.php">Clientes</a>
                    </li>
                    <li class="nav-item">
						<a class="nav-link" href="vehicle_list.php">Vehículos</a>
					</li>
                    <li class="nav-item active">
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
            <h1>Registrar una nueva pieza de repuesto</h1>
            <hr>
            
            <form method="POST" enctype="multipart/form-data">
            <div class="row">
                    <div class="form-group col-3 text-left">
                        <div class="image-upload">
                            <label for="photo">
                                <img class="client-img-big clickable" src="resources/img/no_photo_product.jpg" id="avatar" name="avatar" />
                            </label>
                            <input type="file" name="photo" id="photo" onChange="showNewPhoto(this);"/>
                        </div>
                    </div>
                    <div class="form-group col-9 align-middle">
                        <div class="row">
                            <div class="form-group col-2">
                                <label for="id_disabled">ID</label>
                                <input type="text" class="form-control" name="id_disabled" id="id_disabled" value="<?php echo $db->getNewReplacementID(); ?>" disabled>
                            </div>
                            <div class="form-group col-sm">
                                <label for="reference">Referencia*</label>
                                <input type="text" class="form-control" name="reference" id="reference" maxlength="10" required="required">
                            </div>
                            <div class="form-group col-sm">
                                <label for="price">Importe*</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="price" id="price" maxlength="11" required="required">
                                    <div class="input-group-append">
                                        <div class="input-group-text">€</div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group col-sm">
                                <label for="percent">Porcentaje*</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="percent" id="percent" min="0" max="100" required="required">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm">
                                <label for="description">Descripción*</label>
                                <input type="text" class="form-control" name="description" id="description" maxlength="50" required="required">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <button type="submit" class="btn btn-dark btn-block" name="add_replacement">Registrar nueva pieza</button>
                    </div>
                </div>
            </form>
            <?php

                if ($imageError) {
                    
            ?>
            <div class="alert alert-danger" role="alert" style="margin-top: 1.5em; margin-bottom: 2em;">
                <h4 class="mb-0">Error al editar la información de la pieza.</h4>
                <p class="mb-0">Formato de imagen no soportado.</p>
            </div>
            <?php
            
                }

            ?>
        </div>
    </body>
</html>