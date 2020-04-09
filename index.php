<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__. '/db/database.php';

$leaf = new Leaf\Core\Leaf;
$response = new Leaf\Core\Http\Response;
$request = new Leaf\Core\Http\Request;

$leaf->get('/', function() use ($response) {
	$response->respond(["message" => "Countries African API"]);
});

$leaf->get('/countries', function() use ($response, $database) {
	$countries = $database->select("countries")->fetchAll();
	$response->respond($countries);
});

$leaf->get('/country/{id}', function($id) use($database, $response) {
  $country = $database->query("SELECT * FROM countries 
  	WHERE id = ?", [$id])->fetchAll();
  $response->respond($country);
});

$leaf->set404(function () use ($response) {
  header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
  $response->respondWithCode(["message" => "url not found"], 404);
});


$leaf->run();
