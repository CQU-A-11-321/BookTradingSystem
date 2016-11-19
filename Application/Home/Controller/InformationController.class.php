<?php

namespace Home\Controller;
use Think\Controller;
class InformationController extends Controller
{
    public function bookInfoPage($name = 'think')
    {
        $this->display();
    }
//    http://localhost/BookTradingSystem/Home/Information/bookInfoPage.html
}