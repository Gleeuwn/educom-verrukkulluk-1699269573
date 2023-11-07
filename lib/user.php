<?php


class user{

    private $connection;
    
    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function selecteerUser($user_id) {

        $sql = "SELECT * FROM user WHERE id = $user_id";
        $result = mysqli_query($this->connection, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($user);
    }
    public function maximumId() {
        $sql = "SELECT MAX(id) as max_id FROM user";
        $result = mysqli_query($this->connection, $sql);
        $row = mysqli_fetch_assoc($result);
            
        return $row['max_id'];
    }
}