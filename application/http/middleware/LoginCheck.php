<?php

namespace app\http\middleware;

use SC,OnlyLogin;

class LoginCheck
{
    public function handle($request, \Closure $next)
    {
        return $next($request);
    }
}
