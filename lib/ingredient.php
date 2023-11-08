<?php

class ingredient {

    private $connection;
    
    public function __construct($connection){
        $this->connection = $connection;
    }

    public function selecteerIngredient($gerecht_id){
        
    
        $sql = "SELECT ingredient.id AS ingredient_id, artikel.naam AS ingredient_naam, ingredient.aantal
                FROM ingredient
                INNER JOIN artikel ON ingredient.artikel_id = artikel.id
                WHERE ingredient.gerecht_id = $gerecht_id";
        
        $result = mysqli_query($this->connection, $sql);
    
        if ($result->num_rows > 0) {
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $return[] = $row;
            }
        } else {
            echo "0 results";
        }
    
        return $return;
    }
    
    public function selecteerArtikel($artikel_id) {

        $sql = "select * from artikel where id = $artikel_id";
        
        $result = mysqli_query($this->connection, $sql);
        $artikel = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($artikel);

    }
}