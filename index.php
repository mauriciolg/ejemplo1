<?php
require_once __DIR__.'/vendor/autoload.php';

use GuzzleHttp\Client; //Cliente de Guzzle para hacer llamadas http a otro sitio
use Symfony\Component\HttpFoundation\Response; //Objeto Response de Symfony para devolver una respuesta json

$api_key = getenv("OPEN_WEATHER_API"); //Obtiene la variable de entorno que guarda la API KEY

$app = new Silex\Application();

$app->get('/', function() use($app, $api_key) {
	return "API v1.0 using APPID: $api_key";
}); 

$app->get('/clima', function() use($app,$api_key) {
	
	//Cliente de Guzzle
	$cliente = new Client();
	//url para llamar la api de openweathermap.org con id de la Cd. de Córdoba, Ver
	//(donde yo vivo), mi api Key (appid) y unidad de medida en grados Celsius (metric)
	$url = "https://api.openweathermap.org/data/2.5/weather?id=3530240&appid=$api_key&units=metric";

	//Llamada get para capturar en $response la respuesta
	$response = $cliente->request('GET',$url);
	//Se usa getBody() para obtener la respuesta almacenada en $response
	$body = $response->getBody();

	/*
	*  Se devuelve un Response con el body, un código de estado http 200 = consulta exitosa
	*  y se traduce $body (texto) en json
	*/
	return new Response($body, 200, array("Content-Type" => "application/json"));
	
	//$arreglo = array('Mauricio Lopez Gallardo' => 456464564);

	//return $app -> json($arreglo);

});

//Recibe como parámetros la latitud y longitud de la aplicación en Android
$app->get('/clima/{lat}/{lon}', function($lat, $lon) use($app, $api_key){

	$cliente = new Client();
	$url = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&APPID=$api_key&units=metric";
	$response = $cliente->request('GET', $url);
	$body = $response->getBody();
	return new Response($body, 200, array("Content-Type" => "application/json"));
});	

$app->run();
?>

