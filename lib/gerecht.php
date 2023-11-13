<?php

class gerecht {

    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
        $this->keu = new keuken_type($connection);
        $this->gei = new gerecht_info($connection);
        $this->ing = new ingredient($connection);
        $this->usr = new user($connection);
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
    private function selecteerUser($user_id) {
        $data = $this->ing->selecteerUser($user_id);
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
                $user_id = $row["user_id"];

                $ingredient = $this->ing->selecteerIngredient($gerecht_id);
                
                $gerecht_info_opmerking = $this->selecteerGerecht_info($gerecht_id, 'O');
                $gerecht_info_favoriet = $this->selecteerGerecht_info($gerecht_id, 'F');
                $gerecht_info_waardering = $this->selecteerGerecht_info($gerecht_id, 'W');
                $gerecht_info_bereidingswijze = $this->selecteerGerecht_info($gerecht_id, 'B');
                
                $keuken = $this->selecteerKeuken_type($keuken_id);
                $type = $this->selecteerKeuken_type($type_id);

                $calories = $this->calcCalories($ingredient);
                $prijs = $this->calcPrijs($ingredient);
                $beoordeling = $this->selecteerBeoordeling($gerecht_info_waardering);
                $determineFavorite = $this->determineFavorite($gerecht_info_favoriet);
                

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
                    //ingredienten
                    "ingredient" => $ingredient,
                    //gerecht info enz
                    "gerecht_info_opmerking" => $gerecht_info_opmerking,
                    "gerecht_info_favoriet" => $gerecht_info_favoriet,
                    "gerecht_info_waardering" => $gerecht_info_waardering,
                    "gerecht_info_bereidingswijze" => $gerecht_info_bereidingswijze,
                    "calorieën" => $calories,
                    "prijs" => $prijs,
                    "beoordeling" => $beoordeling,
                    "determinefavorite" => $determineFavorite
                ];

            }
            return $return;
    }

//methode calculeer calorieen.
    private function calcCalories($calories){
        $total_calories = 0;
        foreach ($calories as $calorie_ingredient) {
            $calories = $calorie_ingredient['calories'];
            $total_calories += $calories;           
    }
    return $total_calories;
}
//methode calculeer prijs
        private function calcPrijs($prijs){
        $total_prijs = 0;
            foreach ($prijs as $prijs_ingredient) {
            $prijs = $prijs_ingredient['prijs'];
            $total_prijs += $prijs;           
    }
    return $total_prijs;


    }

//methode select beoordeling
    private function selecteerBeoordeling($beoordeling){
    $totalbeoordeling = 0;

    $totalbeoordeling = count($beoordeling);
    if($totalbeoordeling >= 0) return 0;

    foreach ($beoordeling as $beoordelingen) {
        $totalbeoordeling += $beoordelingen['nummeriekveld']; 
    }

}
/* onderstaande methodes staan al opgenomen in ophalenGerecht dus volgens mij hoef ik die niet nog eens te op te halen.
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
*/
//methode determine favorite
    private function determineFavorite($gerecht_info_favoriet) {
        if ($gerecht_info_favoriet != null) return 0;
        foreach ($gerecht_info_favoriet as $record) {
        $favorieten[] = [
            "user_id" => $record["user_id"]
        ];

    }
    return ($favorieten);
}

}