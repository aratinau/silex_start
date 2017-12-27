APP
===
- séparation des responsabilités selon le principe Modèle-Vue-Contrôleur ;
- intégration du micro-framework Silex ;
- modélisation objet du domaine et de l'accès aux données ;
- utilisation des espaces de noms et chargement automatique des classes grâce à Composer ;
- intégration du moteur de templates Twig pour faciliter l'écriture des vues ;
- présentation moderne et adaptée au terminal utilisé (responsive design) grâce au framework web Bootstrap ;
- gestion avancée de la sécurité et des formulaires ;
- back-office d'administration ;
- tests fonctionnels automatisés utilisant PHPUnit ;
- journalisation et gestion des erreurs ;
- API utilisant le format JSON ;
- validation des formulaires.


TODO
====

a la fin du tuto : push pour avoir un projet de base

- script d'install du projet :
	- choix du nom du projet pour le namespace
	- nom dans le phpunit.xml.dist
	- supprime les logs
	- choix du nom du fichier de log
	- nom de la database
	- titre du projet pour layout.html.twig
	- installe les vendor
- script d'install de BDD et autre sur le serveur

- fichier d'install
	- qui configure le fichier de config
	- install de la database
- fichier de config
	- nom database
	- user database
	- password database

- lorsque $env == 'prod' dans web/index.php
	-> alors activer les erreurs sur app/app.php
		$app->error(function (\Exception $e, Request $request, $code) use ($app) {

MEP
===

` bash
composer install --no-dev`

- modifier dans web/app/php $env = 'prod';

TEST
====

./vendor/bin/phpunit

API
===

Controller en tant que service
==============================

https://silex.symfony.com/doc/2.0/providers/service_controller.html

Liste complete des contraintes sur les formulaires
==================================================

https://symfony.com/doc/current/reference/constraints.html

Outil d'analyse de code source
==============================

https://insight.sensiolabs.com/

Aller plus loin
==============

Internationalisation
--------------------

 - https://silex.symfony.com/doc/2.0/providers/translation.html
