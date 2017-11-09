<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GulfTalentController extends Controller
{
    /**
     * http://joxi.ru/DrlVRgwuvX3R32
     */
    public function task1()
    {
        function checkDepth($A, $v, $maxes) {
            $depth = 1;
            $vals = [];

            if (array_key_exists($v, $A)) {
                $currVal = $A[$v];
                $vals[$currVal] = 1;
                for (;array_key_exists($currVal, $A); $depth++) {
                    $currVal = $A[$currVal];

                    if (array_key_exists($currVal, $vals)) {
                        break;
                    }

                    if (array_key_exists($currVal, $maxes)) {
                        $depth += $maxes[$currVal] - 1;
                        break;
                    }

                    $vals[$currVal] = 1;
                }
            }

            return $depth;
        }

        function solution($A) {
            if (!count($A)) {
                return 0;
            }

            $maxes = [];
            $max = 0;
            foreach ($A as $a) {
                $max = max($max, checkDepth($A, $a, $maxes));
                $maxes[$a] = $max;
            }

            return $max;
        }

        $A = [5,4,0,3,1,6,2];

        dd(solution($A));
    }


    /**
     * http://joxi.ru/vAWZvzkh1e6nX2
     */
    public function task2()
    {
        function deviation($a, $average) {
            return abs($a - $average);
        }

        function solution($A) {
            if (!count($A)) {
                return -1;
            }

            $average = array_sum($A) / count($A);

            $maxV = deviation($A[0], $average);
            $maxK = 0;
            foreach ($A as $k => $a) {
                $deviation = deviation($a, $average);
                if ($deviation > $maxV) {
                    $maxK = $k;
                    $maxV = $deviation;
                }
            }


            return $maxK;
        }

        $A = [9,4,-3,-10];
        $A = [1,2,3,4,7];


        dd(solution($A));
    }


    public function demo()
    {
        function solution() {

        }

        dd(solution());
    }
}
