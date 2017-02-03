<?php
namespace MyBarter\controllers;
use MyBarter\lib\Controller;
use MyBarter\lib\Session;
use MyBarter\models\Contact;

class ContactsController extends Controller
{
    public function __construct($data=array())
    {
        parent::__construct($data);
        $this->model=new Contact();
    }
    public function index()
    {
        if($_POST){
            if($this->model->save($_POST)){
                Session::setFlash('Ваше сообщение было успешно отправлено!');
            }
        }
    }

    public function admin_index()
    {
        $this->data=$this->model->getList();
    }
}