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
        private $avatar;

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
    
        public function getAvatar(){
            return $this->avatar;
        }
    
        public function setAvatar($avatar){
            $this->avatar = $avatar;
        }
    }

    function parseClient($queryResult){
        $result = $queryResult->fetch_assoc();

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
        $client->setAvatar("data:image/jpeg;base64," . base64_encode($result['fotografia']));
        
        return $client;
    }

?>