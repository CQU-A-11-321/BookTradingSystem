<?php

namespace Home\Controller;
use Think\Controller;
class customerController extends Controller
{
    public function informationPage($name = 'think1')
    {
        $this->display();
    }
}