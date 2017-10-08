<?php

namespace Controller;

use Core\Controller;

class HomeController extends Controller
{
    public function homeAction()
    {
        $users = $this->getContainer()->getUserLoader()
            ->getUsers();
        return $this->render('/home.html', [
            'users' => $users
        ]);
    }
}