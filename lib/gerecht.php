<?php

class gerecht {

    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
        $this->keu = new keuken_type($connection);
        $this->gei = new gerecht_info($connection);
        $this->ing = new ingredient($connection);
    }

    private function selecteerKeuken_type($keuken_type_id) {
        $data = $this->keu->selecteerKeuken_type($keuken_type_id);
        return($data);
    }

    private function selecteerGerecht_info($gerecht_info_id) {
        $data = $this->gei->selecteerGerecht_info($gerecht_info_id);
        return($data);
    }

    private function selecteerIngredient($ingredient_id) {
        $data = $this->ing->selecteerIngredient($ingredient_id);
        return($data);
    }
//basismethode selecteergerecht
    public function selecteerGerecht($id) {

        $sql = "SELECT * 
                FROM gerecht 
                where id = $id";
        
        $result = mysqli_query($this->connection, $sql);
        $gerecht = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($gerecht);
    }
//methode selecteeruser
    public function selecteerUser($user_id) {

        $sql = "SELECT * 
                FROM user 
                WHERE id = $user_id";
        $result = mysqli_query($this->connection, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($user);
    }
//methode selecteeringredient
    public function selecteerIngredient($ingredient_id){

        $sql = "SELECT * 
                FROM ingredient 
                WHERE id = $ingredient_id";

         $result = mysqli_query($this->connection, $sql);
        $ingredient = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($ingredient);
    }
/*//methode calculeer calorieen
    public function calcCalories($gerecht_id){
        $sql = "SELECT SUM(ingredient.calories) AS total_calories
                FROM ingredient
                WHERE ingredient.gerecht_id = $gerecht_id";
        
            $result = mysqli_query($this->connection, $sql);
            $calories = mysqli_fetch_array($result);
        
            return $calories['total_calories'];
    }
//methode calculeer prijs
    public function calcPrijs($gerecht_id){
        $sql = "SELECT SUM(ingredient.prijs) AS totalprijs
                FROM ingredient
                JOIN artikel ON ingredient.artikel_id = artikel.id
                WHERE gerecht.id = $gerecht_id";

            $result = mysqli_query($this->connection, $sql);
            $prijs = mysqli_fetch_array($result);

            return $prijs['totalprijs'];


    }
/*
//methode select beoordeling
    public function selectBeoordeling(){

    }
//methode select bereidingswijze
    public function selectBereidingswijze(){

    }
//methode select opmerkingen
    public function selectOpmerkingen(){

    }
//methode select keuken
    public function selectKeuken(){

    }
//methode select type
    public function selectType(){

    }
//methode determine favorite
    public function determineFavoriet(){

    }
*/
}