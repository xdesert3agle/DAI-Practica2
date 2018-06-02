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

        // Devuelve el ID que le corresponde a un hipotetico nuevo cliente (el valor del autoincrement)
        public function getNewClientID() {
            $result = $this->conn()->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'taller' AND TABLE_NAME = 'CLIENTES'");
    
            return $result->fetch_assoc()['AUTO_INCREMENT'];
        }

// -----------------------------------------  M É T O D O S  S O B R E  L A  T A B L A  V E H I C U L O S  -----------------------------------------

        // Devuelve el vehículo con una determinada ID
        public function getVehicleWithID($id){
             return Vehicle::parseVehicle($this->conn()->query("SELECT * FROM VEHICULOS WHERE ID_VEHICULO = $id"));
        }

        // Devuelve el ID que le corresponde a un hipotetico nuevo vehículo (el valor del autoincrement)
        public function getNewVehicleID(){
            return $this->conn()->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'taller' AND TABLE_NAME = 'VEHICULOS'")->fetch_assoc()['AUTO_INCREMENT'];
        }


// -----------------------------------------  M É T O D O S  S O B R E  L A  T A B L A  R E P U E S T O S  -----------------------------------------
        
        // Devuelve el vehículo con una determinada ID
        public function getReplacementWithID($id) {
            return Replacement::parseReplacement($this->conn()->query("SELECT * FROM REPUESTOS WHERE ID_REPUESTO = $id"));
        }

        // Devuelve el ID que le corresponde a un hipotetico nuevo cliente (el valor del autoincrement)
        public function getNewReplacementID() {
            $result = $this->conn()->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'taller' AND TABLE_NAME = 'REPUESTOS'");
    
            return $result->fetch_assoc()['AUTO_INCREMENT'];
        }


        public function getClientList() {
            $clientList = $this->conn()->query("SELECT * FROM clientes");

            $select = "<label for=\"selectOwnerList\">Dueño del vehículo</label>" .
                      "<select class=\"form-control\" name=\"selectOwnerList\" id=\"selectOwnerList\">";

            for ($i = 0; $i < mysqli_num_rows($clientList); $i++) {
                $client = Client::parseClient($clientList);

                $select .= "<option value='" . $client->getId() . "'>" . "#" . $client->getID() . " - " . $client->getSurname1() . " " . $client->getSurname2() . " " . $client->getName() . "</option>";
            }

            $select .= "</select>";

            return $select;
        }

        public function getReplacementList() {
            $replacementList = $this->conn()->query("SELECT * FROM repuestos");

            $select = "<label for=\"selectOwnerList\">Línea de factura</label>" .
                      "<select class=\"form-control\" name=\"selectReplacementList\" id=\"selectReplacementList\">";

            for ($i = 0; $i < mysqli_num_rows($replacementList); $i++) {
                $replacement = Replacement::parseReplacement($replacementList);

                $select .= "<option value='" . $replacement->getId() . "'>" . $replacement->getRef() . "</option>";
            }

            $select .= "</select>";

            return $select;
        }
}