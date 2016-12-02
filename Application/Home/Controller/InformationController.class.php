<?php

namespace Home\Controller;
use Think\Controller;
class InformationController extends BaseController
{
    /**
     *
     */
    public function indexPage(){
        $Book = M('book');
        $list = $Book->select();
        $n = sizeof($list);
        for ($i = 0; $i < $n; $i++) {
            $list[$i]['link'] = "bookInfoPage?bookid=" . $list[$i]['uniqueid'];
        }
//        dump($list);
        $this->assign('list',$list);

        $Shop = M('shop');
        $shops = $Shop->select();


        $this->display("successLogin");
    }

    public function bookInfoPage($bookid = 1){
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
        $User = M('User');
        $list = array(
            0 => array(
                'id' => 'etet',
                'name' => '12123'
            ),
            1 => array(
                'id' => 'etet1',
                'name' => 'cz1996'
            )
        );
        $this->assign('list',$list);
        $this->display();
    }

    public function orderInfoPage(){
        $User = M('User');
        $list = array(
            0 => array(
                'username' => 'cz',
                'bookname' => '钢铁是怎样练成的1',
                'totalmoney' => '156.5',
            ),
            1 => array(
                'username' => 'wel',
                'bookname' => '钢铁是怎样练成的2',
                'totalmoney' => '156.5',
            ),
            2 => array(
                'username' => 'cz',
                'bookname' => '钢铁是怎样练成的1',
                'totalmoney' => '156.5',
            ),
            3 => array(
                'username' => 'cz',
                'bookname' => '钢铁是怎样练成的1',
                'totalmoney' => '156.5',
            ),
            4 => array(
                'username' => 'cz',
                'bookname' => '钢铁是怎样练成的1',
                'totalmoney' => '156.5',
            ),
            5 => array(
                'username' => 'cz',
                'bookname' => '钢铁是怎样练成的1',
                'totalmoney' => '156.5',
            ),
            6 => array(
                'username' => 'cz',
                'bookname' => '钢铁是怎样练成的1',
                'totalmoney' => '156.5',
            ),
            7 => array(
                'username' => 'cz',
                'bookname' => '钢铁是怎样练成的1',
                'totalmoney' => '156.5',
            ),
            8 => array(
                'username' => 'cz',
                'bookname' => '钢铁是怎样练成的1',
                'totalmoney' => '156.5',
            ),
            9 => array(
                'username' => 'cz',
                'bookname' => '钢铁是怎样练成的1',
                'totalmoney' => '156.5',
            )
        );
        $this->assign('ccz',15);
        $this->assign('list',$list);
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

    public function orderInfoDetail($shopId = 1) {
        $this->display();
    }

}