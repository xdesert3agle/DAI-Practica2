<?php
	
	include('dbconnection.php');
	include('client_class.php');
	include('util.php');

	if (!isLogged()) {
		header("Location: login.php");
	}
    
    if (isset($_GET['client_id'])) {
        $selClientID = $_GET['client_id'];

        $client = new Client($conn);
        $client = getClientWithID($selClientID);
    }

    if (isset($_GET['edit_client'])){
        $id = $_GET['id'];
        $dni = $_GET['dni'];
        $name = $_GET['name'];
        $surname1 = $_GET['surname1'];
        $surname2 = $_GET['surname2'];
        $address = $_GET['address'];
        $postal_code = $_GET['postal_code'];
        $location = $_GET['location'];
        $province = $_GET['province'];
        $telephone = $_GET['telephone'];
        $email = $_GET['email'];

        $conn->query("UPDATE CLIENTES SET dni ='" .$dni. "', nombre ='" .$name.  "', apellido1 ='" .$surname1. "', apellido2 = '" .$surname2 . "', direccion ='" .$address. "', cp = '" .$postal_code. "', poblacion ='" .$location. "', provincia = '" .$province. "', telefono ='" .$telephone. "', email ='" .$email. "' WHERE id_cliente = " .$id);
        
        header("Location: clients.php");

    } else {

?>

<html>
    <head>
		<link rel="stylesheet" type="text/css" href="./style/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="./style/custom.css" />
	</head>
    <body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
			<a class="navbar-brand" href="index.php">Taller</a>
			<div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2" id="navbarNav">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="clients.php">Gestión de clientes</a>
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
            <h2>Editar cliente</h2>
            <hr>
            <form action="delete_client.php" method="POST">
                <input type="hidden" name="id[]" value="<?php echo $client->getId(); ?>">
                <div class="row">
                    <div class="form-group col-sm">
                        <label for="id">ID</label>
                        <input type="text" class="form-control" name="id_disabled" value="<?php echo $client->getId(); ?>" disabled>
                    </div>
                    <div class="form-group col-sm">
                        <label for="dni">DNI</label>
                        <input type="text" class="form-control" name="dni" value="<?php echo $client->getDni(); ?>" maxlength="9">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm">
                        <label for="surname1">Apellido 1</label>
                        <input type="text" class="form-control" name="surname1" value="<?php echo $client->getSurname1(); ?>" maxlength="30">
                    </div>
                    <div class="form-group col-sm">
                        <label for="surname2">Apellido 2</label>
                        <input type="text" class="form-control" name="surname2" value="<?php echo $client->getSurname2(); ?>" maxlength="30">
                    </div>
                    <div class="form-group col-sm">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $client->getName(); ?>" maxlength="30">
                    </div>
                </div>  
                    
                <div class="row">
                    <div class="form-group col-sm">
                        <label for="address">Dirección</label>
                        <input type="text" class="form-control" name="address" value="<?php echo $client->getAddress(); ?>" maxlength="50">
                    </div>
                    <div class="form-group col-2">
                        <label for="postal_code">CP</label>
                        <input type="text" class="form-control" name="postal_code" value="<?php echo $client->getPostalCode(); ?>" maxlength="5">
                    </div>
                    <div class="form-group col-3">
                        <label for="location">Población</label>
                        <input type="text" class="form-control" name="location" value="<?php echo $client->getLocation(); ?>" maxlength="30">
                    </div>
                    <div class="form-group col-2">
                        <label for="province">Provincia</label>
                        <input type="text" class="form-control" name="province" value="<?php echo $client->getProvince(); ?>" maxlength="30">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm">
                        <label for="telephone">Teléfono</label>
                        <input type="text" class="form-control" name="telephone" value="<?php echo $client->getTelephone(); ?>" maxlength="15">
                    </div>
                    <div class="form-group col-sm">
                        <label for="email">E-mail</label>
                        <input type="text" class="form-control" name="email" value="<?php echo $client->getEmail(); ?>" maxlength="50">
                    </div>
                    <div class="form-group col-sm">
                        <button type="submit" class="btn btn-primary align-bottom" name="edit_client" style="margin-top: 31px; margin-left: 40px;">Editar cliente</button>
                        <button type="submit" class="btn btn-danger align-bottom float-right" name="delete_client" style="margin-top: 31px;">Eliminar cliente</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>

<?php

    }

?>