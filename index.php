<?php

namespace Shouty;

require 'vendor/autoload.php';
require_once 'src/Shouty/Shouty.php';
use Shouty\Shouty;

$app = new \Slim\Slim(array(
    'templates.path' => './views',
    'log.enabled' => true
));

// TODO: Need a middleware for loading before each request, and saving after each request
// since PHP doesn't have application state. We'll just dump the entire Shouty object
// to a file.
if(file_exists('store')) {
    $shouty = unserialize(file_get_contents('store'));
} else {
    $shouty = new \Shouty\Shouty();
}

$app->get('/', function () use ($app) {
    $app->render('index.php');
});

$app->get('/people/:personName', function ($personName) use ($app, $shouty) {
    $lat = $app->request->params('lat');
    $lon = $app->request->params('lon');
    $shouty->personIsIn($personName, array($lat, $lon));
    file_put_contents('store', serialize($shouty));
    $app->render('person.php', array(
      'personName' => $personName,
      'messages' => $shouty->heardBy($personName)
    ));
});

$app->post('/messages', function () use ($app, $shouty) {
    $personName = $app->request->params('personName');
    $message = $app->request->params('message');
    $shouty->personShouts($personName, $message);
    file_put_contents('store', serialize($shouty));
    $app->response->redirect($app->request->getReferrer(), 303);
});

$app->run();

?>
