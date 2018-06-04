<?php

    class Database {
        private static $instance = null;
        private $conn;
        private $db = "taller";
        private $host = "localhost";
        private $user = "root";
        private $pwd = "";
        
        const EMPTY_IMG = "";
  
        private function __construct() {
            $this->conn = new mysqli($this->host, $this->user, $this->pwd, $this->db);
        }
        
        public static function getInstance() {
            if (self::$instance == null) {
                self::$instance = new Database();
            }
        
            return self::$instance;
        }
        
        public function conn() {
            return $this->conn;
        }

// ------------------------------------------  M É T O D O S  S O B R E  L A  T A B L A  C L I E N T E S  ------------------------------------------

        // Devuelve el cliente con una determinada ID
        public function getClientWithID($id) {
            return Client::parseClient($this->conn()->query("SELECT * FROM CLIENTES WHERE ID_CLIENTE = $id"));
        }

        // Devuelve el ID que le corresponde a un hipotético nuevo cliente (el valor del autoincrement)
        public function getNewClientID() {
            $result = $this->conn()->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'taller' AND TABLE_NAME = 'CLIENTES'");
    
            return $result->fetch_assoc()['AUTO_INCREMENT'];
        }

// -----------------------------------------  M É T O D O S  S O B R E  L A  T A B L A  V E H I C U L O S  -----------------------------------------

        // Devuelve el vehículo con una determinada ID
        public function getVehicleWithID($id){
             return Vehicle::parseVehicle($this->conn()->query("SELECT * FROM VEHICULOS WHERE ID_VEHICULO = $id"));
        }

        // Devuelve el ID que le corresponde a un hipotético nuevo vehículo (el valor del autoincrement)
        public function getNewVehicleID(){
            return $this->conn()->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'taller' AND TABLE_NAME = 'VEHICULOS'")->fetch_assoc()['AUTO_INCREMENT'];
        }


// -----------------------------------------  M É T O D O S  S O B R E  L A  T A B L A  R E P U E S T O S  -----------------------------------------
        
        // Devuelve el vehículo con una determinada ID
        public function getReplacementWithID($id) {
            return Replacement::parseReplacement($this->conn()->query("SELECT * FROM REPUESTOS WHERE ID_REPUESTO = $id"));
        }

        // Devuelve el ID que le corresponde a un hipotético nuevo repuesto (el valor del autoincrement)
        public function getNewReplacementID() {
            $result = $this->conn()->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'taller' AND TABLE_NAME = 'REPUESTOS'");
    
            return $result->fetch_assoc()['AUTO_INCREMENT'];
        }


        public function getClientList($owner = -1) {
            $clientList = $this->conn()->query("SELECT * FROM clientes");

            $list = "<label for=\"selectOwnerList\">Dueño del vehículo</label>" .
                      "<select class=\"form-control\" name=\"selectOwnerList\" id=\"selectOwnerList\">";

            for ($i = 0; $i < mysqli_num_rows($clientList); $i++) {
                $client = Client::parseClient($clientList);
                $list .= "<option value='" . $client->getId() . "' " . ($client->getId() == $owner && $owner != -1 ? 'selected' : null) . ">" . "#" . $client->getID() . " - " . $client->getSurname1() . " " . $client->getSurname2() . " " . $client->getName() . "</option>";
            }

            $list .= "</select>";

            return $list;
        }

        public function getVehicleList($selectedPlate = -1) {
            $vehicle_list = $this->conn()->query("SELECT * FROM vehiculos");

            $list = "<label for=\"selectVehicleList\">Vehículo*</label>" .
                      "<select class=\"form-control\" name=\"selectVehicleList\" id=\"selectVehicleList\">";

            for ($i = 0; $i < mysqli_num_rows($vehicle_list); $i++) {
                $vehicle = Vehicle::parseVehicle($vehicle_list);
                $list .= "<option value='" . $vehicle->getId() . "' " . ($vehicle->getPlate() == $selectedPlate && $selectedPlate != -1 ? 'selected' : null) . ">" . $vehicle->getPlate() . "</option>";
            }

            $list .= "</select>";

            return $list;
        }

        public function getReplacementListAsArray($selected = -1, $count = -1) {
            $replacementList = $this->conn()->query("SELECT * FROM repuestos");

            if ($count != -1) {
                $list = "<select class='form-control' name='selectReplacementList[]' id='selectReplacementList$count' data-row='$count' onChange='changePrice(this); calcLinePrice(this); doTheMath();'>";
            } else {
                $list = "<select class='form-control' name='selectReplacementList[]' id='selectReplacementList' onChange='changePrice(this); calcLinePrice(this); doTheMath();'>";
            }


            for ($i = 0; $i < mysqli_num_rows($replacementList); $i++) {
                $replacement = Replacement::parseReplacement($replacementList);
                $list .= "<option value='" . $replacement->getId() . "' data-price='" . $replacement->getPrice() . "' data-percent='" . $replacement->getPercent() . "' " . ($replacement->getRef() == $selected && $selected != -1 ? 'selected' : null) . ">" . $replacement->getRef() . "</option>";
            }

            $list .= "</select>";

            return $list;
        }

// -----------------------------------------  M É T O D O S  S O B R E  L A  T A B L A  R E P U E S T O S  -----------------------------------------

        // Devuelve el ID que le corresponde a una hipotético nuevo cliente (el valor del autoincrement)
        public function getNewBillID() {
            $result = $this->conn()->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'taller' AND TABLE_NAME = 'FACTURA'");

            return $result->fetch_assoc()['AUTO_INCREMENT'];
        }

        // Devuelve el ID que le corresponde a una hipotético nuevo cliente (el valor del autoincrement)
        public function getNewBillLineID() {
            $result = $this->conn()->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'taller' AND TABLE_NAME = 'DETALLE_FACTURA'");

            return $result->fetch_assoc()['AUTO_INCREMENT'];
        }


}