<?php

namespace System\Request\Traits;

trait HasRunValidation
{
    protected function errorRedirect()
    {
        if($this->errorExist === false){
            return $this->request;
        }
        return back();
    }
    private function checkFirstError($name)
    {
        if(!$this->errorExist($name) && !in_array($name, $this->errorVariablesName)){
            return true;
        }
        return false;
    }
    private function checkFieldExist($name)
    {
        return isset($this->request[$name]) && !empty($this->request[$name]);
    }
    private function checkFileExist($name)
    {
        return isset($this->files[$name]['name']) && !empty($this->files[$name]['name']);
    }
    private function setError($name, $errorMessage)
    {
        $this->errorVariablesName[] = $name;
        $this->error($name, $errorMessage);
        $this->errorExist = true;
    }

    private function errorExist($name)
    {
        return in_array($name, $this->errorVariablesName);
    }

    protected function error(string $key, string $message): void
    {
        $this->errors[$key] = $message;
    }
}
