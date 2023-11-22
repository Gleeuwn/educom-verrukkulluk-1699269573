<?php
//// Allereerst zorgen dat de "Autoloader" uit vendor opgenomen wordt:
require_once("./vendor/autoload.php");

/// Twig koppelen:
$loader = new \Twig\Loader\FilesystemLoader("./templates");
/// VOOR PRODUCTIE:
/// $twig = new \Twig\Environment($loader), ["cache" => "./cache/cc"]);

/// VOOR DEVELOPMENT:
$twig = new \Twig\Environment($loader, ["debug" => true ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

/******************************/

/// Next step, iets met je data doen. Ophalen of zo
require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/keuken_type.php");
require_once("lib/ingredient.php");
require_once("lib/gerecht_info.php");
require_once("lib/gerecht.php");
require_once("lib/boodschappen.php");
$db = new database();
// $art = new artikel($db->getConnection());
// $usr = new user($db->getConnection());
// $keu = new keuken_type($db->getConnection());
$ing = new ingredient($db->getConnection());
$gei = new gerecht_info($db->getConnection());
$ger = new gerecht($db->getConnection());
$boo = new boodschappen($db->getConnection());



/*
URL:
http://localhost/educom-verrukkulluk-1699269573/index.php?gerecht_id=1&action=detail
*/

$gerecht_id = isset($_GET["gerecht_id"]) ? $_GET["gerecht_id"] : null;
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";
$zoekterm = isset($_GET['q']) ? $_GET['q'] : '';
$waardering = 0;
$favoriet = 0;

// $action = "homepage";
// if (isset($_GET["action"])) {
//  $action = $_GET["action"]; 
// } 


switch($action) {

        case "homepage": {
            $data = $ger->ophalenGerecht();
            $template = 'homepage.html.twig';
            $title = "homepage";
            break;
        }

        case "detail": {
            $data = $ger->ophalenGerecht($gerecht_id);
            $template = 'detail.html.twig';
            $title = "detail pagina";
            break;
        }

        case "boodschap": {
            $user_id = $_GET["user_id"];
            $data = $boo->ophalenBoodschappen($user_id);
            if (isset($_GET["gerecht_id"])) {
                $gerecht_id = $_GET["gerecht_id"];
                $boo->boodschappenToevoegen($gerecht_id, $user_id);
                };
            $template = 'boodschap.html.twig';
            $title = "boodschappenlijst";
            break;
        }

        case "waardering": {
            $aantal = $_GET["aantal"];
            $gerecht_id = $_GET["gerecht_id"];
            header('Content-Type: application/json; charset=utf-8'); 
            $data = $gei->add_waardering($gerecht_id, $aantal);
            $json = json_encode($data);
            echo $json;
            $waardering = 1;
            die();
            break;
        }
        
        case "favoriet": {
            $gerecht_id = $_GET["gerecht_id"];
            $user_id = $_GET["user_id"];
            header('Content-Type: application/json; charset=utf-8');
            if (isset($_GET["verwijderen"])) {
                $data = $gei->deleteFavorite($gerecht_id, $user_id);
            } else {
                $data = $gei->addFavorite($gerecht_id, $user_id);
            }
            $json = json_encode($data);
            echo $json;
            die();
            break;
        }

        case "zoekpagina": {
            $data = $ger->ophalenGerecht();
            $template = 'zoekpagina.html.twig';
            $title = "zoekpagina";
            break;

        }

        

        /// etc

}


/// Onderstaande code schrijf je idealiter in een layout klasse of iets dergelijks
/// Juiste template laden, in dit geval "homepage"
$template = $twig->load($template);


/// En tonen die handel!
echo $template->render(["title" => $title, "data" => $data]);