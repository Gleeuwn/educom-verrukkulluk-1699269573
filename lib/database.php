<?php 

// Aanpassen naar je eigen omgeving
define("USER", "username");
define("PASSWORD", "password");
define("DATABASE", "verrukkullukdatabase");
define("HOST", "localhost");

class database {

    private $connection;

    public function __construct() {
       $this->connection = mysqli_connect(HOST,                                          
                                         USER, 
                                         PASSWORD,
                                         DATABASE );
    }

    public function getConnection() {
        return($this->connection);
    }

}
