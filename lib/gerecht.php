<?php

class gerecht {

    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
        $this->keu = new keuken_type($connection);
        $this->gei = new gerecht_info($connection);
        $this->ing = new ingredient($connection);
    }

    private function selecteerKeuken_type($gerecht_id) {
        $data = $this->keu->selecteerKeuken_type($gerecht_id);
        return($data);
    }

    private function selecteerGerecht_info($gerecht_id, $record_type) {
        $data = $this->gei->selecteerGerecht_info($gerecht_id, $record_type);
        return($data);
    }

    private function selecteerIngredient($gerecht_id) {
        $data = $this->ing->selecteerIngredient($gerecht_id);
        return($data);
    }
//basismethode ophalen gerecht
    public function ophalenGerecht($id) {

        $sql = "SELECT * 
                FROM gerecht 
                where id = $id";
        
        $result = mysqli_query($this->connection, $sql);
        $return = [];
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $gerecht_id = $row["id"];
                $keuken_id = $row["keuken_id"];
                $type_id = $row["type_id"];

                $ingredient = $this->ing->selecteerIngredient($gerecht_id);
                
                $gerecht_info_opmerking = $this->selecteerGerecht_info($gerecht_id, 'O');
                $gerecht_info_favoriet = $this->selecteerGerecht_info($gerecht_id, 'F');
                $gerecht_info_waardering = $this->selecteerGerecht_info($gerecht_id, 'W');
                $gerecht_info_bereidingswijze = $this->selecteerGerecht_info($gerecht_id, 'B');
                
                $keuken = $this->selecteerKeuken_type($keuken_id);
                $type = $this->selecteerKeuken_type($type_id);
                

                $return[] = [
                    "id" => $row["id"],
                    "datum_toegevoegd" => $row["datum_toegevoegd"],
                    "titel" => $row["titel"],
                    "korte_omschrijving" => $row["korte_omschrijving"],
                    "lange_omschrijving" => $row["lange_omschrijving"],
                    "afbeelding" => $row["afbeelding"],
                    
                    //keukentype
                    "keuken_id" => $keuken,
                    "type_id" => $type,
                    /*"keuken_omschrijving" => $keuken["omschrijving"],
                    "type_omschrijving" => $type["omschrijving"],*/

                    //ingredienten
                    "ingredient" => $ingredient,

                    //gerecht info enz
                    "gerecht_info_opmerking" => $gerecht_info_opmerking,
                    "gerecht_info_favoriet" => $gerecht_info_favoriet,
                    "gerecht_info_waardering" => $gerecht_info_waardering,
                    "gerecht_info_bereidingswijze" => $gerecht_info_bereidingswijze,
                ];

            }
            return $return;
    }

//methode calculeer calorieen
    public function calcCalories($gerecht_id){
        $total_calories = 0;
        $ingredients = $this->ing->selecteerIngredient($gerecht_id);
        foreach ($ingredients as $ingredient) {
            $calories = $ingredient['calories'];
            $total_calories += $calories;           
    }
    return $total_calories;
}
//methode calculeer prijs
    public function calcPrijs($gerecht_id){
        $total_prijs = 0;
            $ingredients = $this->ing->selecteerIngredient($gerecht_id);
            foreach ($ingredients as $ingredient) {
            $prijs = $ingredient['prijs'];
            $total_prijs += $prijs;           
    }
    return $total_prijs;


    }

//methode select beoordeling
    public function SelecteerBeoordeling($gerecht_id){
    $totalbeoordeling = 0;
    $totalReviews = 0;

    $beoordelingen = $this->selecteerGerecht_info($gerecht_id, 'W');

    foreach ($beoordelingen as $beoordeling) {
        $totalbeoordeling += $beoordeling['nummeriekveld']; 
        $totalReviews++;
    }

    if ($totalReviews > 0) {
        $averagebeoordeling = $totalbeoordeling / $totalReviews;
        return $averagebeoordeling;
    } else {
        return 0;
    }
}

//methode select bereidingswijze
    public function selecteerBereidingswijze($gerecht_id){
        $bereidingswijze = $this->selecteerGerecht_info($gerecht_id, 'B');
        return $bereidingswijze;
    }
//methode select opmerkingen
    public function selecteerOpmerkingen($gerecht_id){
        $opmerking = $this->selecteerGerecht_info($gerecht_id, 'O');
        return $opmerking;

    }
//methode select keuken
    public function selecteerKeuken($id){
        $sql = "SELECT keuken_id 
                FROM gerecht 
                where id = $id";

        $result = mysqli_query($this->connection, $sql);
        $keuken = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($keuken);
    }
//methode select keuken
    public function selecteerType($id){
    $sql = "SELECT type_id 
            FROM gerecht 
            where id = $id";

    $result = mysqli_query($this->connection, $sql);
    $type = mysqli_fetch_array($result, MYSQLI_ASSOC);

    return($type);
}
//methode determine favorite
    public function determineFavorite($gerecht_id, $user_id) {
        $favoriteRecords = $this->selecteerGerecht_info($gerecht_id, 'F');

    foreach ($favoriteRecords as $record) {
        if ($record['user_id'] === $user_id) {
            return true; // Gevonden als favoriet, maar het werkt nog niet 
        }
        else {
            return false; // Niet gevonden als favoriet
        }
    }
    
}

}