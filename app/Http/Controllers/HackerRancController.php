<?php

namespace App\Http\Controllers;


class HackerRancController
{
    /**
     * Given a square matrix of size N x N , calculate the absolute difference between the sums of its diagonals.

    Print the absolute difference between the two sums of the matrix's diagonals as a single integer.

    Sample Input

    3
    11 2 4
    4 5 6
    10 8 -12

    Sample Output

    15

    Explanation

    The primary diagonal is:
    11
    5
    -12

    Sum across the primary diagonal: 11 + 5 - 12 = 4

    The secondary diagonal is:
    4
    5
    10

    Sum across the secondary diagonal: 4 + 5 + 10 = 19
    Difference: |4 - 19| = 15
     */
    public function diagonal_difference() {
        function solution($a) {
            $totalRows = count($a);

            $sumLeft = 0;
            $sumRight = 0;

            foreach ($a as $row => $items) {
                foreach ($items as $col => $number) {
                    if ($row == $col) {
                        $sumLeft += $a[$row][$col];
                    }
                    if ($row == $totalRows - $col - 1) {
                        $sumRight += $a[$row][$col];
                    }
                }
            }

            return abs($sumLeft - $sumRight);
        }

        $a = [
            [1,2,3,4],
            [5,6,7,8],
            [9,10,11,12],
            [13,14,15,16]
        ];

//        $a = [
//            [11,2,4],
//            [4,5,6],
//            [10,8,-12],
//        ];

        $sum = solution($a);

        dd($sum);
    }
}
