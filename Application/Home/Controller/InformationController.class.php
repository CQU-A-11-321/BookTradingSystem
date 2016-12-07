<?php

namespace Home\Controller;
use Think\Controller;
class InformationController extends BaseController
{
    /**
     * 显示主页和搜索栏
     * @param
     */
    public function indexPage(){
        $Shopitem = M('shopitem');
        $Book = M('book');
        $map['shopid'] = array('neq', -1);
        $shopitems = $Shopitem->where($map)->select();
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
            if (index == 4) break;
        }
//        dump($list);
        $this->assign('list', $list);

        $BookShop = M('shop');
        $bookshopid = $BookShop->where("userid=%s", session('user')['uniqueid'])->getField('uniqueid');
        $link = "bookshopInfoPage?bookshopid=" . $bookshopid;
        $this->assign('link', $link);
        session('link', $link);
//        dump($link);
        $this->display("successLogin");
    }

    /**
     * 搜索页面
     * @param 图书名称
     * @return 图书列表
     */
    public function searchInfoPage() {
        $condition = $_POST['search'];
//        dump($condition);
        $Shopitem = M('shopitem');
        $map['shopid'] = array('neq', "-1");
        if ($condition == null) {
            $data = $Shopitem->where($map)->select();
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

    /**
     * 用户信息页面
     * @param 用户id
     * @return 用户信息列表
     */
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

    /**
     * 修改信息页面
     * @param 用户id
     * @return null
     */
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
        $this->assign('link', session('link'));
        $this->display();
    }

    /**
     * 提交用户信息并且修改数据库
     */
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

    /**
     * 充值页面
     */
    public function rechargeInfoPage() {
        $this->assign('link', session('link'));
        $this->display();
    }

    /**
     * 充值修改数据库
     * @param 金额
     */
    public function recharge() {
        $money = $_POST['money'];
        if ((int)$money < 0) {
            $this->error("输入金额错误，请重新输入！");
        }
        $UserInfo = M('userinfo');
        $UserInfo->where("uniqueid=%s", session('userinfo')['uniqueid'])->setInc('money', $money);
        $session1 = $UserInfo->find(session('userinfo')['uniqueid']);
        session('userinfo', $session1);

        $this->assign('link', session('link'));
        $this->success("充值成功！");
    }

    /**
     * 图书信息也或是商品信息
     * @param $bookid 图书id
     * @param $bookshopid 书店id
     * 图书信息列表
     */
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

        $id = M('shop')->where("uniqueid=%s", $bookshopid)->getField('userid');
        if ($id == session('user')['uniqueid']) $this->assign('flag', "0");
        else $this->assign('flag', "1");

        $this->display();
    }

    /**
     * 书店信息
     * @param $bookshopid 书店id
     * @return 书店信息列表
     */
    public function bookshopInfoPage($bookshopid){
        $Bookshop = M('shop');
        $shop = $Bookshop->where("uniqueid=%s", $bookshopid)->getField('shopname');
        $this->assign('bookshopname', $shop);

        $Shopitem = M('shopitem');
        $shopitems = $Shopitem->where("shopid=%s", $bookshopid)->select();
//        dump($shopitems);
//        dump($shopitems);
        $Book = M('book');

        $index = 0;
        foreach ($shopitems as $item) {
            $list[$index]['name'] = $Book->where("uniqueid=%s", $item['bookid'])->getField('name');
            $list[$index]['author'] = $Book->where("uniqueid=%s", $item['bookid'])->getField('author');
            $list[$index]['price'] = $Book->where("uniqueid=%s", $item['bookid'])->getField('price');
            $list[$index]['kind'] = $Book->where("uniqueid=%s", $item['bookid'])->getField('kind');
            $list[$index]['link'] = "bookInfoPage?bookid=" . $item['bookid'] . "&bookshopid=" . $bookshopid;
            $list[$index]['deleteLink'] = "deleteShopitem?shopitemid=" . $item['unqueid'];
            $index++;
        }
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

    /**
     * 添加书店图书商品
     */
    public function addBookPage() {

        $this->assign('link', session('link'));
        $this->display();
    }

    /**
     * 将添加的商品信息写到数据库
     */
    public function addBookAndShopitem() {
        $Book = M('book');
        $Shopitem = M('shopitem');
        $Shop = M('shop');

        $bookdata = array(
            'uniqueid' => $Book->count() + 1,
            'name' => $_POST['name'],
            'author' => $_POST['author'],
            'concern' => $_POST['concern'],
            'price' => $_POST['price'],
            'kind' => $_POST['kind'],
            'date' => $_POST['date'],
            'mark' => $_POST['mark'],
        );
        $Book->add($bookdata);
        $shopitemdata = array(
            'unqueid' => $Shopitem->count() + 1,
            'shopid' => M('shop')->where("userid=%s", session('user')['uniqueid'])->getField('uniqueid'),
            'shopname' => M('shop')->where("userid=%s", session('user')['uniqueid'])->getField('shopname'),
            'bookname' => $bookdata['name'],
            'bookid' => $Book->count(),
            'quantity' => "1",
        );
//        dump($shopitemdata);
        $Shopitem->add($shopitemdata);
        $this->success("添加成功。");
    }

    /**
     * 添加至购物车
     * @param $bookid 图书id
     * @param $bookshopid 书店id
     */
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

    /**
     * 订单列表
     */
    public function orderInfoPage(){
        $Order = M('order');
        $list = $Order->where("userid=%s", session('user')['uniqueid'])->select();
        for ($i = 0; $i < sizeof($list); $i++) {
            $list[$i]['link'] = "orderInfoDetail?orderid=" . $list[$i]['uniqueid'];
            if ($list[$i]['state'] == "1") $list[$i]['state'] = "已付款";
            else $list[$i]['state'] = "未付款";
        }
//        dump($list);

        $this->assign('list', $list);
        $this->assign('link', session('link'));
        $this->display();

    }

    /**
     * 订单详情页面
     * @param $orderid 订单号
     */
    public function orderInfoDetail($orderid) {
        $Order = M('order');
        $orderinfo = $Order->find($orderid);
//        dump($orderinfo);

        if($orderinfo['state'] == "0") {
            $orderinfo['state'] = "未付款";
            $link = "/BookTradingSystem/Home/Trade/completeOrder?bookid=" .
                $orderinfo['bookid'] . "&bookshopid=" . $orderinfo['shopid'] . "&orderid=" . $orderid;
            $this->assign('todo', "去付款");
            $this->assign('todolink', $link);
        }
        else {
            $orderinfo['state'] = "已付款";
            $this->assign('todo', "返回");
            $this->assign('todolink', "orderInfoPage");
        }

        $this->assign('data', $orderinfo);

        $this->assign('link', session('link'));
        $this->display();
    }

    /**
     * 删除书店商品
     * @param $shopitemid 商品id
     */
    public function deleteShopitem($shopitemid) {
        $Shopitem = M('shopitem');
        $Shopitem->find($shopitemid);
        $Shopitem->shopid = "-1";
        $Shopitem->shopname = "-1";
        $Shopitem->bookname = "-1";
        $Shopitem->bookid = "-1";
        $Shopitem->quantity = "-1";
        $Shopitem->save();
        $this->success("删除成功");
    }

    /**
     * 联系开发人员页面
     */
    public function contactusInfoPage(){

        $this->assign('link', session('link'));
        $this->display();

    }

}