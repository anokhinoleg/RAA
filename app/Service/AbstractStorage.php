<?php

namespace Service;

use Core\Database;

class AbstractStorage
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @return Database
     */
    public function getDatabase()
    {
        return $this->database;
    }
}