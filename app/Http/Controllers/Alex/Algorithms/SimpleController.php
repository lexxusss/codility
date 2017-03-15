<?php

namespace App\Http\Controllers\Alex\Algorithms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SimpleController extends Controller
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

    public function index()
    {
        $N = 30;

        $this->debugCallback('factorial_recursive', $N);
        $this->debugCallback('factorial_loop', $N);
        $this->debugCallback('fibonacci_recursive', $N);
        $this->debugCallback('fibonacci_loop', $N);
    }

    protected function debugCallback($callback, $parameter)
    {
        $tt1 = microtime();
        $result = call_user_func([$this, $callback], $parameter);
        $time = $this->getMicrotimeDiff(microtime(), $tt1);
        _d("$callback of $parameter: $result", "Time in milliseconds: $time");
    }

    protected function factorial_recursive($N)
    {
        if ($N < 2) return 1;

        return $N * $this->factorial_recursive($N - 1);
    }

    protected function factorial_loop($N)
    {
        $factorial = 1;

        while ($N > 0) {
            $factorial *= $N--;
        }

        return $factorial;
    }

    protected function fibonacci_recursive($N)
    {
        if ($N == 0) return 0;

        if ($N < 0) {
            if ($N > -2) return 1;

            return $this->fibonacci_recursive($N + 2) - $this->fibonacci_recursive($N + 1);
        }

        if ($N < 2) return 1;

        return $this->fibonacci_recursive($N - 1) + $this->fibonacci_recursive($N - 2);
    }

    protected function fibonacci_loop($N)
    {
        if ($N == 0) return 0;

        $last = abs($N);
        $current = 0;
        $next = 1;

        for ($i = 0; $i < $last; $i++) {
            $buff = $current;
            $current = $next;
            $next += $buff;
        }

        if ($N < 0 && !($N % 2)) {
            $current *= -1;
        }

        return $current;
    }
}
