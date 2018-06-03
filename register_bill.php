<?php
	
	include "classes/database.php";
    include "classes/client_class.php";
    include "classes/vehicle_class.php";
    include "classes/replacement_class.php";
    include "util/util.php";

    controlAccess();
    
    $db = Database::getInstance();

    // Crear factura
    if (isset($_POST['add_bill'])){

        // Factura
        $id = $db->getNewBillID();
        $plateID = $_POST['selectVehicleList'];
        $plate = Vehicle::parseVehicle($db->conn()->query("SELECT * FROM vehiculos WHERE id_vehiculo = $plateID"))->getPlate();
        $hours = $_POST['hours'];
        $cph = $_POST['cph'];
        $workPrice = $_POST['workPrice'];
        $creationDate = $_POST['creationDate'];
        $payedDate = $_POST['payedDate'];
        $base = $_POST['base'];
        $iva = $_POST['iva'];
        $total = $_POST['total'];

        // Líneas de factura
        $replacementListValue = $_POST['selectReplacementList'];
        $units = $_POST['units'];
        $amount = $_POST['amount'];

        // Se sacan los nombres de cada pieza añadida a la factura
        for ($i = 0; $i < count($replacementListValue); $i++) {
            $replacementListName[$i] = Replacement::parseReplacement($db->conn()->query("SELECT * FROM repuestos WHERE id_repuesto = $replacementListValue[$i]"))->getRef();
        }

        // Se inserta primero la factura
        $db->conn()->query("INSERT INTO factura VALUES ($id, '$plate', $hours, $cph, $workPrice,'$creationDate', '$payedDate', $base, $iva, $total)");

        // Se van insertando todas las líneas de detalle de la factura en un bucle
        for ($i = 0; $i < count($replacementListValue); $i++){
            $db->conn()->query("INSERT INTO detalle_factura (numero_factura, referencia, unidades, subtotal) VALUES ($id, '$replacementListName[$i]', $units[$i], $amount[$i])");
        }

        header("Location: bill_list.php");
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
                quantity.innerHTML += "<input type='hidden' id='rep" + currentLine + "_hAmount' name='amount[]' value='0'>";

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
            <h1>Crear una factura</h1>
            <hr>
            
            <form id="createBill" method="POST">
                <div class="row">
                    <div class="form-group col-1">
                        <label for="id_disabled">ID</label>
                        <input type="text" class="form-control" id="id_disabled" name="id_disabled" value="<?php echo $db->getNewBillID(); ?>" disabled>
                    </div>
                    <div class="form-group col-2">
                        <?php echo $db->getVehicleList(); ?>
                    </div>
                    <div class="form-group col-2">
                        <label for="hours">Horas*</label>
                        <input type="number" class="form-control" name="hours" id="hours" min="0" maxlength="4" onInput="calcWorkPrice();" required="required">
                    </div>
                    <div class="form-group col-2">
                        <label for="cph">Precio por hora*</label>
                        <input type="number" class="form-control" name="cph" id="cph" step="0.5" maxlength="6" onInput="calcWorkPrice();" required="required">
                    </div>
                    <div class="form-group col-sm">
                        <label for="creationDate">Fecha de emisión*</label>
                        <input type="date" class="form-control" name="creationDate" id="creationDate" required="required">
                    </div>
                    <div class="form-group col-sm">
                        <label for="payedDate">Fecha de pago*</label>
                        <input type="date" class="form-control" name="payedDate" id="payedDate" required="required">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm">
                        <label for="base">Mano de obra</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="workPrice" id="workPrice" value="0" readonly>
                            <div class="input-group-append">
                                <div class="input-group-text">€</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm">
                        <label for="base">Base imponible</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="base" id="base" value="0" readonly>
                            <div class="input-group-append">
                                <div class="input-group-text">€</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm">
                        <label for="iva">I.V.A. (21%)</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="iva" id="iva" value="0" readonly>
                            <div class="input-group-append">
                                <div class="input-group-text">€</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm">
                        <label for="total">Total</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="total" id="total" value="0" readonly>
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

                            </thead>
                            <tbody id="billLines">

                            </tbody>
                        </table>
                        <div id="add_bill"></div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>