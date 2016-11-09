<?php

namespace Home\Controller;
use Think\Controller;
class TestController extends Controller
{
    public function test1($name = 'think')
    {
        $this->display();
    }
}