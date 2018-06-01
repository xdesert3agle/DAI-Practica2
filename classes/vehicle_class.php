<?php
    class Vehicle {
        private $id;
        private $plate;
        private $brand;
        private $model;
        private $year;
        private $color;
        private $clientID;

        public function getId(){
            return $this->id;
        }
    
        public function setId($id){
            $this->id = $id;
        }

        public function getPlate(){
            return $this->plate;
        }
    
        public function setPlate($plate){
            $this->plate = $plate;
        }
    
        public function getBrand(){
            return $this->brand;
        }
    
        public function setBrand($brand){
            $this->brand = $brand;
        }

        public function getModel(){
            return $this->model;
        }
    
        public function setModel($model){
            $this->model = $model;
        }
    
        public function getYear(){
            return $this->year;
        }
    
        public function setYear($year){
            $this->year = $year;
        }
    
        public function getColor(){
            return $this->color;
        }
    
        public function setColor($color){
            $this->color = $color;
        }
    
        public function getClientID(){
            return $this->clientID;
        }
    
        public function setClientID($clientID){
            $this->clientID = $clientID;
        }

        // Crea y devuelve un objeto Vehículo a partir del resultado de una consulta
        public function parseVehicle($result){
            $result = $result->fetch_assoc();
            
            $vehicle = new Vehicle;
            $vehicle->setID($result['id_vehiculo']);
            $vehicle->setPlate($result['matricula']);
            $vehicle->setBrand($result['marca']);
            $vehicle->setModel($result['modelo']);
            $vehicle->setYear($result['anio']);
            $vehicle->setColor($result['color']);
            $vehicle->setClientID($result['id_cliente']);
            
            return $vehicle;
        }
    }

?>