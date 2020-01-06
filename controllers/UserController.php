<?php
require_once "../models/UserModel.php";
require_once "requests/Validator.php";

class UserController extends UserModel {

    public function controller($action, $data = NULL, $id = NULL){

        if (isset($action)){
            switch ($action) {
                case 'create':
                    $val = new Validation();
                    $val->name('name')->value($data['name'])->required();
                    $val->name('password')->value($data['password'])->min(5)->required();
                    $val->name('email')->value($data['email'])->required();

                    if($val->isSuccess()){
                        $this->create($data);
                        header("location: ../views/users.php"); exit;
                    }else{
                        session_start();
                        $_SESSION['CreateUserError'] = $val->getErrors();
                        header("location: ../views/createUser.php"); exit;
                    }
                    break;

                case 'update':

                    $val = new Validation();
                    $val->name('name')->value($data['name'])->required();
                    $val->name('email')->value($data['email'])->required();

                    if($val->isSuccess()){
                        $this->update($data);
                        header("location: ../views/users.php"); exit;
                    }else{
                        session_start();
                        $_SESSION['UpdateUserError'] = $val->getErrors();
                        header("location: ../views/updateUser.php?id=". $data['id']); exit;
                    }
                break;

                case 'delete':
                    $this->delete($id);
                    header("location: ../views/users.php"); exit;
                    break;

                case 'userDropdown':
                    $this->userDropdown($data);
                    break;

                case 'shopsDropdown':
                    $this->shopsDropdown($data);
                    break;
            }
        }
        else{
            header("location: ../views/dashboard.php"); exit;
        }
    }
}


$userController = new UserController();
$userController->controller($_GET['action'], $_POST, isset($_GET['id']) ? $_GET['id'] : null);