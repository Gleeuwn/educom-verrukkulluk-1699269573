<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/keuken_type.php");
require_once("lib/ingredient.php");

/// INIT
$db = new database();
$art = new artikel($db->getConnection());
$usr = new user($db->getConnection());
$keu = new keuken_type($db->getConnection());
$ing = new ingredient($db->getConnection());


/// VERWERK 
$data = $art->selecteerArtikel(1);
$data_user = $usr->selecteerUser(2);
$data_keuk = $keu->selecteerKeuken_Type(4);
$hoogsteId = $usr->maximumId();
$data_ingr = $ing->selecteerIngredient(1);

/// RETURN
var_dump($data);
echo "<BR><BR>";
var_dump($data_user);


echo "<BR> Het hoogst ingevoegde ID is: " . $hoogsteId;
echo "<BR><BR> Hier volgt een array van het keukentype met id 4: ";
var_dump($data_keuk);
echo "<BR>";
var_dump($data_ingr);
