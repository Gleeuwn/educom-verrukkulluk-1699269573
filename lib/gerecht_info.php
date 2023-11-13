<?php

class gerecht_info {

    private $connection;
    
    public function __construct($connection){
        $this->connection = $connection;
        $this->usr = new user($connection);
    }

    private function selecteerUser($user_id) {
        $data = $this->usr->selecteerUser($user_id);
        return($data);
    }

    public function selecteerGerecht_info($gerecht_id, $record_type){

        $sql = "SELECT * 
                FROM gerecht_info 
                WHERE gerecht_id = $gerecht_id
                AND record_type = '$record_type'";

        $result = mysqli_query($this->connection, $sql);
        $return = [];
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $gerinfoarray = [
                    "id" => $row['id'],
                    "record_type" => $row['record_type'],
                    "gerecht_id" => $row['gerecht_id'],
                    "datum" => $row['datum'],
                    "nummeriekveld" => $row['nummeriekveld'],
                    "tekstveld" => $row['tekstveld'],
                    ];

                    if ($row['record_type'] === 'O' || $row['record_type'] === 'F') {
                        $user_id = $row['user_id'];
                        $user = $this->selecteerUser($user_id);
                        $gerinfoarray["user_id"] = $user_id;
                        $gerinfoarray["user_name"] = $user['user_name'];
                        $gerinfoarray["afbeelding"] = $user['afbeelding'];
                    }
                    $return[] = $gerinfoarray;
            }
            return $return;
  
    }
        

    public function addFavorite($gerecht_id, $user_id){
        $this -> deleteFavorite($gerecht_id, $user_id);
        $sql = "INSERT INTO gerecht_info (gerecht_id, user_id, record_type) 
                VALUES ($gerecht_id, $user_id, 'F')";
        $result = mysqli_query($this->connection, $sql);

        return($result);
    }

    public function deleteFavorite($gerecht_id, $user_id){
        $sql = "DELETE FROM gerecht_info 
                WHERE gerecht_id = $gerecht_id 
                AND user_id = $user_id 
                AND record_type = 'F'";
        $result = mysqli_query($this->connection, $sql);

        return($result);
    }
}