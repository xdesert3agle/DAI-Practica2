<?php
	
	include "classes/database.php";
	include "classes/client_class.php";
	include "classes/replacement_class.php";
	include "util/util.php";

	controlAccess();

	$db = Database::getInstance();

	$client_list = $db->conn()->query("SELECT * FROM FACTURA ORDER BY ID_CLIENTE");

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
					<li class="nav-item">
						<a class="nav-link" href="replacement_list.php">Repuestos</a>
					</li>
                    <li class="nav-item active">
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
			<div class="row">
                <div class="form-group">
                <?php echo $db->getReplacementList(); ?>
            </div>
		</div>
	</body>
</html>