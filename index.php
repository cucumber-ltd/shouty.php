<?php

require 'vendor/autoload.php';
require_once 'src/Shouty/Shouty.php';
use Shouty\Shouty;

$app = new \Slim\Slim(array(
    'templates.path' => './views',
    'log.enabled' => true
));

$app->hook('slim.before', function() use ($app) {
    if(file_exists('store')) {
        $shouty = unserialize(file_get_contents('store'));
    } else {
        $shouty = new \Shouty\Shouty();
    }
    $app->environment['shouty'] = $shouty;
});

$app->hook('slim.after', function() use ($app) {
    $shouty = $app->environment['shouty'];
    file_put_contents('store', serialize($shouty));
});

$app->get('/', function () use ($app) {
    $app->render('index.php');
});

$app->get('/people/:personName', function ($personName) use ($app, $shouty) {
    $lat = $app->request->params('lat');
    $lon = $app->request->params('lon');
    $shouty = $app->environment['shouty'];
    if($lat && $lon) {
        $shouty->personIsIn($personName, array($lat, $lon));
    }
    $app->render('person.php', array(
        'personName' => $personName,
        'messages' => $shouty->heardBy($personName)
    ));
});

$app->post('/messages', function () use ($app, $shouty) {
    $personName = $app->request->params('personName');
    $message = $app->request->params('message');
    $shouty = $app->environment['shouty'];
    $shouty->personShouts($personName, $message);
    $app->response->redirect($app->request->getReferrer(), 303);
});

$app->run();

?>
