<?php

namespace Core;

use PDO;

class Database
{
    private $configuration;

    private $pdo;

    public function __construct(array $configuration) {
        $this->configuration = $configuration;
    }

    /**
     * @return PDO
     */
    public function getPDO() {
        if ($this->pdo == null) {
            $this->pdo = new PDO(
                    $this->configuration['db_dsn'],
                    $this->configuration['db_user'],
                    $this->configuration['db_pass']
                );
        }
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->pdo;
    }

    /**
     * @param array $userData
     * @return bool
     * @throws \Exception
     */
    public function isUserAlreadyExist(array $userData) {
        $pdo = $this->getPDO();
        $statement = $pdo->prepare("SELECT * FROM registered_users WHERE email = :email  OR username = :username LIMIT 1");
        $statement->execute(array('email' => $userData['email'], 'username' => $userData['username']));
        if ($statement->rowCount() > 0) {
            throw new \Exception('User with such email/username is already exist');
        }
        return false;
    }

    public function saveUserToDatabase(array $data)
    {
        $date = new \DateTime();
        $date = $date->getTimestamp();
        $data['created_at'] = $date;
        $pdo = $this->getPDO();
        $statement = "INSERT INTO registered_users (";
        $statement .= "email, username, password, full_name, birth_date, country_id, created_at";
        $statement .= ") VALUES (";
        $statement .= ":email, :username, :password, :full_name, :birth_date, :country_id, :created_at)";
        $statement = $pdo->prepare($statement);
        $statement->execute($data);
    }

    private function findByLogin($login) {
        $pdo = $this->getPDO();
        $statement = $pdo->prepare("SELECT * FROM registered_users WHERE email = :email OR username = :username LIMIT 1");
        $statement->execute(array('email' => $login, 'username' => $login));
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    /**
     * @param array $loginData
     * @return bool
     * @throws \Exception
     */
    public function isValidLogin(array $loginData)
    {
        $foundUser = $this->findByLogin($loginData['login']);
        if (!$foundUser) {
            throw new \Exception('Inncorrect login/password. Try Again');
        }

        if ($foundUser['password'] === $loginData['password']) {
            return true;
        }
        throw new \Exception('Inncorrect login/password. Try Again');
    }
}