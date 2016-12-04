<?php

namespace Home\Controller;
use Think\Controller;
class InformationController extends BaseController
{
    /**
     *
     */
    public function indexPage(){
        $Shopitem = M('shopitem');
        $Book = M('book');
        $shopitems = $Shopitem->select();
        $index = 0;
        foreach ($shopitems as $item) {
            $book = $Book->find($item['bookid']);
            $list[$index]['name'] = $book['name'];
            $list[$index]['author'] = $book['author'];
            $list[$index]['price'] = $book['price'];
            $list[$index]['bookid'] = $book['uniqueid'];
            $list[$index]['bookshopid'] = $item['shopid'];
            $list[$index]['link'] = "bookInfoPage?bookid=" . $book['uniqueid'] . "&bookshopid=" . $item['shopid'];
            $index++;
        }
//        dump($list);
        $this->assign('list', $list);

        $BookShop = M('shop');
        $bookshopid = $BookShop->where("userid=%s", session('user')['uniqueid'])->getField('uniqueid');
        $link = "bookshopInfoPage?bookshopid=" . $bookshopid;
        $this->assign('link', $link);
        session('link', $link);
        $this->display("successLogin");
    }

    public function bookInfoPage($bookid, $bookshopid){
        $Book = M('book');
        $book = $Book->find($bookid);
        $Bookshop = M('shop');
        $shop = $Bookshop->find($bookshopid);
        $this->assign('book', $book);
        $this->assign('shopname', $shop['shopname']);
        $link = "bookshopInfoPage?bookshopid=" . $bookshopid;
        $this->assign('link', $link);
        $this->assign('toAdd', "addToCart?bookid=" . $bookid . "&bookshopid=" . $bookshopid);
        $this->assign('buy', "/BookTradingSystem/Home/Trade/tradePage?bookid=" . $bookid . "&bookshopid=" . $bookshopid);

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
        $this->assign('link', session('link'));
        $this->display();
    }

    public function bookshopInfoPage($bookshopid){
        $Bookshop = M('shop');
        $shop = $Bookshop->where("uniqueid=%s", $bookshopid)->getField('shopname');
        $this->assign('bookshopname', $shop);

        $Shopitem = M('shopitem');
        $shopitems = $Shopitem->where("shopid=%s", $bookshopid)->select();

//        dump($shopitems);
        $Book = M('book');

        $index = 0;
        foreach ($shopitems as $item) {
            $list[$index]['name'] = $Book->where("uniqueid=%s", $item['bookid'])->getField('name');
            $list[$index]['author'] = $Book->where("uniqueid=%s", $item['bookid'])->getField('author');
            $list[$index]['price'] = $Book->where("uniqueid=%s", $item['bookid'])->getField('price');
            $list[$index]['link'] = "bookInfoPage?bookid=" . $item['bookid'] . "&bookshopid=" . $bookshopid;
            $index++;
        }
//        dump($list);
        $this->assign('list', $list);

        $id = $Bookshop->where("userid=%s", session('user')['uniqueid'])->getField('uniqueid');
        $this->assign('flag', "1");
        if ($id != $bookshopid) {
            $another = "<li> <a href=" . session('link') . "> 我的书店 </a> </li>";
            $this->assign('another', $another);
            $this->assign('flag', "0");
        }

        $this->display();
    }

    public function orderInfoPage(){
        $Order = M('order');
        $list = $Order->where("userid=%s", session('user')['uniqueid'])->select();
        for ($i = 0; $i < sizeof($list); $i++) {
            $list[$i]['link'] = "orderInfoDetail?orderid=" . $list[$i]['uniqueid'];
        }
//        dump($list);

        $this->assign('list', $list);
        $this->assign('link', session('link'));
        $this->display();

    }

    public function orderInfoDetail($orderid) {
        $Order = M('order');
        $orderinfo = $Order->find($orderid);
//        dump($orderinfo);

        if($orderinfo['state'] == "0") $orderinfo['state'] = "未付款";
        else $orderinfo['state'] = "已付款";

        $this->assign('data', $orderinfo);

        $this->assign('link', session('link'));
        $this->display();
    }

    public function contactusInfoPage(){

        $this->assign('link', session('link'));
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
        $this->assing('link', session('link'));
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

        $this->updateUserInfoToEachTable();
        $this->success("修改成功", "myInfoPage");
    }

    public function addToCart($bookid, $bookshopid) {
        $Order = M('order');
        $uniqueid = $Order->count();
        $uniqueid++;
        $data = array(
            'uniqueid' => $uniqueid,
            'userid' => session('user')['uniqueid'],
            'username' => session('user')['name'],
            'shopid' => $bookshopid,
            'shopname' => M('shop')->where("uniqueid=%s", $bookshopid)->getField('shopname'),
            'bookid' => $bookid,
            'bookname' => M('book')->where("uniqueid=%s", $bookid)->getField('name'),
            'totalmoney' => M('book')->where("uniqueid=%s", $bookid)->getField('price'),
            'address' => session('userinfo')['address'],
            'tel' => session('userinfo')['tel'],
            'email' => session('userinfo')['email'],
            'createdate' => date("Y-m-d H:i:s"),
            'state' => "0",
        );
        $Order->add($data);
        $this->success("添加购物车成功。");
    }

//    public function buy($bookid = 1, $bookshopid = 1) {
//        $this->redirect("Trade/tradePage", "bookid=" . $bookid . "&bookshopid=". $bookshopid);
//    }

    public function searchInfoPage() {
        $condition = $_POST['search'];
//        dump($condition);
        $Shopitem = M('shopitem');

        if ($condition == null) {
            $data = $Shopitem->select();
        }
        else {
            $map['bookname'] = array('like', '%' . $condition . '%');
            $data = $Shopitem->where($map)->select();
        }

        $Book = M('book');
        for ($i = 0; $i < sizeof($data); $i++) {
            $list[$i]['name'] = $data[$i]['bookname'];
            $list[$i]['aurhor'] = $Book->where("uniqueid=%s", $data[$i]['bookid'])->getField('author');
            $list[$i]['price'] = $Book->where("uniqueid=%s", $data[$i]['bookid'])->getField('price');
            $list[$i]['shopname'] = M('shop')->where("uniqueid=%s", $data[$i]['shopid'])->getField('shopname');
            $list[$i]['link'] = "bookInfoPage?bookid=" . $data[$i]['bookid'] . "&bookshopid=" . $data[$i]['shopid'];
        }

        $this->assign('list', $list);
        $this->assign('link', session('link'));

        $this->display();
    }

    public function rechargeInfoPage() {
        $this->assign('link', session('link'));
        $this->display();
    }

    public function recharge() {
        $money = $_POST['money'];
        $UserInfo = M('userinfo');
        $UserInfo->where("uniqueid=%s", session('userinfo')['uniqueid'])->setInc('money', $money);
        $session1 = $UserInfo->find(session('userinfo')['uniqueid']);
        session('userinfo', $session1);

        $this->assign('link', session('link'));
        $this->success("充值成功！");
    }

}