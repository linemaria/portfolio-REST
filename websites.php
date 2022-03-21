<?php
include_once ('includes/config.php');
include_once 'includes/Database.php';
include_once 'classes/Website.class.php';

//Headers som gör webbtjänsten tillgänglig från alla domäner
//Gör att webbtjänsten går att komma åt från alla domäner (asterisk * betyder alla)
header('Access-Control-Allow-Origin: *');

//Talar om att webbtjänsten skickar data i JSON-format
header('Content-Type: application/json');

//Vilka metoder som webbtjänsten accepterar, som standard tillåts bara GET.
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

//Vilka headers som är tillåtna vid anrop från klient-sidan, kan bli problem med CORS (Cross-Origin Resource Sharing) utan denna.
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


$method = $_SERVER['REQUEST_METHOD'];
//om en parameter av id finns i urlen
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}


//skapar instans av klassen för att skicka SQL-fråga till db
//skickar med db anslutning som parameter
$websites = new Website();

switch($method) {
    case 'GET':
        //http response status code
        http_response_code(200);

        $response = $websites->getWebsites();
        if(count($response) == 0) {
            $response = array("message" => "Inga webbplatser funna.");
        }

        if(isset($id)) {
            //kör funktion för att läsa rad med specifikt id
            $response = $websites->getWebsiteById($id);
        } else {
            //kör funktion för att läsa data från tabellen
            $response = $websites->getWebsites();
        }

        //kontrollera om resultatet innehåller ngn rad
        // if(sizeof($result) > 0) {
        //     http_response_code(200); //ok
        // } else {
        //     http_response_code(404); //ej funnen
        //     $response = array("message" => "Inga Webbplatser funna.");
        // }
        break;


        case 'POST':
            $data = json_decode(file_get_contents("php://input"));

            // if($data->title == "" || $data->description == "" || $data->url == "" || $data->image == "") {
                if($data->title == "" || $data->description == "" || $data->url == "") {

    $response = array("message" => "Fyll i något!");

    http_response_code(400); //user error
} else {
    // if($websites->createWebsite($data->title, $data->description, $data->url, $data->image)) {
        if($websites->createWebsite($data->title, $data->description, $data->url)) {
        $response = array("message" => "Created");
        http_response_code(201); //Created
    } else {
        $response = array("message" => "something went wrong");
        http_response_code(500); //Server error
    }
}
            break;

            case 'PUT':
                //Om inget id är med skickat, skicka felmeddelande
                if(!isset($id)) {
                    http_response_code(510);//400); //Bad Request - The server could not understand the request due to invalid syntax.
                    $response = array("message" => "No id is sent");
                //Om id är skickad   
                } else {
                    $data = json_decode(file_get_contents("php://input"));
        
                  if($websites->updateWebsite($id, $data)) {
                         http_response_code(200);
                         $response = array("message" => "Course updated");
                  } else{
                      http_response_code(503);
                      $response = array ("message" => "No id is sent");
                  }
                 
                    }
            break;

            case 'DELETE':
                //om id inte är medskickat, skicka error
                if(!isset($id)) {
                    http_response_code(510); //not extended
                    $response = array("message" => "Inget id har skickats.");
                    //om id har skickats
                } else {
                    //kör funktion för att radera en rad
                    if($websites->deleteWebsite($id)) {
                        http_response_code(200); //ok
                        $response = array("message" => "Webbplatsen är raderad.");
                    } else {
                        http_response_code(503); //server error
                        $response = array("message" => "Webbplatsen är inte raderad.");
                    }
                }
                break;
}

//returnera resultat som JSON
echo json_encode($response);