<?php

namespace Service;

class UserStorage extends AbstractStorage
{
    public function findAllUsers()
    {
        $pdo = $this->getDatabase()->getPDO();
        $statement = $pdo->prepare("SELECT * FROM registered_users");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}