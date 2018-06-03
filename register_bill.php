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
        $plate = $_POST['selectVehicleList'];
        $hours = $_POST['hours'];
        $cph = $_POST['cph'];
        $creationDate = $_POST['creationDate'];
        $payedDate = $_POST['payedDate'];
        $base = $_POST['base'];
        $iva = $_POST['iva'];
        $total = $_POST['total'];

        // Líneas de factura
        $replacementList = $_POST['selectReplacementList'];
        $units = $_POST['units'];

        //$db->conn()->query("INSERT INTO factura (numero_factura, matricula, horas, precio_hora, fecha_emision, fecha_pago, base_imponible, iva, total) VALUES ('$id', '$plate', '$hours', '$cph', '$creationDate', '$payedDate'. '$base', '$iva', '$total')");

        echo "INSERT INTO factura (numero_factura, matricula, horas, precio_hora, fecha_emision, fecha_pago, base_imponible, iva, total) VALUES ('$id', '$plate', '$hours', '$cph', '$creationDate', '$payedDate'. '$base', '$iva', '$total')";

        for ($i = 0; $i < count($replacementList); $i++){
 //           $db->conn()->query("INSERT INTO factura (numero_factura, matricula, horas, precio_hora, fecha_emision, fecha_pago, base_imponible, iva, total) VALUES ('$id', '$plate', '$hours', '$cph', '$creationDate', '$payedDate'. '$base', '$iva', '$total')");
            echo "Producto: $replacementList[$i], cantidad: $units[$i] unidades.";
        }

        //$result = $db->conn()->query("INSERT INTO factura (numero_factura, matricula, horas, precio_hora, fecha_emision, fecha_pago, base_imponible, iva, total) VALUES ('$id', '$plate', '$hours', '$cph', '$creationDate', '$payedDate'. '$base', '$iva', '$total')");
        //header("Location: bill_list.php");
    }

?>
<html>
    <head>
		<link rel="stylesheet" type="text/css" href="./resources/style/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="./resources/style/custom.css" />
        <script src="./resources/js/lib.js"></script>
        <script type="text/javascript">
            function addNewLine(){
                let table = document.getElementById('billLines');
                let row = table.insertRow(table.rows.length);

                let replacement = row.insertCell(0);
                let quantity = row.insertCell(1);

                let currentLine = table.rows.length;

                replacement.innerHTML = "<?php echo $db->getReplacementListAsArray() ?>";

                let newSelect = document.getElementById('selectReplacementList');
                newSelect.id = 'selectReplacementList' + currentLine;

                quantity.innerHTML = "<label for='units'>Cantidad</label>" +
                    "<input type='number' class='form-control' name='units[]' id='units" + currentLine + "' data-row='" + currentLine + "' onInput='calcLinePrice(this); calcBase();' required>";

                quantity.innerHTML += "<input type='hidden' id='row" + currentLine + "_price'>";

                if (table.rows.length === 1){
                    document.getElementById('add_bill').innerHTML += "<button type='submit' class='btn btn-primary' style='margin-left: -2px;' form='createBill' name='add_bill' id='btnCreateBill'>Crear factura</button>";
                }
            }

            function calcLinePrice(changedElement){
                let changedRowNumber = changedElement.getAttribute('data-row');

                let selReplacementList = document.getElementById('selectReplacementList' + changedRowNumber);
                let selectedReplacementPrice = selReplacementList.options[selReplacementList.selectedIndex].getAttribute('data-price');

                let units = document.getElementById('units' + changedRowNumber);

                let changedRowPriceContainer = document.getElementById('row' + changedRowNumber + '_price');

                changedRowPriceContainer.value = parseInt(units.value) * parseInt(selectedReplacementPrice);
            }

            function calcBase(){
                let numberOfLines = document.getElementById('billLines').rows.length;
                let base = document.getElementById('base');
                let calc = 0;

                console.log("Numero de lineas: " + numberOfLines);

                for (let i = 1; i <= numberOfLines; i++){
                    calc += parseInt(document.getElementById('row' + i + "_price").value);
                }

                base.value = calc;
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
                        <input type="text" class="form-control" name="hours" id="hours" maxlength="2" required="required">
                    </div>
                    <div class="form-group col-2">
                        <label for="cph">Precio por hora*</label>
                        <input type="text" class="form-control" name="cph" id="cph" maxlength="3" required="required">
                    </div>
                    <div class="form-group col-sm">
                        <label for="creationDate">Fecha de emisión*</label>
                        <input type="text" class="form-control" name="creationDate" id="creationDate" maxlength="50" required="required">
                    </div>
                    <div class="form-group col-sm">
                        <label for="payedDate">Fecha de pago*</label>
                        <input type="text" class="form-control" name="payedDate" id="payedDate" maxlength="4" required="required">
                    </div>
                </div>
                <div class="row">
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
                        <label for="iva">I.V.A.</label>
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
                                <th class="text-right">
                                    <a class="btn btn-primary" name="add_vehicle" onClick="addNewLine();">Añadir línea</a>
                                </th>
                            </tr>
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