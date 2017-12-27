<?php

namespace MicroCMS\DAO;

use Doctrine\DBAL\Connection;

/*
Nous factorisons ces besoins communs au sein d'une classe abstraite DAO dont hériteront toutes nos classes d'accès aux données.
Si vous avez besoin de détails sur l'héritage ou les autres concepts de la programmation orientée objet, consultez ce cours.
*/

abstract class DAO 
{
    /**
     * Database connection
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * Constructor
     *
     * @param \Doctrine\DBAL\Connection The database connection object
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * Grants access to the database connection object
     *
     * @return \Doctrine\DBAL\Connection The database connection object
     */
    protected function getDb() {
        return $this->db;
    }

    /**
     * Builds a domain object from a DB row.
     * Must be overridden by child classes.
     */
    protected abstract function buildDomainObject(array $row);
}
/*
La connexion à la base de données est encapsulée sous la forme d'une propriété privée $db et d'un accesseur protégé (donc accessible uniquement aux classes dérivées) getDb.
La construction d'un objet du domaine est spécifique à chaque entité métier : on factorise donc uniquement la déclaration de ce service (méthode protégéebuildDomainObject).
Chaque classe d'accès aux données devra redéfinir cette méthode pour consstruire un objet du domaine particulier.
*/