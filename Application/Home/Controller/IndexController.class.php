<?php
//namespace Home\Controller;
//use Think\Controller;
//class IndexController extends Controller {
//    public function index(){
//        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
//    }
//}

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