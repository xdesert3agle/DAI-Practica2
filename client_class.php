<?php
    class Client {
        private $id;
        private $dni;
        private $name;
        private $surname1;
        private $surname2;
        private $address;
        private $postalCode;
        private $location;
        private $province;
        private $telephone;
        private $email;
        private $photo;

        public function getId(){
            return $this->id;
        }
    
        public function setId($id){
            $this->id = $id;
        }
    
        public function getDni(){
            return $this->dni;
        }
    
        public function setDni($dni){
            $this->dni = $dni;
        }
    
        public function getName(){
            return $this->name;
        }
    
        public function setName($name){
            $this->name = $name;
        }
    
        public function getSurname1(){
            return $this->surname1;
        }
    
        public function setSurname1($surname1){
            $this->surname1 = $surname1;
        }
    
        public function getSurname2(){
            return $this->surname2;
        }
    
        public function setSurname2($surname2){
            $this->surname2 = $surname2;
        }
    
        public function getAddress(){
            return $this->address;
        }
    
        public function setAddress($address){
            $this->address = $address;
        }
    
        public function getPostalCode(){
            return $this->postalCode;
        }
    
        public function setPostalCode($postalCode){
            $this->postalCode = $postalCode;
        }
    
        public function getLocation(){
            return $this->location;
        }
    
        public function setLocation($location){
            $this->location = $location;
        }
    
        public function getProvince(){
            return $this->province;
        }
    
        public function setProvince($province){
            $this->province = $province;
        }
    
        public function getTelephone(){
            return $this->telephone;
        }
    
        public function setTelephone($telephone){
            $this->telephone = $telephone;
        }
    
        public function getEmail(){
            return $this->email;
        }
    
        public function setEmail($email){
            $this->email = $email;
        }
    
        public function getPhoto(){
            return $this->photo;
        }
    
        public function setPhoto($photo){
            $this->photo = $photo;
        }

        // Crea y devuelve un objeto cliente a partir del resultado de una consulta
        public static function parseClient($result){
            $result = $result->fetch_assoc();
            
            $client = new Client;
            $client->setId($result['id_cliente']);
            $client->setDni($result['dni']);
            $client->setName($result['nombre']);
            $client->setSurname1($result['apellido1']);
            $client->setSurname2($result['apellido2']);
            $client->setAddress($result['direccion']);
            $client->setPostalCode($result['cp']);
            $client->setLocation($result['poblacion']);
            $client->setProvince($result['provincia']);
            $client->setTelephone($result['telefono']);
            $client->setEmail($result['email']);
            $client->setPhoto("data:image/png;base64," . base64_encode($result['fotografia']));
            
            return $client;
        }

        // Devuelve el cliente con una determinada ID
        public static function getClientWithID($id){
            global $conn;
    
            $query = "SELECT * FROM CLIENTES WHERE ID_CLIENTE = " .$id;
            $result = $conn->query($query);
    
            $client = new Client;
    
            
            $client = Client::parseClient($result);
            
            return $client;
        }

        // Devuelve el ID que le corresponde a un hipotetico nuevo cliente (el valor del autoincrement)
        public static function getNewClientID(){
            global $conn;
    
            $result = $conn->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'taller' AND TABLE_NAME = 'CLIENTES'");
    
            return $result->fetch_assoc()['AUTO_INCREMENT'];
        }
    }

?>