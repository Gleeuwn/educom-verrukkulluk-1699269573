<?php

class boodschappen{

    private $connection;
    
    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->ing = new ingredient($connection);
        $this->usr = new user($connection);
    }
    
    private function selecteerIngredient($gerecht_id) {
        $data = $this->ing->selecteerIngredient($gerecht_id);
        return($data);
    }
    private function selecteerUser($user_id) {
        $data = $this->usr->selecteerUser($user_id);
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

    private function ophalenBoodschappen($user_id){
        {
            $sql = "SELECT * 
                    FROM boodschappen 
                    WHERE user_id = $user_id";
            $result = mysqli_query($this->connection, $sql);
            $boodschappen = [];
    
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $boodschappen[] = [
                    "boodschappen_id" => $row["id"],
                    "boodschappen_user_id" => $row["user_id"],
                    "boodschappen_artikel_id" => $row["artikel_id"],
                    "boodschappen_totaal" => $row["totaal"],
                ];
            }
            return ($boodschappen);
        }
    }
  /*  public function berekenTotaalPrijs($user_id)
    {
        $sql = "SELECT * FROM boodschappen WHERE user_id = '$user_id'";
        $result = mysqli_query($this->connection, $sql);
            
        $totaal_prijs = 0;
        
        // Loop door elke boodschap en voeg de totale prijs toe
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $user_id = $row['user_id'];
            

            $user = $this->selecteerUser($user_id);
            $totaal_prijs += $row['prijs'];
        }
    
        return $totaal_prijs;
    }
}
*/
}