<?php

namespace App\Http\Controllers\Alex\Algorithms;

use App\Http\Controllers\Alex\Debugger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SimpleController extends Controller
{
    use Debugger;

    public function index()
    {
        $N = 30;
        $A = [41,23,44,58,6,30,45,65,12,875,45,54,33];
        $A = range(1, 999999);

        sort($A);

//        $this->debugCallback('factorial_recursive', $N);
//        $this->debugCallback('factorial_loop', $N);
//        $this->debugCallback('fibonacci_recursive', $N);
//        $this->debugCallback('fibonacci_loop', $N);
        $this->debugCallback('binary_search_recursive', [$A, $N, 0, count($A) - 1]);
        $this->debugCallback('binary_search_loop', [$A, $N]);
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

    protected function binary_search_recursive($A, $N, $left, $right)
    {
        if ($left > $right) return -1;

        $mid = ($left + $right) >> 1;

        if ($A[$mid] == $N) {
            return $mid;
        } elseif ($A[$mid] > $N) {
            return $this->binary_search_recursive($A, $N, $left, $mid - 1);
        }

        return $this->binary_search_recursive($A, $N, $left + 1, $right);
    }

    protected function binary_search_loop($A, $N)
    {
        $left = 0;
        $right = count($A)-1;

        while ($left <= $right) {
            $mid = ($left + $right) >> 1;

            if ($A[$mid] == $N) {
                return $mid;
            } elseif ($A[$mid] > $N) {
                $right = $mid - 1;
            } elseif ($A[$mid] < $N) {
                $left = $mid + 1;
            }
        }

        return -1;
    }
}
