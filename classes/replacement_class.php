<?php

    class Replacement {
        private $id;
        private $ref;
        private $description;
        private $price;
        private $percent;
        private $photo;

        public function getId(){
            return $this->id;
        }
    
        public function setId($id){
            $this->id = $id;
        }

        public function getRef(){
            return $this->ref;
        }
    
        public function setRef($ref){
            $this->ref = $ref;
        }
    
        public function getDescription(){
            return $this->description;
        }
    
        public function setDescription($description){
            $this->description = $description;
        }
    
        public function getPrice(){
            return $this->price;
        }
    
        public function setPrice($price){
            $this->price = $price;
        }
    
        public function getPercent(){
            return $this->percent;
        }
    
        public function setPercent($percent){
            $this->percent = $percent;
        }
    
        public function getPhoto(){
            return $this->photo;
        }
    
        public function setPhoto($photo){
            $this->photo = $photo;
        }

        // Crea y devuelve un objeto Repuesto a partir del resultado de una consulta
        public static function parseReplacement($result){
            $result = $result->fetch_assoc();
            
            $replacement = new Replacement;
            $replacement->setId($result['id_repuesto']);
            $replacement->setRef($result['referencia']);
            $replacement->setDescription($result['descripcion']);
            $replacement->setPrice($result['importe']);
            $replacement->setPercent($result['porcentaje']);
            $replacement->setPhoto($result['fotografia'] ? "data:image/jpg;base64," . base64_encode($result['fotografia']) : "resources/img/no_photo_product.jpg");
            
            return $replacement;
        }
    }