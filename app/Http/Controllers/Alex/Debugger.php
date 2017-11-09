<?php

namespace App\Http\Controllers\Alex;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

trait Debugger
{
    public function getMicrotimeDiff($tt2, $tt1)
    {
        list($m2, $s2) = explode(' ', $tt2);
        list($m1, $s1) = explode(' ', $tt1);

        $m2 = (float) $m2;
        $s2 = (float) $s2;
        $m1 = (float) $m1;
        $s1 = (float) $s1;

        $secondsDiff = $s2 - $s1;
        $millisecondsDiff = $m2 - $m1;

        return $secondsDiff + $millisecondsDiff;
    }

    public function debugCallback($callback, $parameter)
    {
        if (is_array($parameter)) {
            $func = 'call_user_func_array';
            $parameterToString = 'Array of params';
        } else {
            $func = 'call_user_func';
            $parameterToString = $parameter;
        }

        $tt1 = microtime();
        $result = $func([$this, $callback], $parameter);
        $time = $this->getMicrotimeDiff(microtime(), $tt1);
        _d(
            "$callback of $parameterToString: $result",
            "input data:",
            $parameter,
            "Time in milliseconds: $time"
        );
    }
}
