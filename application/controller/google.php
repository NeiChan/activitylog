<?php

/**
 * Class Google
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Google extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/songs/index
     */
    public function index()
    {

    }

    /**
     * AJAX-ACTION: ajaxInsertUser
     */
    public function Login()
    {
        session_start();

        $email      = $_POST['email'];

        $data = Array (
            'email'       =>  $email,
            'createdAt'   =>  date("Y-m-d H:i:s")
        );

//        print_r($data);

        $validate = $this->model->getUser($data["email"]);
        $getuserid = $this->model->getUserID($data["email"]);
        if($validate)
        {
            // User is found in DB
            $_SESSION['LoggedIn'] = true;
            $_SESSION['User']     = $getuserid['id'];
        }else{
            // New User Created
            $this->model->insertUser($data["email"], $data["createdAt"]);
            $_SESSION['LoggedIn'] = true;
            $_SESSION['User']     = $getuserid['id'];
        }
    }

    public function SignOut()
    {
        session_start();
        session_destroy();
    }
}
