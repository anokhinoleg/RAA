<?php

namespace Service;

class CountryStorage extends AbstractStorage
{
    public function findAllCountries()
    {
        $pdo = $this->getDatabase()->getPDO();
        $statement = $pdo->prepare("SELECT * FROM countries");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}