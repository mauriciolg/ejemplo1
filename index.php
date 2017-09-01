<?php
require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

$app->get('/clima', function() use($app) {

	/*
	Se crea el arreglo asociativo con mi nombre como llave
	 y mi numero de cuenta como valor
	 */
	$arreglo = array('Mauricio Lopez Gallardo' => 414144479);

    return $app -> json($arreglo);
	});

$app->run();
?>