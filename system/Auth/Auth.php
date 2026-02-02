<?php

namespace System\Auth;

use App\User;
use System\Session\Session;


class Auth
{
   
    private $redirectTo = "/login";

    private function userMethod()
    {
      if(!(new Session)->get('user'))
      {
          return redirect($this->redirectTo);
      }
      $user = User::find((new Session)->get('user'));
      if(empty($user))
      {
          (new Session)->remove('user');
          return redirect($this->redirectTo);
      }
      else
      return $user;
    }

    private function checkMethod()
    {
        if(!(new Session)->get('user'))
        {
            return redirect($this->redirectTo);
        }
        $user = User::find((new Session)->get('user'));
        if(empty($user))
        {
            (new Session)->remove('user');
            return redirect($this->redirectTo);
        }
        else
        return true;
    }

    private function checkLoginMethod()
    {
        if(!(new Session)->get('user'))
        {
            return false;
        }
        $user = User::find((new Session)->get('user'));
        if(empty($user))
        {
           return false;
        }
        else
        return true;
    }

    private function loginByEmailMethod($email, $password)
    {
        $user = User::where('email', $email)->get();
        if(empty($user))
        {
            error('login', 'کاربر وجود ندارد');
            return false;
        }
        if(password_verify($password, $user[0]->password) && $user[0]->is_active == 1)
        {
            (new Session)->set("user", $user[0]->id);
            return true;
        }
        else
        {
            error("login", 'کلمه ی عبور اشتباه است');
            return false;
        }
    }

    private function loginByIdMethod($id)
    {
        $user = User::find($id);
        if(empty($user))
        {
            error("login", "کاربر وجود ندارد");
            return false;
        }
        else
        {
            (new Session)->set("user", $user->id);
            return true;
        }
    }

    private function logoutMethod()
    {
        (new Session)->remove('user');
    }

    public function __call($name, $arguments)
    {
        return $this->methodCaller($name, $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        $instance = new self();
        return $instance->methodCaller($name, $arguments);
    }

    private function methodCaller($method, $arguments)
    {
        $suffix = 'Method';
        $methodName = $method.$suffix;
        return call_user_func_array(array($this, $methodName), $arguments);
    }
}