<?php

namespace Controller;

use Core\Controller;

class UserController extends Controller
{
    public function registerAction()
    {
        $formHandler = $this->getContainer()->getFormHandler();
        $countries = $this->getContainer()->getStorage('country')
            ->findAllCountries();
        if ($formHandler->isSubmitted() && $formHandler->isValid()) {
            $user = $formHandler->getData();
            $database = $this->getContainer()->getDatabase();
            try {
                $database->isUserAlreadyExist($user);
            } catch (\Exception $e) {
                $_SESSION['message'] = $e->getMessage();
                return $this->redirectToRoute('/register');
            }
            $database->saveUserToDatabase($user);
            $_SESSION['user'] = $user['username'];
            return $this->redirectToRoute('/');
        }
        return $this->render('/register.html', [
            'errors' => json_encode($formHandler->getErrors()),
            'user' => json_encode($formHandler->getData()),
            'countries' => $countries
        ]);
    }
}