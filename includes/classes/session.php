<?php 

class Session
{
    private $signed_in = false;
    public $user_id;
    public $message;


    public function __construct()
    {
        session_start();
        $this->checkLogin();
        $this->checkMessage();
    }


    public function message($msg = "")
    {
        if(!empty($msg))
        {
            $_SESSION['message'] = $msg;
        } else {
            return $this->message;
        }
    }


    private function checkMessage()
    {
        if(isset($_SESSION['message']))
        {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }


    private function checkLogin()
    {
        if(isset($_SESSION['user_id']))
        {
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        } else {
            unset($this->user_id);
            $this->signed_in = false;
        }
    }


    public function isSignedIn()
    {
        return $this->signed_in;
    }


    public function login($user)
    {
        if($user)
        {
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->signed_in = true;
        }
    }


    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
    }
}//END