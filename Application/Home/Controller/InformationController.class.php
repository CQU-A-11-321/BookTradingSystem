<?php

namespace Home\Controller;
use Think\Controller;
class InformationController extends BaseController
{
    public function indexPage(){
        $this->display("successLogin");
    }

    public function bookInfoPage(){
        $this->display();
    }

    public function myInfoPage(){
        $User = M('user');
        $UserInfo = M('userinfo');
        $result = $User->where("uniqueid=%s", session('userid'))->select();
        $info = $UserInfo->where("uniqueid=%s", $result[0]['userinfoid'])->select();
        $data = array(
            'name' => $result[0]['name'],
            'tel' => $info[0]['tel'],
            'email' => $info[0]['email'],
            'money' => $info[0]['money'],
            'zipcode' => $info[0]['zipcode'],
            'address' => $info[0]['address']
        );
        $this->assign('data', $data);
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