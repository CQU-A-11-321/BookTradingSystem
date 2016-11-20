<?php

namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController{
    public function index(){
        $this->display();
    }

    public function test1()
    {
        $this->display();
    }

    public function login() {
        $name = $_POST['log'];
        $password = $_POST['pwd'];
        $User = M('user');
        $condition = array(
            'uniqueid' => array('eq', $name),
            'password' => array('eq', $password)
        );
        $result = $User->where($condition)->select();
        if (sizeof($result) == 0) {
            // todo: 失败跳转创窗口
            echo 'fail';
        }
        else {
            // fixme: 登录成功跳转窗口增加内容
            $name = $result[0]['name'];
            session('username', $name);
            $this->success("登陆成功", "successLogin");
        }
    }

    public function successLogin() {
        $this->assign('name', session('username'));
        $this->display();
    }

    public function register() {
        $User = M('user');
        $nextNum = sizeof($User->select());
//        echo $nextNum;
        $nextNum++;
        $User->uniqueid = $_POST['user'];
        $User->name = $_POST['username'];
        $User->password = $_POST['password'];
        $User->userinfoid = $nextNum;
        if ($User->add()) {
            $UserInfo = M('userinfo');
            $data = array(
                'uniqueid' => $nextNum,
                'address' => '1111',
                'tel' => '1111',
                'email' => '1111',
                'money' => '100',
                'zipcode' => '123'
            );
            if ($UserInfo->add($data)) {
                $this->success("注册成功");
            }
            else {

            }

        }
        else {
            $this->error("账号已存在");
        }
    }
}