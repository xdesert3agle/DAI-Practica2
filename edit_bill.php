<?php
	
	include "classes/database.php";
    include "classes/client_class.php";
    include "classes/vehicle_class.php";
    include "classes/replacement_class.php";
    include "util/util.php";

    controlAccess();

    $db = Database::getInstance();
    
    if (isset($_GET['bill_id'])) {
        $selBillID = $_GET['bill_id'];
        $bill = $db->conn()->query("SELECT * FROM factura WHERE numero_factura = $selBillID")->fetch_assoc();
    }

    // Botón de editar vehículo
    if (isset($_POST['edit_bill'])){
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
        <script src="./resources/js/math.js"></script>
        <script type="text/javascript">
            function addNewLine(){
                let table = document.getElementById('billLines');
                let row = table.insertRow(table.rows.length);

                let replacement = row.insertCell(0);
                let quantity = row.insertCell(1);
                let price = row.insertCell(2);
                let gainPercent = row.insertCell(3);
                let subtotal = row.insertCell(4);

                let currentLine = table.rows.length;
                let headers = document.getElementById('headers');

                if (currentLine === 1) {
                    console.log("headers");
                    headers.innerHTML = "<tr><th>Pieza de repuesto</th><th>Cantidad</th><th>Precio</th><th>Porcentaje de ganancia</th><th>Importe</th></tr>";
                }

                replacement.innerHTML = "<?php echo $db->getReplacementListAsArray() ?>";

                let newSelect = document.getElementById('selectReplacementList');
                newSelect.id = 'selectReplacementList' + currentLine;
                newSelect.setAttribute("data-row", currentLine);

                quantity.innerHTML = "<input type='number' class='form-control' name='units[]' id='units" + currentLine + "' data-row='" + currentLine + "' value='0' onInput='calcLinePrice(this); doTheMath();' required>";
                quantity.innerHTML += "<input type='hidden' id='row" + currentLine + "_price'>";

                price.classList.add("align-middle");
                price.id = "rep" + currentLine + "_price";
                price.innerHTML = newSelect.options[newSelect.selectedIndex].getAttribute('data-price') + " €";

                subtotal.classList.add("align-middle");
                subtotal.id = "rep" + currentLine + "_amount";
                subtotal.innerHTML = "0 €";

                gainPercent.classList.add("align-middle");
                gainPercent.id = "rep" + currentLine + "_percent";
                gainPercent.innerHTML = newSelect.options[newSelect.selectedIndex].getAttribute('data-percent') + " %";

                if (currentLine === 1){
                    document.getElementById('add_bill').innerHTML += "<button type='submit' class='btn btn-primary' style='margin-left: -2px;' form='createBill' name='add_bill' id='btnCreateBill'>Crear factura</button>";
                }
            }
        </script>
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

        <div class="container" style="margin-top: 15px">
            <h1>Modificar factura</h1>
            <hr>

            <form id="createBill" method="POST">
                <div class="row">
                    <div class="form-group col-1">
                        <label for="id_disabled">ID</label>
                        <input type="text" class="form-control" id="id_disabled" name="id_disabled" value="<?php echo $bill['numero_factura']; ?>" disabled>
                    </div>
                    <div class="form-group col-2">
                        <?php echo $db->getVehicleList($bill['matricula']); ?>
                    </div>
                    <div class="form-group col-2">
                        <label for="hours">Horas*</label>
                        <input type="number" class="form-control" name="hours" id="hours" min="0" maxlength="4" onInput="calcWorkPrice();" value="<?php echo $bill['horas'] ?>" required="required">
                    </div>
                    <div class="form-group col-2">
                        <label for="cph">Precio por hora*</label>
                        <input type="number" class="form-control" name="cph" id="cph" step="0.5" maxlength="6" onInput="calcWorkPrice();" value="<?php echo $bill['precio_hora'] ?>" required="required">
                    </div>
                    <div class="form-group col-sm">
                        <label for="creationDate">Fecha de emisión*</label>
                        <input type="date" class="form-control" name="creationDate" id="creationDate" value="<?php echo $bill['fecha_emision'] ?>" required="required">
                    </div>
                    <div class="form-group col-sm">
                        <label for="payedDate">Fecha de pago*</label>
                        <input type="date" class="form-control" name="payedDate" id="payedDate" value="<?php echo $bill['fecha_pago'] ?>" required="required">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm">
                        <label for="base">Mano de obra</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="workPrice" id="workPrice" value="<?php echo $bill['mano_obra'] ?>" readonly>
                            <div class="input-group-append">
                                <div class="input-group-text">€</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm">
                        <label for="base">Base imponible</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="base" id="base" value="<?php echo $bill['base_imponible'] ?>" readonly>
                            <div class="input-group-append">
                                <div class="input-group-text">€</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm">
                        <label for="iva">I.V.A. (21%)</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="iva" id="iva" value="<?php echo $bill['iva'] ?>" readonly>
                            <div class="input-group-append">
                                <div class="input-group-text">€</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm">
                        <label for="total">Total</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="total" id="total" value="<?php echo $bill['total'] ?>" readonly>
                            <div class="input-group-append">
                                <div class="input-group-text">€</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm">
                        <table class="table no-top-thead" style="margin-left: -13px;">
                            <thead>
                            <tr>
                                <th>
                                    <h1>Líneas de factura</h1>
                                </th>
                                <th class="text-right" colspan="99">
                                    <a class="btn btn-primary" name="add_vehicle" onClick="addNewLine();">Añadir línea</a>
                                </th>
                            </tr>
                            </thead>
                            <thead id="headers">
                                <tr>
                                    <th>Pieza de repuesto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Porcentaje de ganancia</th>
                                    <th>Importe</th>
                                </tr>
                            </thead>
                            <tbody id="billLines">
                            <?php

                                $id = $bill['numero_factura'];

                                $lineCount = $db->conn()->query("SELECT COUNT(*) AS LINE_COUNT FROM detalle_factura WHERE numero_factura = $id")->fetch_assoc()['LINE_COUNT'];

                                for ($i = 0; $i < $lineCount; $i++) {
                                    $line = $db->conn()->query("SELECT * FROM detalle_factura WHERE numero_factura = $id")->fetch_assoc();
                                    $replacementRef = $line['referencia'];
                                    $replacement = Replacement::parseReplacement($db->conn()->query("SELECT * FROM repuestos WHERE referencia = '$replacementRef'"));
                            ?>
                                    <tr>
                                        <td>
                                            <?php echo $db->getReplacementListAsArray($line['referencia']); ?>
                                        </td>
                                        <td>
                                            <input type='number' class='form-control' name='units[]' id='units<?php echo $i ?>' data-row='<?php echo $i ?>' value="<?php echo $line['unidades'] ?>" onInput='calcLinePrice(this); doTheMath();' required>
                                            <input type="hidden" id='row<?php echo $i ?>_price'>
                                        </td>
                                        <td class="align-middle" id="rep<?php echo $i ?>_price">
                                            <?php echo $replacement->getPrice() . " €" ?>
                                        </td>
                                        <td class="align-middle" id="rep<?php echo $i ?>_percent">
                                            <?php echo $replacement->getPercent() . " %" ?>
                                        </td>
                                        <td class="align-middle" id="rep<?php echo $i ?>_amount">
                                            <?php echo $replacement->getPercent() . " %" ?>
                                        </td>
                                    </tr>

                            <?php

                                }

                            ?>
                            </tbody>
                        </table>
                        <div id="add_bill"></div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>