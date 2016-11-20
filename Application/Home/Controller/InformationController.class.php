<?php

namespace Home\Controller;
use Think\Controller;
class InformationController extends BaseController
{
    public function indexPage(){
        $this->display("successLogin");
    }

    public function bookInfoPage()
    {
        $this->display();
    }

    public function myInfoPage(){
        $this->display();
    }

    public function bookshopInfoPage(){
        $this->display();

    }

    public function orderInfoPage(){
        $this->display();

    }

    public function contaceusInfoPage(){
        $this->display();

    }

    public function improveInfoPage(){
        $this->display();

    }

}