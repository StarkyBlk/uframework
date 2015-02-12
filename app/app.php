<?php

require __DIR__ . '/../vendor/autoload.php';
use Http\Request;
use Model\FinderInterface;

// Config
$debug = true;


$dbname = 'uframework';
$host = 'localhost';
$user = 'uframework';
$password = 'passw0rd';
$dsn = 'mysql:dbname=' . $dbname . ';host=' . $host;
$connection = new Model\Connection($dsn, $user, $password);

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);

$serialize = function (Request $request, $data, $tpl) use ($app) {
	switch($request->guessBestFormat()) {
		case 'json':
			return json_encode($data);		
		default:
			return $app->render($tpl, $data);
	}
};

/**
 * Index
 */
$app->get('/', function () use ($app) {
	$app->redirect('/statuses');
});

$app->get('/statuses', function(Request $request) use ($app, $serialize, $connection) {
	$statuses = new Model\StatusFinder($connection);
	$limit = $request->getParameter('limit', FinderInterface::LIMIT);
	$offset = $request->getParameter('offset', FinderInterface::OFFSET);
	return $serialize($request, ['statuses' => $statuses->findAll($limit, $offset) ], 'statuses.php');
});

$app->get('/statuses/(\d+)', function(Request $request, $id) use ($app, $serialize, $connection){
	$statuses = new Model\StatusFinder($connection);
	if(null === $status = $statuses->findOneById($id)){
		throw new Exception\HttpException(404,"Status introuvable");
	}
	return $serialize($request, ['status' => $status], 'status.php');
});

$app->post('/statuses', function (Request $request) use ($app, $connection) {
	$mapper = new Model\StatusMapper($connection);
	$browser = explode(" ", (explode("/", $_SERVER['HTTP_USER_AGENT'])[2]));
	$browser = end($browser);
	$status = new Model\Status($request->getParameter('message'), new DateTime(date("Y-m-d H:i:s")), $browser, null, isset($_SESSION['user']) ? $_SESSION['user']->getId() : null, null);
	$mapper->persist($status);
	$app->redirect('/statuses');
});

$app->delete('/statuses/(\d+)', function (Request $request, $id) use ($app, $connection) {
	$statuses = new Model\StatusFinder($connection);
	$mapper = new Model\StatusMapper($connection);
	$mapper->remove($statuses->findOneById($id));
	return $app->redirect('/statuses');
});

$app->get('/mystatuses', function(Request $request) use ($app, $serialize, $connection) {
	$statuses = new Model\StatusFinder($connection);
	$limit = $request->getParameter('limit', FinderInterface::LIMIT);
	$offset = $request->getParameter('offset', FinderInterface::OFFSET);
	return $serialize($request, ['statuses' => $statuses->findAllByUserId($_SESSION['user']->getId() ,$limit, $offset) ], 'myStatuses.php');
});

$app->get('/login', function (Request $request) use ($app) {
	return $app->render('login.php');
});

$app->post('/login', function (Request $request) use ($app, $connection) {
	$userFinder = new Model\UserFinder($connection);
	$username = $request->getParameter('username');
    $password = $request->getParameter('password');
    if(null === $user = $userFinder->findOneByUserNamePassword($username,$password)){
		throw new Exception\HttpException(403,"Nom d'utilisateur ou mot de passe incorrect");
	}
	$_SESSION['is_authenticated'] = true;
	$_SESSION['user'] = $user;
	return $app->redirect('/');
});

$app->get('/signin', function (Request $request) use ($app) {
	return $app->render('signin.php');
});

$app->post('/signin', function (Request $request) use ($app, $connection) {
	$mapper = new Model\UserMapper($connection);
	$userFinder = new Model\UserFinder($connection);
	$username = $request->getParameter('username');
    $password = $request->getParameter('password');
	$passwordHash = password_hash($password, PASSWORD_DEFAULT);
	$user = new Model\User($username, $passwordHash, new DateTime(date("Y-m-d H:i:s")));
	$newUser = $mapper->persist($user);
	if($newUser){
		$_SESSION['is_authenticated'] = true;
		$_SESSION['user'] = $userFinder->findOneByUserNamePassword($username,$password);
		return $app->redirect('/');
	}
	throw new Exception\HttpException(400,"Utilisateur deja existant");
});


$app->get('/logout', function (Request $request) use ($app) {
    session_destroy();
    $app->redirect('/');
});

$app->addListener('process.before', function(Request $req) use ($app) {
    session_start();
    $allowed = [
        '/login' => [ Request::GET, Request::POST ],
        '/logout' => [ Request::GET, Request::POST ],
        '/signin' => [ Request::GET, Request::POST ],
        '/statuses' => [ Request::GET, Request::POST ],
        '/statuses/(\d+)' => [ Request::GET, Request::POST ],
        '/' => [ Request::GET ],
    ];
    if (isset($_SESSION['is_authenticated']) && true === $_SESSION['is_authenticated']) {
        return;
    }

    foreach ($allowed as $pattern => $methods) {
        if (preg_match(sprintf('#^%s$#', $pattern), $req->getUri()) && in_array($req->getMethod(), $methods)) {
            return;
        }
    }

    switch ($req->guessBestFormat()) {
        case 'json':
            throw new HttpException(401);
    }

    return $app->redirect('/login');
});


return $app;
