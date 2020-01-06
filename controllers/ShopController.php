<?php
require_once "../models/ShopModel.php";
require_once "requests/Validator.php";

class ShopController extends ShopModel
{

    public function controller($action, $data = NULL, $id = NULL)
    {

        if (isset($action)) {
            switch ($action) {
                case 'create':
                    $val = new Validation();
                    $val->name('name')->value($data['name'])->required();
                    $val->name('city_id')->value($data['city_id'])->required();
                    $val->name('city_id')->value($data['city_id'])->pattern('int')->required();

                    if($val->isSuccess()){
                        $this->create($data);
                        header("location: ../views/shop.php"); exit;
                    }else{
                      session_start();
                      $_SESSION['CreateShopError'] = $val->getErrors();
                      header("location: ../views/createShop.php"); exit;
                    }
                    break;
                case 'update':

                    $val = new Validation();
                    $val->name('name')->value($data['name'])->required();
                    $val->name('city_id')->value($data['city_id'])->required();
                    $val->name('city_id')->value($data['city_id'])->pattern('int')->required();

                    if($val->isSuccess()){
                        $this->update($data);
                        header("location: ../views/shop.php"); exit;
                    }else{
                        session_start();
                        $_SESSION['UpdateShopError'] = $val->getErrors();
                        header("location: ../views/updateShop.php?id=". $data['id']); exit;
                    }
                    break;

                case 'delete':
                    $this->delete($id);
                    header("location: ../views/shop.php"); exit;
                    break;
            }
        } else {
            header("location: ../views/shop.php");
            exit;
        }
    }
}


$loginController = new ShopController();
$loginController->controller($_GET['action'], $_POST, isset($_GET['id']) ? $_GET['id'] : null);