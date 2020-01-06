<?php
require_once "../models/LoginModel.php";

class LoginController extends LoginModel{

    public function controller($action, $email, $password){

        if (isset($action)){
            switch ($action) {
                case 'login':
                    $this->login($email, $password);
                break;
                
                case 'logout':
                    $this->logout();
                break;
            }
        }
        else{
            header('location: ../index.php');
        }
    }
}

$loginController = new LoginController();
$loginController->controller($_GET['action'], $_POST['email'], $_POST['password']);
?>