<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

require __DIR__ . '/vendor/autoload.php';

// Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Créer l'application Slim
$app = AppFactory::create();

// Configuration de Twig
$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

// Middleware pour la gestion des erreurs (utile pour le développement)
$app->addErrorMiddleware(true, true, true);

// Route de base
$app->get('/', function (Request $request, Response $response, $args) use ($twig) {
    $data = [
        'title' => 'Application PHP 8.4 pour Azure',
        'message' => 'Bienvenue sur votre application Slim/Twig prête pour Azure !',
        'php_version' => PHP_VERSION,
        'environment' => $_ENV['APP_ENV'] ?? 'development'
    ];
    $body = $twig->render('index.html.twig', $data);
    $response->getBody()->write($body);
    return $response;
});

// Route d'information
$app->get('/info', function (Request $request, Response $response, $args) {
    $response->getBody()->write("PHP Version: " . PHP_VERSION . "\n");
    $response->getBody()->write("Environment: " . ($_ENV['APP_ENV'] ?? 'development') . "\n");
    return $response;
});

$app->run();
