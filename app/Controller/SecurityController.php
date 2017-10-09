<?php

namespace Controller;

use Core\Controller;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $formHandler = $this->getContainer()->getFormHandler();
        if (isset($_SESSION['user'])) {
            return $this->redirectToRoute('./');
        }

        if ($formHandler->isSubmitted()) {
            $user = $formHandler->getData();
            $database = $this->getContainer()->getDatabase();
            try {
                if ($database->isValidLogin($user)) {
                    $_SESSION['user'] = $user['login'];
                    return $this->redirectToRoute('./');
                }
            } catch (\Exception $e) {
                $_SESSION['last_user'] = $user['login'];
                $_SESSION['message'] = $e->getMessage();
                return $this->redirectToRoute('login');
            }

        }
        return $this->render('/login.html');
    }

    public function logoutAction()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
            return $this->redirectToRoute('login');
        }
    }
}