<?php
/**
 * Created by CQU-CST-WuErli.
 * Date: 2016/11/19
 * Time: 13:07
 */
namespace Home\Controller;
use Think\Controller;

/**
 * Class InformationController
 * @package Home\Controller
 * @URL /BookTradingSystem/Infomation
 * 信息查询显示模块
 */
class InformationController extends BaseController
{
    /**
     * 衔接IndexController的方法显示主页
     */
    public function indexPage(){
        $this->display("successLogin");
    }

    /**
     * @param $shopitemId 商品id
     * @return 商品信息页面
     */
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

    /**
     * @return 返回个人信息页面
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
        $this->display();
    }

    /**
     * @param $shopId 书店id
     * @return 返回书店信息页面
     */
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

    /**
     * @return 个人订单详情
     */
    public function orderInfoPage(){
        $this->display();

    }

    /**
     * @return 联系开发者页面
     */
    public function contaceusInfoPage(){
        $this->display();

    }

    /**
     * @return 完善信息页面
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
        $this->display();
    }

    /**
     * 接受修改后的信息修改数据库
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

        $this->success("修改成功", "myInfoPage");
    }

}