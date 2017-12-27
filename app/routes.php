<?php

use Symfony\Component\HttpFoundation\Request;
use MicroCMS\Domain\Comment;
use MicroCMS\Domain\Article;
use MicroCMS\Domain\User;
use MicroCMS\Form\Type\CommentType;
use MicroCMS\Form\Type\ArticleType;
use MicroCMS\Form\Type\UserType;

// Home page
$app->get('/', "MicroCMS\Controller\HomeController::indexAction")->bind('home');

// pour obtenir le hachage d'un mot de passe
/*
$app->get('/hashpwd', function() use ($app) {
    $rawPassword = 'secret';
    $salt = '%qUgq3NAYfC1MKwrW?yevbE';
    $encoder = $app['security.encoder.bcrypt'];
    return $encoder->encodePassword($rawPassword, $salt);
});
*/

// Article details with comments
// $app->match afin de gérer à la fois l'accès à cette route via les commandes HTTP GET et POST 
$app->match('/article/{id}', "MicroCMS\Controller\HomeController::articleAction")->bind('article');

// Login form
$app->get('/login', "MicroCMS\Controller\HomeController::loginAction")->bind('login');

// Admin home page
$app->get('/admin', "MicroCMS\Controller\AdminController::indexAction")->bind('admin');

// Add a new article
$app->match('/admin/article/add', "MicroCMS\Controller\AdminController::addArticleAction")->bind('admin_article_add');

// Edit an existing article
$app->match('/admin/article/{id}/edit', "MicroCMS\Controller\AdminController::editArticleAction")->bind('admin_article_edit');

// Remove an article
$app->get('/admin/article/{id}/delete', "MicroCMS\Controller\AdminController::deleteArticleAction")->bind('admin_article_delete');

// Edit an existing comment
$app->match('/admin/comment/{id}/edit', "MicroCMS\Controller\AdminController::editCommentAction")->bind('admin_comment_edit');

// Remove a comment
$app->get('/admin/comment/{id}/delete', "MicroCMS\Controller\AdminController::deleteCommentAction")->bind('admin_comment_delete');

// Add a user
$app->match('/admin/user/add', "MicroCMS\Controller\AdminController::addUserAction")->bind('admin_user_add');


// Edit an existing user
$app->match('/admin/user/{id}/edit', "MicroCMS\Controller\AdminController::editUserAction")->bind('admin_user_edit');

// Remove a user
$app->get('/admin/user/{id}/delete', "MicroCMS\Controller\AdminController::deleteUserAction")->bind('admin_user_delete');

// API : get all articles
$app->get('/api/articles', "MicroCMS\Controller\ApiController::getArticlesAction")->bind('api_articles');

// API : get an article
$app->get('/api/article/{id}', "MicroCMS\Controller\ApiController::getArticleAction")->bind('api_article');

// API : create a new article
$app->post('/api/article', "MicroCMS\Controller\ApiController::addArticleAction")->bind('api_article_add');

// API : delete an existing article
$app->delete('/api/article/{id}', "MicroCMS\Controller\ApiController::deleteArticleAction")->bind('api_article_delete');

/*
Le contrôleur associé utilise la classe SymfonyRequest pour afficher la vue login.html.twig en lui passant en paramètres l'éventuelle dernière erreur de sécurité (par exemple un utilisateur non reconnu) et le dernier nom d'utilisateur utilisé.
Cette nouvelle route est nommée login grâce à l'appel de la méthode bind. Sans cela, l'appel à la fonctionpath('login') dans un template Twig provoquera une erreur
*/