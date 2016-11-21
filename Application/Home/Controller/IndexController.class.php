<?php

namespace Home\Controller;
use stdClass;
use Think\Controller;
class IndexController extends BaseController{
    public function index(){
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
            $this->error("登录失败");
        }
        else {
            // fixme: 登录成功跳转窗口增加内容
//            $name = $result[0]['name'];
//            session('username', $name);
//            session('userid', $result[0]['uniqueid']);
            session('user', $result[0]);
            $UserInfo = M('userinfo');
            $info = $UserInfo->where("uniqueid=%s", $result[0]['userinfoid'])->select();
            session('userinfo', $info[0]);
            $this->success("登陆成功", "successLogin");
        }
    }

    public function successLogin() {
        $this->redirect("Home/Information/indexPage");
    }

    public function register() {
        $User = M('user');

        $User->uniqueid = $_POST['user'];
        $User->name = $_POST['username'];
        $User->password = $_POST['password'];
        $nextNum = sizeof($User->select());
        $nextNum++;
        $User->userinfoid = $nextNum;

        // judge if account is exit
        $map['uniqueid'] = array('eq', $_POST['user']);

        if (sizeof($User->where($map)->select()) != 0) {
            $this->error("账号已存在");
        }
        else {
            $User->add();
            $UserInfo = M('userinfo');
            $info = array(
                'uniqueid' => $nextNum,
                'address' => '',
                'tel' => '',
                'email' => '',
                'money' => '0',
                'zipcode' => ''
            );
            $UserInfo->add($info);
            $this->success("注册成功", "index");
        }
    }
}