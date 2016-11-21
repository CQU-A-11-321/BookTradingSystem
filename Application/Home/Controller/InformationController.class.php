<?php

namespace Home\Controller;
use Think\Controller;
class InformationController extends Controller
{
    public function bookInfoPage()
    {
        $this->display();
    }
//    http://localhost/BookTradingSystem/Home/Information/bookInfoPage.html
    public function getInfo() {
        $Data = M('shopitem');
        $result = $Data->select();
        $num = sizeof($result);
        $this->assign('bookdisplay');
    }
}