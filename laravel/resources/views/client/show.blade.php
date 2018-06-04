<!DOCTYPE html>
<html lang="es">
    <head>
        <base href="/practica2/">
		<link rel="stylesheet" type="text/css" href="resources/style/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="resources/style/custom.css" />
	</head>
    <body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a class="navbar-brand" href="index.php">Taller</a>
			<div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2" id="navbarNav">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link active" href="client_list.php">Clientes</a>
                    </li>
					<li class="nav-item">
						<a class="nav-link" href="vehicle_list.php">Vehículos</a>
					</li>
                    <li class="nav-item">
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
            <h1>Editar cliente</h1>
            <hr>
            
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="target" value="client">
                <div class="row">
                    <div class="form-group col-3 text-left">
                        <img class="client-img-big" src="<?php echo $client->fotografia ? 'data:image/jpeg;base64,'.base64_encode($client->fotografia) : 'resources/img/no_photo_client.jpg' ?>" />
                    </div>
                    <div class="form-group col-9 align-middle">
                        <div class="row">
                            <div class="form-group col-2">
                                <label for="id">ID</label>
                                <input type="text" class="form-control" name="id_disabled" value="{{$client->id_cliente}}" disabled>
                            </div>
                            <div class="form-group col-2">
                                <label for="dni">DNI*</label>
                                <input type="text" class="form-control" name="dni" value="{{$client->dni}}" maxlength="9" required="required" disabled>
                            </div>
                            <div class="form-group col-sm">
                                <label for="email">E-mail*</label>
                                <input type="text" class="form-control" name="email" value="{{$client->email}}" maxlength="50" required="required" disabled>
                            </div>
                            <div class="form-group col-4">
                                <label for="telephone">Teléfono*</label>
                                <input type="text" class="form-control" name="telephone" value="{{$client->telefono}}" maxlength="15" required="required" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm">
                                <label for="name">Nombre*</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{$client->nombre}}" maxlength="30" required="required" disabled>
                            </div>
                            <div class="form-group col-sm">
                                <label for="surname1">Primer apellido*</label>
                                <input type="text" class="form-control" name="surname1" id="surname1" value="{{$client->apellido1}}" maxlength="30" required="required" disabled>
                            </div>
                            <div class="form-group col-sm">
                                <label for="surname2">Segundo apellido*</label>
                                <input type="text" class="form-control" name="surname2" id="surname2" value="{{$client->apellido2}}" maxlength="30" required="required" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm">
                                <label for="address">Dirección*</label>
                                <input type="text" class="form-control" name="address" value="{{$client->direccion}}" maxlength="50" required="required" disabled>
                            </div>
                            <div class="form-group col-2">
                                <label for="postal_code">Codigo postal*</label>
                                <input type="text" class="form-control" name="postal_code" value="{{$client->cp}}" maxlength="5" required="required" disabled>
                            </div>
                            <div class="form-group col-3">
                                <label for="location">Población*</label>
                                <input type="text" class="form-control" name="location" value="{{$client->poblacion}}" maxlength="30" required="required" disabled>
                            </div>
                            <div class="form-group col-3">
                                <label for="province">Provincia*</label>
                                <input type="text" class="form-control" name="province" value="{{$client->provincia}}" maxlength="30" required="required" disabled>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </body>
</html>