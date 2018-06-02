<?php
	
	include "classes/database.php";
    include "classes/replacement_class.php";
    include "util/util.php";

    controlAccess();
    
    $db = Database::getInstance();
    
    if (isset($_GET['replacement_id'])) {
        $selReplacementID = $_GET['replacement_id'];
        $replacement = $db->getReplacementWithID($selReplacementID);
    }

    $imageError = false;

    // Botón de editar vehículo
    if (isset($_POST['edit_client'])){
        $id = $_POST['id'][0];
        $reference = $_POST['reference'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $percent = $_POST['percent'];

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

        // Si no ha habido ningún error con la foto se actualizan los datos del cliente, evaluando si se ha subido una foto o no
        if (!$imageError) {
            if (isset($uploaded_photo)) {
                $update_query = "UPDATE REPUESTOS SET ID_REPUESTO = '$id', REFERENCIA ='$reference', DESCRIPCION ='$description', IMPORTE = '$price', PORCENTAJE ='$percent', FOTOGRAFIA = '$photo' WHERE ID_REPUESTO = '$id'";
            } else {
                $update_query = "UPDATE REPUESTOS SET ID_REPUESTO = '$id', REFERENCIA ='$reference', DESCRIPCION ='$description', IMPORTE = '$price', PORCENTAJE ='$percent' WHERE ID_REPUESTO = '$id'";
            }

            $db->conn()->query($update_query);
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
				</ul>
			</div>
		</nav>

        <div class="container" style="margin-top: 15px">
            <h1>Editar repuesto</h1>
            <hr>

            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id[]" value="<?php echo $replacement->getId(); ?>">
                <input type="hidden" name="target" value="replacement">
                <div class="row">
                    <div class="form-group col-3 text-left">
                        <div class="image-upload">
                            <label for="photo">
                                <img class="client-img-big clickable" src="<?php echo $replacement->getPhoto()?>" id="avatar" name="avatar" />
                            </label>
                            <input type="file" name="photo" id="photo" onChange="showNewPhoto(this);"/>
                        </div>
                    </div>
                    <div class="form-group col-9 align-middle">
                        <div class="row">
                            <div class="form-group col-2">
                                <label for="id_disabled">ID</label>
                                <input type="text" class="form-control" name="id_disabled" id="id_disabled" value="<?php echo $replacement->getId(); ?>" disabled>
                            </div>
                            <div class="form-group col-sm">
                                <label for="reference">Referencia*</label>
                                <input type="text" class="form-control" name="reference" id="reference" value="<?php echo $replacement->getRef(); ?>" maxlength="10" required="required">
                            </div>
                            <div class="form-group col-sm">
                                <label for="price">Importe*</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="price" id="price" value="<?php echo $replacement->getPrice(); ?>" maxlength="11" required="required">
                                    <div class="input-group-append">
                                        <div class="input-group-text">€</div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group col-sm">
                                <label for="percent">Porcentaje*</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="percent" id="percent" value="<?php echo $replacement->getPercent(); ?>" min="0" max="100" required="required">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm">
                                <label for="description">Descripción*</label>
                                <input type="text" class="form-control" name="description" id="description" value="<?php echo $replacement->getDescription(); ?>" maxlength="50" required="required">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <button type="submit" class="btn btn-dark btn-block" name="edit_client">Editar datos del repuesto</button>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <button type="submit" formaction="delete_element.php?" class="btn btn-danger btn-block" name="delete_element" onClick="return confirm('¿Estás segur@ de que quieres eliminar este repuesto de la base de datos?');">Eliminar repuesto</button>
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