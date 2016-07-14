<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        
    }
    public function test()
    {
        $handle = D("article");
        print_r($handle->getCateList());


    }
}