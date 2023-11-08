<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/keuken_type.php");
require_once("lib/ingredient.php");
require_once("lib/gerecht_info.php");

/// INIT
$db = new database();
$art = new artikel($db->getConnection());
$usr = new user($db->getConnection());
$keu = new keuken_type($db->getConnection());
$ing = new ingredient($db->getConnection());
$gei = new gerecht_info($db->getConnection());



/// VERWERK 
$data = $art->selecteerArtikel(1);
$data_user = $usr->selecteerUser(2);
$data_keuk = $keu->selecteerKeuken_Type(4);
$data_ingr = $ing->selecteerIngredient(1);

$data_info_opmerking = $gei->selectRecordType('O');
$data_info_favoriet = $gei->selectRecordType('F');
$data_geri = $gei->selecteerGerecht_info(1);
/// RETURN
var_dump($data);
echo "<BR><BR>";
var_dump($data_user);


echo "<BR><BR> Hier volgt een array van het keukentype met id 4: ";
var_dump($data_keuk);
echo "<BR>";
var_dump($data_ingr);
echo "<BR>";
var_dump($data_geri);
echo "<BR><BR>";
var_dump($data_info_opmerking);
var_dump($data_info_favoriet);
$gei->addFavorite(1, 1);

