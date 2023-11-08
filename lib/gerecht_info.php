<?php

class gerecht_info {

    private $connection;
    
    public function __construct($connection){
        $this->connection = $connection;
    }

    public function selecteerGerecht_info($gerecht_id){

        $sql = "SELECT * FROM gerecht_info WHERE id = $gerecht_id";

        $result = mysqli_query($this->connection, $sql);
        $gerecht_info = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($gerecht_info);
    }

    public function selectRecordType($recordtype){

        $sql = "SELECT * FROM gerecht_info WHERE record_type = '$recordtype'";
        $result = mysqli_query($this->connection, $sql);
        $recordinfo = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($recordinfo);
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