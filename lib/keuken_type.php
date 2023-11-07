<?php

class keuken_type {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function selecteerKeuken_Type($keuken_type_id) {

        $sql = "SELECT * FROM keuken_type WHERE id = $keuken_type_id";
        $result = mysqli_query($this->connection, $sql);
        $artikel = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($artikel);
    }
}