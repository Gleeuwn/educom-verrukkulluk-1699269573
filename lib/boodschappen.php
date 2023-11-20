<?php

class boodschappen{

    private $connection;
    
    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->ing = new ingredient($connection);
        $this->usr = new user($connection);
        $this->art = new artikel($connection);
    }
    
    private function selecteerIngredient($gerecht_id) {
        $data = $this->ing->selecteerIngredient($gerecht_id);
        return($data);
    }
    private function selecteerUser($user_id) {
        $data = $this->usr->selecteerUser($user_id);
        return($data);
    }

    private function selecteerArtikel($artikel_id) {
        $data = $this->art->selecteerArtikel($artikel_id);
        return($data);
    }
    
    public function boodschappenToevoegen($user_id, $gerecht_id)
    {
        $ingredienten = $this->ophalenIngredienten($gerecht_id);
        foreach ($ingredienten as $ingredient) {
            $artikel_id = $ingredient['artikel_id'];
            $totaal = 1;
            $opLijst = $this->artikelOpLijst($artikel_id, $user_id);
            if($this->artikelOplijst($artikel_id, $user_id)) {
                $result = $this->artikelBijwerken($artikel_id);
            }
            else {
                $this->artikelToevoegen($artikel_id, $user_id, $totaal);
            }

        }
    }
    private function ophalenIngredienten($gerecht_id)
    {
    $ingredienten = $this->selecteerIngredient($gerecht_id);
    $boodschapingredienten = [];
        foreach($ingredienten as $ingredient){
            $artikel_id = $ingredient['artikel_id'];
            $boodschapingredienten[] = [
                'artikel_id' => $artikel_id
            ];
        }
    return $boodschapingredienten;
    }

    private function artikelOpLijst($artikel_id, $user_id){
        $boodschappen = $this->ophalenBoodschappen($user_id);
            foreach($boodschappen as $boodschap){
                if ($boodschap["boodschappen_artikel_id"] == $artikel_id) {
                return ($boodschap);
            }
        }
        return false;
    }

    private function artikelBijwerken ($artikel_id){
        {          
            $sql = "UPDATE boodschappen 
                    SET totaal = totaal + 1 
                    WHERE artikel_id = $artikel_id";
            $result = mysqli_query($this->connection, $sql);
            return($result);
        }
    }
    private function artikelToevoegen ($artikel_id, $user_id, $totaal){
        
        $sql= "INSERT INTO boodschappen (artikel_id, user_id, totaal)
                VALUES ($artikel_id, $user_id, $totaal)";
        $result = mysqli_query($this->connection, $sql); 
        return($result);
    }

    public function ophalenBoodschappen($user_id){
        {
            $sql = "SELECT * 
                    FROM boodschappen 
                    WHERE user_id = $user_id";
            $result = mysqli_query($this->connection, $sql);
            $boodschappen = [];
    
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $artikel_id = $row['artikel_id'];

                $artikel = $this->selecteerArtikel($artikel_id);
                $totaal_prijs = $this->berekenTotaalPrijs($user_id);

                $boodschappen[] = [
                    "boodschappen_id" => $row["id"],
                    "boodschappen_user_id" => $row["user_id"],
                    "boodschappen_artikel_id" => $row["artikel_id"],
                    "boodschappen_totaal" => $row["totaal"],
                    "naam" => $artikel["naam"],
                    "omschrijving" => $artikel["omschrijving"],
                    "verpakking" => $artikel["verpakking"],
                    "eenheid" => $artikel["eenheid"],
                    "prijs" => $artikel["prijs"],
                    "totaal_prijs" => $totaal_prijs
                ];
            }


            return ($boodschappen);
        }
    }
    public function berekenTotaalPrijs($user_id) {
        $totaal_prijs = 0;
        $sql = "SELECT * FROM boodschappen WHERE user_id = $user_id";
        $result = mysqli_query($this->connection, $sql);
    
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $artikel_id = $row['artikel_id'];
            $artikel = $this->selecteerArtikel($artikel_id);
            $totaal_prijs += $artikel["prijs"] * $row["totaal"];
        }
    
        return $totaal_prijs;
    }

}