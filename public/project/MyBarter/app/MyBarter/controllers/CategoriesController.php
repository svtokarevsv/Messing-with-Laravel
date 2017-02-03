<?php
namespace MyBarter\controllers;
use MyBarter\lib\AdForm;
use MyBarter\lib\ContactForm;
use MyBarter\lib\Controller;
use MyBarter\lib\Router;
use MyBarter\lib\Session;
use MyBarter\models\Category;

class CategoriesController extends Controller
{
    public function __construct($data=array())
    {
        parent::__construct($data);
        $this->model=new Category();
    }
    public function index()
    {
        $this->data['categories']= $this->model->getCategories();
    }

    public function getlist()
    {
        $this->data['regions']=$this->model->getRegions();

        $this->data['categories']=$this->model->getCategories();
        $this->data['ads']=$this->model->getAds();
        $this->data['pagination']=$this->model->getPagination();
    }

    public function show()
    {
        $this->data['categories']=$this->model->getCategories();
        $this->data['ad']=$this->model->getAdByAdID($this->model->extractId($this->params[0]));
        $this->data['other_ads']=$this->model->getAds( $this->data['ad']['id_user']);
        $contactform = new ContactForm($_POST, $this->model,$this->data['ad']['id'],$this->data['ad']['title'],Session::get('id'),$this->data['ad']['id_user']);
    }

    public function edit()
    {
        $this->data['ad']=$this->model->getAdByAdID($this->model->extractId($this->params[0]));
        if($this->data['ad']['id_user']!=Session::get('id') OR Session::get('role'!='2')OR Session::get('role'!='1'))Router::redirect (PRELINK);
        $this->data['categories']=$this->model->getCategories();
        $this->data['regions']=$this->model->getRegions();
        $this->data['user']=$this->model->userInfo($this->data['ad']['id_user']);
        $form=new AdForm($_POST,$this->model,$this->data['ad']);

    }
    public function archive()
    {
        Session::get('username') ?: Router::redirect(PRELINK . 'users/login');
        $this->data['ad']=$this->model->getAdByAdID((int)$this->params[0]);
        if($this->data['ad']['id_user']!=Session::get('id') OR Session::get('role'!='2')OR Session::get('role'!='1'))Router::redirect (PRELINK);
        if (isset($this->params[0])) {
            $result = $this->model->deactivateAd($this->data['ad']['id'], $this->data['ad']['id_user']);
            if ($result) {
                Session::setFlash('Объявление было перемещено в архив');

            } else {
                Session::setErrorFlash('Ошибка');
            }
        }else
            Router::redirect(PRELINK);
        Router::redirect(PRELINK."users/current");
    }


    public function add_new_ad()
    {
        Session::get('username') ?  : Router::redirect(PRELINK . 'users/login');
        $form=new AdForm($_POST,$this->model);
        $this->data['regions']=$this->model->getRegions();
        $this->data['categories']=$this->model->getCategories();
        $this->data['user']=$this->model->userInfo(Session::get('id'));
//        var_dump($_POST);

    }
}