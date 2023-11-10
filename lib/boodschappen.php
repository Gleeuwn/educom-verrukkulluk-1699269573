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

 


    // Voeg een artikel toe aan de boodschappenlijst voor een specifieke gebruiker en gerecht
    public function voegArtikelToe($user_id, $gerecht_id)
    {
        $ingredienten = $this->selecteerIngredient($gerecht_id);
        foreach ($ingredienten as $ingredient) {
            $artikel_id = $ingredient['artikel_id'];
            $totaal =1;

            $this-> voegArtikelToeTabel($user_id, $artikel_id, $totaal);
        }
        return "artikelen toegevoegd.";
        }
    
    private function voegArtikelToeTabel($user_id, $artikel_id, $totaal)
    {
        $sql = "INSERT INTO boodschappen (user_id, artikel_id, totaal) 
                VALUES ('$user_id', '$artikel_id', '$totaal')";
        mysqli_query($this->connection, $sql);

    }

    public function berekenTotaalPrijs($user_id)
    {
        $sql = "SELECT * FROM boodschappen WHERE user_id = '$user_id'";
        $result = mysqli_query($this->connection, $sql);
    
        $totaal_prijs = 0;
    
        // Loop door elke boodschap en voeg de totale prijs toe
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $totaal_prijs += $row['prijs'];
        }
    
        return $totaal_prijs;
    }
}

