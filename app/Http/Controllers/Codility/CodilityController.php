<?php

namespace App\Http\Controllers\Codility;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CodilityController extends Controller
{
    public function task1()
    {
        function solution($N) {
            $S = "";
            for ($i = 0; $i < $N; $i++) {
                $S .= $i % 2 ? '-' : '+';
            }

            return $S;
        }

        $N = 5;
        $N = 4;
        $N = 1;

        dd($N, solution($N));
    }

    /**
     * http://joxi.ru/DmBDq8VfJgjQ9A
     */
    public function task2()
    {
        function solution($S, $K) {
            $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun',];
            $daysKeys = array_flip($days);
            $N = count($days);

            $dayKey = $daysKeys[$S];
            $dayKeyToReturn = ($dayKey + $K) % $N;

            return $days[$dayKeyToReturn];
        }

        $S = 'Wed'; $K = 2; // Fri
//        $S = 'Sat'; $K = 23; // Mon

        dd($S, $K, solution($S, $K));
    }

    /**
     * Return min val with the same amount of symbols of given number
     */
    public function task3()
    {
        function solution($N) {
            $count = strlen($N);

            if ($count > 1) {
                $number = '1';
                for ($i = 1; $i < $count; $i++) {
                    $number .= '0';
                }

                return intval($number);
            }

            return 0;
        }

        $N = 125123;
//        $N = 10;
//        $N = 2;

        dd($N, solution($N));
    }

    /**
     * bash script
     */
    public function task4()
    {
        function solution($A) {
            return $A;
        }

        $A = [];

        dd($A, solution($A));
    }

    /**
     * Detect if given value $K is present in array $A sorted in non-descendant order -  (7%)
     */
    public function task5()
    {
        function solution($A, $K) {
            $N = count($A);

            for ($i = 0; $i < $N - 1; $i++) {
                if ($A[$i] + 1 < $A[$i + 1]) {
                    return false;
                }
            }

            if ($A[0] != 1 && $A[$N - 1] != $K) {
                return false;
            }

            return true;
        }

        $A = [2,3]; $K = 2;
//        $A = [1,2,3]; $K = 2;
//        $A = [1,1,3]; $K = 2;

        dd($A, $K, solution($A, $K));
    }
}
