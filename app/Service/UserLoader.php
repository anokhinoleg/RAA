<?php

namespace Service;

use Model\User;

class UserLoader
{
    private $userStorage;

    public function __construct(UserStorage $userStorage)
    {
        $this->userStorage = $userStorage;
    }

    /**
     * @return User[]
     */
    public function getUsers()
    {
        $users = [];
        $usersData = $this->queryForUsers();
        foreach ($usersData as $userData) {
            $users[] = $this->createUserFromData($userData);
        }
        return $users;
    }

    private function queryForUsers()
    {
        try {
            return $this->userStorage->findAllUsers();
        } catch (\Exception $e) {
            trigger_error('Database Exception! ' . $e->getMessage());
            return [];
        }
    }

    /**
     * @param $userData
     * @return User
     */
    private function createUserFromData($userData)
    {
        $user = new User();
        $user->setUsername($userData['username']);
        $user->setEmail($userData['email']);
        $user->setBirthDate($userData['birth_date']);
        $user->setFullName($userData['full_name']);
        return $user;
    }
}