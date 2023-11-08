<?php

class gerecht_info {

    private $connection;
    
    public function __construct($connection){
        $this->connection = $connection;
    }

    public function selecteerGerecht_info($gerecht_id){

        $sql = "SELECT * 
                FROM gerecht_info 
                WHERE gerecht.id = $gerecht_id";

        $result = mysqli_query($this->connection, $sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                echo "alle informatie: " . $row["id, record_type, user_id, datum, numeriekveld, tekstveld"] . "<br>";
            }
        }
        else {
            echo "0 results";
          }
    }

    public function selectRecordType($recordtype){

        $sql = "SELECT * 
        FROM gerecht_info 
        WHERE record_type = '$recordtype'";
        $result = mysqli_query($this->connection, $sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                echo "record_type: " . $row["record_type"] . ", nummeriekveld: " . $row["nummeriekveld"] . ", tekstveld: " .$row["tekstveld"] . ", user: " . $row["user_id"] . "<br>";
            }
        }
        else {
            echo "0 results";
          }
    }

    public function addFavorite($gerecht_id, $user_id){
        $sql = "INSERT INTO gerecht_info (gerecht_id, user_id, record_type) VALUES ($gerecht_id, $user_id, 'F')";
        $result = mysqli_query($this->connection, $sql);

        return($result);
    }

    public function deleteFavorite($gerecht_id, $user_id){
        $sql = "DELETE FROM gerecht_info WHERE gerecht_id = $gerecht_id AND user_id = $user_id AND record_type = 'F'";
        $result = mysqli_query($this->connection, $sql);

        return($result);
    }
}