<?php

/*
On utilise ici require-dev pour définir les dépendances nécessaires uniquement pendant le développement.
Lors de la mise en production de l'application, on utilisera Composer avec l'option--no-dev pour ne pas installer ces dépendances.
*/

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
// Le service $app['db'] est défini automatiquement lors de l'enregistrement du fournisseur DoctrineServiceProvider.
$app->register(new Silex\Provider\DoctrineServiceProvider());

// Le service$app['twig'] est défini automatiquement lors de l'enregistrement du fournisseur TwigServiceProvider.
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views', // configuré pour que le répertoire dans lequel nous stockerons nos templates soit le répertoireviews du projet
));
$app['twig'] = $app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
});
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/', // pattern définit la partie sécurisée de l'application sous la forme d'une expression rationnelle. Ici, la valeur ^/ indique que le pare-feu sécurise l'intégralité de l'application
            'anonymous' => true, // anonymous précise qu'un utilisateur non authentifié peut tout de même accéder à la partie sécurisée. Il est nécessaire pour que les visiteurs anonymes puissent continuer à consulter les articles du CMS
            'logout' => true, // logout indique qu'il est possible pour les utilisateurs authentifiés de se déconnecter de l'application
            // form permet d'utiliser un formulaire comme méthode d'authentification
            // login_path définit le chemin vers le formulaire etcheck_path le chemin d'authentification 
            // users définit le fournisseur de données utilisateur, autrement dit la source de données qui permet d'accéder aux utilisateurs de l'application.
            // Ici, il s'agit logiquement d'une instance de la classe UserDAO créée précédemment.
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'), 
            'users' => function () use ($app) {
                return new MicroCMS\DAO\UserDAO($app['db']);
            },
        ),
    ),
    // mise à jour de la configuration de la sécurité pour soumettre l'accès au back-office (zone /admin) à la possession du rôle ROLE_ADMIN
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
    ),
));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/microcms.log',
    'monolog.name' => 'MicroCMS',
    'monolog.level' => $app['monolog.level']
));
// Register JSON data decoder for JSON requests
/*
Ce code intercepte toutes les requêtes reçues et, si son contenu est au format JSON, décode ce contenu et la définit comme paramètres de la requête.
Ainsi, les méthodes $request->request->get('title') et $request->request->get('content') de notre contrôleur permettront d'accéder aux données JSON.
*/
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

// Register error handler
if ($env == 'prod')
{
    $app->error(function (\Exception $e, Request $request, $code) use ($app) {
        switch ($code) {
            case 403:
                $message = 'Access denied.';
                break;
            case 404:
                $message = 'The requested resource could not be found.';
                break;
            default:
                $message = "Something went wrong.";
        }
        return $app['twig']->render('error.html.twig', array('message' => $message));
    });
}

// Register services.
$app['dao.article'] = function ($app) {
    return new MicroCMS\DAO\ArticleDAO($app['db']);
};
$app['dao.user'] = function ($app) {
    return new MicroCMS\DAO\UserDAO($app['db']);
};
$app['dao.comment'] = function ($app) {
    $commentDAO = new MicroCMS\DAO\CommentDAO($app['db']);
    $commentDAO->setArticleDAO($app['dao.article']);
    $commentDAO->setUserDAO($app['dao.user']);
    return $commentDAO;
};
