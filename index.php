<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nomad
 * Date: 2013/05/24
 * Time: 10:04 AM
 */

require_once 'vendor/autoload.php';

$app = new \Slim\Slim();

\Slim\Slim::registerAutoloader();

function loadTwig(){
    $loader = new Twig_Loader_Filesystem('views');
    $twig = new Twig_Environment($loader, array(
        'cache' => false,
        'debug' => true
    ));
    return $twig;
}

$twig = loadTwig();

// DATABASE //

require_once 'vendor/gabordemooij/redbean/Redbean/redbean.inc.php';
R::setup('mysql:host=localhost; dbname=slimfromscratch','root','root');

$visitor = R::dispense('visitor');
$data = $app->request();
$visitor->ip = $data->getIp();
$visitor->pathInfo = $data->getPathInfo();
$visitor->hostWithPort = $data->getHostWithPort();
$visitor->userAgent = $data->getUserAgent();
$visitor->referrer = $data->getReferrer();
$visitor->time = time();
$visitor->date = date('l jS \of F Y h:i:s A');
$id = R::store($visitor);

// ROUTES //

function getMenuData() {
    $navigation = array(
    array('href' => './', 'caption' => 'Home', 'class'=>''),
    array('href' => './data', 'caption' => 'Data', 'class'=>''),
    array('href' => './services', 'caption' => 'Services', 'class'=>''),
    array('href' => './downloads', 'caption' => 'Downloads', 'class'=>''),
    array('href' => './about', 'caption' => 'About', 'class'=>''),
    array('href' => './contact', 'caption' => 'Contact', 'class'=>'')
    );
    return $navigation;
}

$app->get('/', function() use ($twig){
    $template = $twig->loadTemplate('home.html');
    $navigation = getMenuData();
    $navigation[0] = array('href' => './', 'caption' => 'Home', 'class'=>'active');
    $buffer = $template->render(array('navigation'=>$navigation));
    echo $buffer;
});

$app->get('/home', function() use ($twig){
    $template = $twig->loadTemplate('home.html');
    $navigation = getMenuData();
    $navigation[0] = array('href' => './home', 'caption' => 'Home', 'class'=>'active');
    $buffer = $template->render(array('navigation'=>$navigation));
    echo $buffer;
});

$app->get('/data', function() use ($twig){
    $template = $twig->loadTemplate('home.html');
    $navigation = getMenuData();
    $navigation[1] = array('href' => './data', 'caption' => 'Data', 'class'=>'active');
    $buffer = $template->render(array('navigation'=>$navigation));
    echo $buffer;
});

$app->get('/services', function() use ($twig){
    $template = $twig->loadTemplate('home.html');
    $navigation = getMenuData();
    $navigation[2] = array('href' => './services', 'caption' => 'Services', 'class'=>'active');
    $buffer = $template->render(array('navigation'=>$navigation));
    echo $buffer;
});

$app->get('/downloads', function() use ($twig){
    $template = $twig->loadTemplate('home.html');
    $navigation = getMenuData();
    $navigation[3] = array('href' => './downloads', 'caption' => 'Downloads', 'class'=>'active');
    $buffer = $template->render(array('navigation'=>$navigation));
    echo $buffer;
});

$app->get('/about', function() use ($twig){
    $template = $twig->loadTemplate('home.html');
    $navigation = getMenuData();
    $navigation[4] = array('href' => './about', 'caption' => 'About', 'class'=>'active');
    $buffer = $template->render(array('navigation'=>$navigation));
    echo $buffer;
});

$app->get('/contact', function() use ($twig){
    $template = $twig->loadTemplate('home.html');
    $navigation = getMenuData();
    $navigation[5] = array('href' => './contact', 'caption' => 'Contact', 'class'=>'active');
    $buffer = $template->render(array('navigation'=>$navigation));
    echo $buffer;
});


$app->run();