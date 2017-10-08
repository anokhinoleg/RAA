<?php

namespace Controller;

use Core\Controller;

class Error404Controller extends Controller
{
    public function error404Action()
    {
        return $this->render('/error404.html');
    }
}