<?php

class ingredient {

    private $connection;
    
    public function __construct($connection){
        $this->connection = $connection;
        $this->art = new artikel($connection);
    }

    private function selecteerArtikel($artikel_id) {
        $data = $this->art->selecteerArtikel($artikel_id);
        return($data);
    }

    public function selecteerIngredient($gerecht_id){
        
    
        $sql = "SELECT *
                FROM ingredient
                WHERE gerecht_id = $gerecht_id";
        
        $result = mysqli_query($this->connection, $sql);
        $return = [];
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $artikel_id = $row['artikel_id'];

                $artikel = $this->selecteerArtikel($artikel_id);

                $return[] = [
                "id" => $row['id'],
                "gerecht_id" => $row['gerecht_id'],
                "aantal" => $row['aantal'],
                "calories" => $row['calories'],
                "artikel_id" => $artikel_id,
                "naam" => $artikel['naam'],
                "prijs" => $artikel['prijs'],
                "verpakking" => $artikel['verpakking'],
                "omschrijving" => $artikel['omschrijving']
                ];
            }

    
        return $return;
    }
    

}