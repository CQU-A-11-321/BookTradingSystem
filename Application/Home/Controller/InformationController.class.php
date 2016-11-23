<?php

namespace Home\Controller;
use Think\Controller;
class InformationController extends BaseController
{
    public function indexPage(){
        $this->display("successLogin");
    }

    public function bookInfoPage($shopitemId){
        $Shopitem = M('shopitem');
        $shopitem = $Shopitem->find($shopitemId);
        $this->assign('shopname', $shopitem['shopname']);
        $Book = M('book');
        $book = $Book->find($shopitem['bookid']);
        $this->assign('book', $book);

        $link = "/BookTradingSystem/Home/Information/bookshopInfoPage/shopId/" . $shopitem['shopid'];
        $this->assign('link', $link);
        $this->display();
    }

    public function myInfoPage(){
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

    public function bookshopInfoPage($shopId){
        $Shop = M('shop');
        $info = $Shop->find($shopId);
        $Shopitem = M('shopitem');
        $bookidList = $Shopitem->where("shopid=%s", $shopId)->getField('bookid', true);
        $Book = M('book');
        $index = 0;
        foreach ($bookidList as $id){
            $result = $Book->find($id);
            $list[$index]['name'] = $result['name'];
            $list[$index]['author'] = $result['author'];
            $index++;
        }
//        dump($list);
        $this->assign('list', $list);
        $this->display();
    }

    public function orderInfoPage(){
        $this->display();

    }

    public function contaceusInfoPage(){
        $this->display();

    }

    public function improveInfoPage(){
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