<?php
namespace MyBarter\controllers;
use MyBarter\lib\Controller;

class AboutController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
//        $this->model = new User();

    }

    public function index()
    {
        return 1;
    }
}
