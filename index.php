<?php

namespace Shouty;

require 'vendor/autoload.php';
require_once 'src/Shouty/Shouty.php';
use Shouty\Shouty;

// TODO: Need a middleware for loading before each request, and saving after each request
// since PHP doesn't have application state. We'll just dump the entire Shouty object
// to a file.
$shouty = new \Shouty\Shouty();

$app = new \Slim\Slim(array(
    'templates.path' => './views',
    'log.enabled' => true
));

$app->get('/', function () use ($app) {
    $app->render('index.php');
});

$app->get('/people/:personName', function ($personName) use ($app, $shouty) {
    $lat = $app->request->params('lat');
    $lon = $app->request->params('lon');
    $shouty->personIsIn($personName, array($lat, $lon));
    $app->render('person.php', array(
      'personName' => $personName,
      'messages' => $shouty->heardBy($personName)
    ));
});

$app->post('/messages', function () use ($app, $shouty) {
    $personName = $app->request->params('message');
    $message = $app->request->params('message');
    $shouty->personShouts($personName, $message);
    $app->response->redirect($app->request->getReferrer(), 303);
});

$app->run();

?>
