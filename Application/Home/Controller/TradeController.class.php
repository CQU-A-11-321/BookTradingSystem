<?php
/**
 * Created by CQU-CST-WuErli.
 * Date: 2016/11/19
 * Time: 13:07
 */
namespace Home\Controller;
use Think\Controller;
class TradeController extends BaseController
{
    /**
     * 交易付款页面
     * @param $bookid 图书id
     * @param $bookshopid 书店id
     */
    public function tradePage($bookid, $bookshopid){
        $data['name'] = session('user')['name'];
        $data['tel'] = session('userinfo')['tel'];
        $data['email'] = session('userinfo')['email'];
        $data['zipcode'] = session('userinfo')['zipcode'];
        $data['address'] = session('userinfo')['address'];
        $data['price'] = M('book')->where("uniqueid=%s", $bookid)->getField('price');

        $this->assign('data', $data);
//        dump($data);
        $id = M('shop')->where("userid=%s", session('user')['uniqueid'])->getField('uniqueid');
        $link = "/BookTradingSystem/Home/Information/bookshopInfoPage?bookshopid=" . $id;

        $confirmLink = "confirmOrder?bookid=" . $bookid . "&bookshopid=" . $bookshopid;

        $this->assign('confirmLink', $confirmLink);
        $this->assign('link', $link);
//        dump($link);
        $this->display();
    }

    /**
     * 确认付款并回写数据库
     * @param $bookid 图书id
     * @param $bookshopid 书店id
     */
    public function confirmOrder($bookid, $bookshopid) {
        $money = $_POST['price'];
        if ((int)session('userinfo')['money'] < (int)$money) {
            $this->error("余额不足，请充值。");
        }
        else {
            M('userinfo')->where("uniqueid=%s", session('userinfo')['uniqueid'])->setDec('money', $money);
            session('userinfo', M('userinfo')->where("uniqueid=%s", session('userinfo')['uniqueid'])->select());

            $data = array(
                'uniqueid' => M('order')->count() + 1,
                'userid' => session('user')['uniqueid'],
                'username' => session('user')['name'],
                'shopid' => $bookshopid,
                'shopname' => M('shop')->where("uniqueid=%s", $bookshopid)->getField('shopname'),
                'bookid' => $bookid,
                'bookname' => M('book')->where("uniqueid=%s", $bookid)->getField('name'),
                'totalmoney' => $_POST['price'],
                'address' => $_POST['address'],
                'tel' => $_POST['tel'],
                'email' => $_POST['email'],
                'createdate' => date("Y-m-d H:i:s"),
                'state' => "1",
            );
            M('order')->add($data);
            $this->success("购买成功。", "/BookTradingSystem/Home/Information/indexPage");
        }
    }
}