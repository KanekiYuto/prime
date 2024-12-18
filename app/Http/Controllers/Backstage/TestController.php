<?php

namespace App\Http\Controllers\Backstage;

class TestController
{

    public function test1(): string
    {
        sleep(1);
        return __FUNCTION__;
    }

    public function test2(): string
    {
        return __FUNCTION__;
    }

}
