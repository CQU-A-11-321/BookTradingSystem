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
    public function tradePage($bookid = 1, $bookshopid = 1){

        $this->assign('link', session('link'));
        $this->display();
    }
}