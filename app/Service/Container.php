<?php

namespace Service;

use Core\Database;

class Container
{
    private $database;

    private $formHandler;

    private $request;

    private $storage;

    private $userLoader;

    /**
     * @return Request
     */
    private function getRequest()
    {
        if ($this->request == null) {
            $this->request = new Request($_POST);
        }
        return $this->request;
    }

    /**
     * @return Database
     */
    public function getDatabase()
    {
        if ($this->database == null) {
            $this->database = new Database(CONFIG);
        }
        return $this->database;
    }

    /**
     * @return FormHandler
     */
    public function getFormHandler()
    {
        if ($this->formHandler == null) {
            $this->formHandler = new FormHandler($this->getRequest());
        }
        return $this->formHandler;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getStorage($name)
    {
        $name = ucfirst($name);
        if ($this->storage == null) {
            $storageClass = 'Service\\' . $name . 'Storage';
            $this->storage = new $storageClass($this->getDatabase());
        }
        return $this->storage;
    }

    /**
     * @return UserLoader
     */
    public function getUserLoader()
    {
        if ($this->userLoader == null) {
            $this->userLoader = new UserLoader($this->getStorage('user'));
        }
        return $this->userLoader;
    }
}