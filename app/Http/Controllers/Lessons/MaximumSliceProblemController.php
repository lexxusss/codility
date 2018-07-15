<?php

namespace App\Http\Controllers\Lessons;

use App\Http\Controllers\Alex\Debugger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaximumSliceProblemController extends Controller
{
    use Debugger;

    /**
     *

    A zero-indexed array A consisting of N integers is given.
    It contains daily prices of a stock share for a period of N consecutive days.
    If a single share was bought on day P and sold on day Q, where 0 ≤ P ≤ Q < N, then the profit of such transaction is equal to A[Q] − A[P],
    provided that A[Q] ≥ A[P]. Otherwise, the transaction brings loss of A[P] − A[Q].

    For example, consider the following array A consisting of six elements such that:
    A[0] = 23171
    A[1] = 21011
    A[2] = 21123
    A[3] = 21366
    A[4] = 21013
    A[5] = 21367

    If a share was bought on day 0 and sold on day 2, a loss of 2048 would occur because A[2] − A[0] = 21123 − 23171 = −2048.
    If a share was bought on day 4 and sold on day 5, a profit of 354 would occur because A[5] − A[4] = 21367 − 21013 = 354.
    Maximum possible profit was 356. It would occur if a share was bought on day 1 and sold on day 5.

    Write a function,

    function solution($A);

    that, given a zero-indexed array A consisting of N integers containing daily prices of a stock share for a period of N consecutive days,
    returns the maximum possible profit from one transaction during this period.
    The function should return 0 if it was impossible to gain any profit.

    For example, given array A consisting of six elements such that:
    A[0] = 23171
    A[1] = 21011
    A[2] = 21123
    A[3] = 21366
    A[4] = 21013
    A[5] = 21367

    the function should return 356, as explained above.

    Assume that:

    N is an integer within the range [0..400,000];
    each element of array A is an integer within the range [0..200,000].

    Complexity:

    expected worst-case time complexity is O(N);
    expected worst-case space complexity is O(1), beyond input storage (not counting the storage required for input arguments).

    Elements of input arrays can be modified.

     */
    public function max_profit()
    {
        function solution($A) {
            $count = count($A);
            $minPrice = $A[0];
            $maxProfit = 0;
            for ($i = 1; $i < $count; $i++) {
                $a = $A[$i];
                $minPrice = min($minPrice, $a);

                $profit = $a - $minPrice;
                $maxProfit = max($profit, $maxProfit);
            }

            return $maxProfit > 0 ? $maxProfit : 0;
        }

        $A = [23171,21011,21123,21366,21013,21367];
//        $A = [1,2,3,4,5];

        dd(solution($A));
    }

    public function index()
    {
//        $A = [5,-7,3,5,-2,4,-1];
//        $A = [-5,-7,-3,-5,-2,-4,-1];
//        $A = range(1, 4);
//        $A = [-4,-4,1,2,3,-8];
        $A = range(-2, 144);

        $this->debugCallback('max_slice_problem_slow', [$A]);
        $this->debugCallback('max_slice_problem_faster', [$A]);
        $this->debugCallback('max_slice_problem_faster2', [$A]);
        $this->debugCallback('max_slice_problem_fastest', [$A]);
    }

    /**
     * Find the slice of array with max sum
     *
     * O{N^2)
     *
     * @param $A
     * @return int|mixed
     */
    protected function max_slice_problem_fastest($A)
    {
        $maxEnding = $maxSlice = 0;

        foreach ($A as $a) {
            $maxEnding = max(0, $maxEnding + $a);
            $maxSlice = max($maxSlice, $maxEnding);
        }

        return $maxSlice;
    }

    /**
     * Find the slice of array with max sum
     *
     * O{N^2)
     *
     * @param $A
     * @return int|mixed
     */
    protected function max_slice_problem_faster2($A)
    {
        $N = count($A);
        $result = 0;

        for ($p = 0; $p < $N; $p++) {
            $sum = 0;
            for ($q = $p; $q < $N; $q++) {
                $sum += $A[$q];

                $result = max($sum, $result);
            }
        }

        return $result;
    }

    /**
     * Find the slice of array with max sum
     *
     * O{N^2)
     *
     * @param $A
     * @return int|mixed
     */
    protected function max_slice_problem_faster($A)
    {
        function findPref($A) {
            $pref = [0];
            $sum = 0;
            foreach ($A as $v) {
                $pref[] = $sum += $v;
            }

            return $pref;
        }

        $N = count($A);
        $result = 0;
        $pref = findPref($A);

        for ($p = 0; $p < $N; $p++) {
            for ($q = $p+1; $q <= $N; $q++) {
                $sum = $pref[$q] - $pref[$p];

                $result = max($sum, $result);
            }
        }

        return $result;
    }

    /**
     * Find the slice of array with max sum
     *
     * O{N^3)
     *
     * @param $A
     * @return int|mixed
     */
    protected function max_slice_problem_slow($A)
    {
        $N = count($A);
        $result = 0;

        for ($p = 0; $p < $N; $p++) {
            for ($q = $p; $q < $N; $q++) {
                $sum = 0;
                for ($i = $p; $i <= $q; $i++) {
                    $sum += $A[$i];
                }

                $result = max($sum, $result);
            }
        }

        return $result;
    }

    /**
     * A non-empty array A consisting of N integers is given. A pair of integers (P, Q), such that 0 ≤ P ≤ Q < N, is called a slice of array A. The sum of a slice (P, Q) is the total of A[P] + A[P+1] + ... + A[Q].

    Write a function:

    function solution($A);

    that, given an array A consisting of N integers, returns the maximum sum of any slice of A.

    For example, given array A such that:

    A[0] = 3  A[1] = 2  A[2] = -6
    A[3] = 4  A[4] = 0
    the function should return 5 because:

    (3, 4) is a slice of A that has sum 4,
    (2, 2) is a slice of A that has sum −6,
    (0, 1) is a slice of A that has sum 5,
    no other slice of A has sum greater than (0, 1).
    Assume that:

    N is an integer within the range [1..1,000,000];
    each element of array A is an integer within the range [−1,000,000..1,000,000];
    the result will be an integer within the range [−2,147,483,648..2,147,483,647].
    Complexity:

    expected worst-case time complexity is O(N);
    expected worst-case space complexity is O(N) (not counting the storage required for input arguments).
     */
    public function max_slice_sum()
    {
        function solution($A) {
            $sum = $maxSum = $A[0];

            for ($i = 1; $i < count($A); $i++) {
                $a = $A[$i];

                $sum = max($a, $sum + $a);
                $maxSum = max($sum, $maxSum);
            }

            return $maxSum;
        }

        $A = [3, 2, -6, 4, 0];
//        $A = [3, 2, 6, -10, 4, 5, -1, 2];
        $sum = solution($A);

        dd($sum);
    }

    /**
     *

    A non-empty zero-indexed array A consisting of N integers is given.

    A triplet (X, Y, Z), such that 0 ≤ X < Y < Z < N, is called a double slice.

    The sum of double slice (X, Y, Z) is the total of A[X + 1] + A[X + 2] + ... + A[Y − 1] + A[Y + 1] + A[Y + 2] + ... + A[Z − 1].

    For example, array A such that:
    A[0] = 3
    A[1] = 2
    A[2] = 6
    A[3] = -1
    A[4] = 4
    A[5] = 5
    A[6] = -1
    A[7] = 2

    contains the following example double slices:

    double slice (0, 3, 6), sum is 2 + 6 + 4 + 5 = 17,
    double slice (0, 3, 7), sum is 2 + 6 + 4 + 5 − 1 = 16,
    double slice (3, 4, 5), sum is 0.

    The goal is to find the maximal sum of any double slice.

    Write a function:

    function solution($A);

    that, given a non-empty zero-indexed array A consisting of N integers, returns the maximal sum of any double slice.

    For example, given:
    A[0] = 3
    A[1] = 2
    A[2] = 6
    A[3] = -1
    A[4] = 4
    A[5] = 5
    A[6] = -1
    A[7] = 2

    the function should return 17, because no double slice of array A has a sum of greater than 17.

    Assume that:

    N is an integer within the range [3..100,000];
    each element of array A is an integer within the range [−10,000..10,000].

    Complexity:

    expected worst-case time complexity is O(N);
    expected worst-case space complexity is O(N), beyond input storage (not counting the storage required for input arguments).

     * SOLVED - 100%
     */
    public function max_double_slice_sum()
    {
        function getSums($A, $directionAsc = true) {
            if (count($A) == 3) {
                return [0];
            }

            $length = count($A);
            $last = $length - 1;

            $sums = [];
            $sums[] = 0;

            $index = $directionAsc ? 1 : $last - 1;
            $sums[] = $sum = max(0, $A[$index]);
            echo "$index -> $sum<br/>";

            for ($i = 2; $i < $last - 1; $i++) {
                $index = $directionAsc ? $i : $last - $i;
                $a = $A[$index];

                $sums[] = $sum = max(0, $a, $a + $sum);

                echo "$index -> $sum<br/>";
            }

            echo "<br/><br/>";

            return $directionAsc ? $sums : array_reverse($sums);
        }

        function solution($A) {
            $sumsL = getSums($A);
            $sumsR = getSums($A, false);

            $size = count($sumsL);
            $max = $sumsL[0] + $sumsR[0];
            for ($i = 1; $i < $size; $i++) {
                $maxL = $sumsL[$i];
                $maxR = $sumsR[$i];

                $max = max($max, $maxL + $maxR);
            }

            _d($A, $sumsL, $sumsR, $max);

            return $max;
        }

        $A = [3, 2, 6, -1, 4, 5, -1, 2]; // 17
        $max = solution($A);

        $A = [5, 5, 5]; // 0
        $max = solution($A);

        $A = [5, 17, 0, 3]; // 17
        $max = solution($A);

        $A = [5, 0, 1, 0, 5]; // 1
        $max = solution($A);

        $A = [0, 10, -5, -2, 0]; // 10
        $max = solution($A);

        dd();
    }
}
