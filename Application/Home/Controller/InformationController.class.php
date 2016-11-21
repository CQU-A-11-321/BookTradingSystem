<?php

namespace Home\Controller;
use Think\Controller;
class InformationController extends BaseController
{
    public function indexPage(){
//        dump(session('user'));
//        dump(session('userinfo'));
        $this->display("successLogin");
    }

    public function bookInfoPage(){
        $this->display();
    }

    public function myInfoPage(){
//        $User = M('user');
//        $UserInfo = M('userinfo');
//        $result = $User->where("uniqueid=%s", session('userid'))->select();
//        $info = $UserInfo->where("uniqueid=%s", $result[0]['userinfoid'])->select();
        $data = array(
            'name' => session('user')['name'],
            'tel' => session('userinfo')['tel'],
            'email' => session('userinfo')['email'],
            'money' => session('userinfo')['money'],
            'zipcode' => session('userinfo')['zipcode'],
            'address' => session('userinfo')['address']
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
//        $User = M('user');
//        $UserInfo = M('userinfo');
//        $result1 = $User->where("uniqueid=%s", session('userid'))->select();
//        $result2 = $UserInfo->where("uniqueid=%s", $result1[0]['userinfoid'])->select();
        $data = array(
            'name' => session('user')['name'],
            'tel' => session('userinfo')['tel'],
            'email' => session('userinfo')['email'],
            'money' => session('userinfo')['money'],
            'zipcode' => session('userinfo')['zipcode'],
            'address' => session('userinfo')['address']
        );
//        dump($data);
        $this->assign("data", $data);
        $this->display();
    }

    public function submitInfo(){
        $userData = array(
            'name' => $_POST['name']
        );
        $userInfoData = array(
            'address' => $_POST['address'],
            'tel' => $_POST['tel'],
            'email' => $_POST['email'],
            'money' => $_POST['money'],
            'zipcode' => $_POST['zipcode']
        );
        $User = M('user');
        $UserInfo = M('userinfo');

        $User->where("uniqueid=%s", session('user')['uniqueid'])->save($userData);
        $UserInfo->where("uniqueid=%s", session('userinfo')['uniqueid'])->save($userInfoData);

        $session1 = $User->where("uniqueid=%s", session('user')['uniqueid'])->select()[0];
        $session2 = $UserInfo->where("uniqueid=%s", session('userinfo')['uniqueid'])->select()[0];

//        dump($session1);
//        dump($session2);
        session('user', $session1);
        session('userinfo', $session2);

        $this->success("修改成功", "myInfoPage");
    }

}