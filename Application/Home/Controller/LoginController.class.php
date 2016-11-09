<?php

namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller
{
    public function welcomePage($name = 'think')
    {
        $this->display();
    }
}