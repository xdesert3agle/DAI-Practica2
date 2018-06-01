<?php

    class Replacement {
        private $ref;
        private $description;
        private $price;
        private $percent;
        private $photo;

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
        public function parseReplacement($result){
            $result = $result->fetch_assoc();
            
            $replacement = new Replacement;
            $replacement->setRef($result['id_vehiculo']);
            $replacement->setDescription($result['id_vehiculo']);
            $replacement->setPrice($result['matricula']);
            $replacement->setPercent($result['porcentaje']);
            $replacement->setPhoto($result['fotografia']);
            
            return $result;
        }
    }

?>