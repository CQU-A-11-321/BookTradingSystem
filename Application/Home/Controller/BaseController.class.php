<?php
/**
 * Created by CQU-CST-WuErli.
 * Date: 2016/11/19
 * Time: 13:07
 */

namespace Home\Controller;


use Think\Controller;

/**
 * Class BaseController
 * @package Home\Controller
 * 用于代码提示以及一些共有的方法
 */

class BaseController extends Controller {
    /**
     * 获得当前的url
     * @return string
     */
    function get_url() {
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
        $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
        return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
    }

    /**
     * 对于用户信息更改同步各数据库
     */
    function updateUserInfoToEachTable() {
        $Shop = M('shop');
        $Order = M('order');
        // username
        $Shop->where("userid=%s", session('user')['uniqueid'])->setField('username', session('user')['name']);
        $Order->where("userid=%s", session('user')['uniqueid'])->setField('username',session('user')['name']);
    }
}