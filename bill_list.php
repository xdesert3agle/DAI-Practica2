<?php
	
	include "classes/database.php";
	include "classes/client_class.php";
	include "classes/vehicle_class.php";
	include "classes/replacement_class.php";
	include "util/util.php";

	controlAccess();

	$db = Database::getInstance();

	$bill_list = $db->conn()->query("SELECT * FROM factura");

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
                    <li class="nav-item" style="margin-top: 6px">
                        <a href="logout.php">
                            <img src="resources/img/logout.png" width="20" height="20" alt="Logout">
                        </a>
                    </li>
				</ul>
			</div>
		</nav>
		<div class="container">
            <form action="delete_element.php" method="POST" class="pt-0 mt-0">
                <input type='hidden' id='action' name='action' value='user_delete'>
                <input type="hidden" name="target" value="bill">
                <table class="table table-hover no-top-thead">
                    <thead>
                    <tr>
                        <th colspan="5">
                            <h1>Listado de facturas</h1>
                        </th>
                        <th colspan="8" class="text-right">
                            <form action="" method="POST" class="p-0 m-0">
                                <input type="hidden" id="client_id" name="client_id" value="<?php echo $bill['id_cliente']?>" />
                                <button type="submit" class="btn btn-danger btn-sm" value="delete_selected" onClick="return confirm('¿Estás segur@ de que quieres eliminar los coches seleccionados de la base de datos?');">Eliminar seleccionados</button>
                            </form>
                            <a href="register_bill.php" class="btn btn-dark btn-sm" value="add_new">Añadir nueva</a>
                        </th>
                    </tr>
                    </thead>
                    <thead class="thead-light">
                        <tr>
                            <th></th>
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
                    <tbody>
                    <?php

                    for ($i = 0; $i < mysqli_num_rows($bill_list); $i++) {
                        $bill = $bill_list->fetch_assoc();

                        ?>

                        <!-- El onClick va en todas las columnas menos en la de la checkbox para evitar missclicks -->
                        <tr>
                            <td class="align-middle">
                                <input type="checkbox" name="id[]" value="<?php echo $bill['numero_factura'] ?>" onClick="stopCheckbox(this);"/>
                            </td>
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
                        <?php

                    }

                    ?>
                    </tbody>
                </table>
            </form>
        </div>
	</body>
</html>