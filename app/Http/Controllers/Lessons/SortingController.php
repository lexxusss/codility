<?php

namespace App\Http\Controllers\Lessons;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class SortingController
 *
 * https://codility.com/media/train/4-Sorting.pdf
 *
 * @package App\Http\Controllers\Lessons
 */
class SortingController extends Controller
{
    /**
     *

    Write a function

    function solution($A);

    that, given a zero-indexed array A consisting of N integers, returns the number of distinct values in array A.

    Assume that:

    N is an integer within the range [0..100,000];
    each element of array A is an integer within the range [−1,000,000..1,000,000].

    For example, given array A consisting of six elements such that:
    A[0] = 2    A[1] = 1    A[2] = 1
    A[3] = 2    A[4] = 3    A[5] = 1

    the function should return 3, because there are 3 distinct values appearing in array A, namely 1, 2 and 3.

    Complexity:

    expected worst-case time complexity is O(N*log(N));
    expected worst-case space complexity is O(N), beyond input storage (not counting the storage required for input arguments).

    Elements of input arrays can be modified.

     */
    public function distinct()
    {
        function solution($A) {
            return count(array_unique($A));
        }

        $A = [2,1,1,2,3,1];

        $distinct = solution($A);

        dd($distinct);
    }

    /**
     *

    A non-empty zero-indexed array A consisting of N integers is given. The product of triplet (P, Q, R) equates to A[P] * A[Q] * A[R] (0 ≤ P < Q < R < N).

    For example, array A such that:
    A[0] = -3
    A[1] = 1
    A[2] = 2
    A[3] = -2
    A[4] = 5
    A[5] = 6

    contains the following example triplets:

    (0, 1, 2), product is −3 * 1 * 2 = −6
    (1, 2, 4), product is 1 * 2 * 5 = 10
    (2, 4, 5), product is 2 * 5 * 6 = 60

    Your goal is to find the maximal product of any triplet.

    Write a function:

    function solution($A);

    that, given a non-empty zero-indexed array A, returns the value of the maximal product of any triplet.

    For example, given array A such that:
    A[0] = -3
    A[1] = 1
    A[2] = 2
    A[3] = -2
    A[4] = 5
    A[5] = 6

    the function should return 60, as the product of triplet (2, 4, 5) is maximal.

    Assume that:

    N is an integer within the range [3..100,000];
    each element of array A is an integer within the range [−1,000..1,000].

    Complexity:

    expected worst-case time complexity is O(N*log(N));
    expected worst-case space complexity is O(1), beyond input storage (not counting the storage required for input arguments).

    Elements of input arrays can be modified.

     */
    public function max_product_of_three()
    {
        function solution($A) {
            rsort($A);
            $length = count($A);

            $tripletLeft = $A[0] * $A[1] * $A[2];
            $tripletRight = $A[0] * $A[$length - 1] * $A[$length - 2];

            return max($tripletLeft, $tripletRight);
        }

        $A = [-3,1,2,-2,5,6];
//        $A = [-5, 5, -5, 4];

        $maxTriplet = solution($A);

        dd($maxTriplet);
    }

    /**
     *

    A zero-indexed array A consisting of N integers is given. A triplet (P, Q, R) is triangular if 0 ≤ P < Q < R < N and:

    A[P] + A[Q] > A[R],
    A[Q] + A[R] > A[P],
    A[R] + A[P] > A[Q].

    For example, consider array A such that:
    A[0] = 10    A[1] = 2    A[2] = 5
    A[3] = 1     A[4] = 8    A[5] = 20

    Triplet (0, 2, 4) is triangular.

    Write a function:

    function solution($A);

    that, given a zero-indexed array A consisting of N integers, returns 1 if there exists a triangular triplet for this array and returns 0 otherwise.

    For example, given array A such that:
    A[0] = 10    A[1] = 2    A[2] = 5
    A[3] = 1     A[4] = 8    A[5] = 20

    the function should return 1, as explained above. Given array A such that:
    A[0] = 10    A[1] = 50    A[2] = 5
    A[3] = 1

    the function should return 0.

    Assume that:

    N is an integer within the range [0..100,000];
    each element of array A is an integer within the range [−2,147,483,648..2,147,483,647].

    Complexity:

    expected worst-case time complexity is O(N*log(N));
    expected worst-case space complexity is O(N), beyond input storage (not counting the storage required for input arguments).

    Elements of input arrays can be modified.

     */
    public function triangle()
    {
        function solution($A) {
            sort($A);
            $length = count($A);

            if ($length > 2) {
                $last = $length - 2;
                for ($i = 0; $i < $last; $i++) {
                    $next = $i + 1;
                    $postNext = $i + 2;

                    if ($A[$i] + $A[$next] > $A[$postNext]) {
                        return 1;
                    }
                }
            }

            return 0;
        }

//        $A = [10,2,5,1,8,20];
//        $A = [10,50,5,1];
        $A = [-3,-4,-5,-7,-1];

        $isTriangle = solution($A);

        dd($isTriangle);
    }

    /**
     *

    We draw N discs on a plane. The discs are numbered from 0 to N − 1. A zero-indexed array A of N non-negative integers, specifying the radiuses of the discs, is given. The J-th disc is drawn with its center at (J, 0) and radius A[J].

    We say that the J-th disc and K-th disc intersect if J ≠ K and the J-th and K-th discs have at least one common point (assuming that the discs contain their borders).

    The figure below shows discs drawn for N = 6 and A as follows:
    A[0] = 1
    A[1] = 5
    A[2] = 2
    A[3] = 1
    A[4] = 4
    A[5] = 0

    --- IMAGE: discs on the row ---
    https://codility-frontend-prod.s3.amazonaws.com/media/task_static/number_of_disc_intersections/static/images/auto/0eed8918b13a735f4e396c9a87182a38.png
    --- /IMAGE: discs on the row  ---

    There are eleven (unordered) pairs of discs that intersect, namely:

    discs 1 and 4 intersect, and both intersect with all the other discs;
    disc 2 also intersects with discs 0 and 3.

    Write a function:

    function solution($A);

    that, given an array A describing N discs as explained above, returns the number of (unordered) pairs of intersecting discs.
    The function should return −1 if the number of intersecting pairs exceeds 10,000,000.

    Given array A shown above, the function should return 11, as explained above.

    Assume that:

    N is an integer within the range [0..100,000];
    each element of array A is an integer within the range [0..2,147,483,647].

    Complexity:

    expected worst-case time complexity is O(N*log(N));
    expected worst-case space complexity is O(N), beyond input storage (not counting the storage required for input arguments).

    Elements of input arrays can be modified.

     */
    public function number_of_disc_intersections()
    {
        function binary_search_loop($A, $N)
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

        function solution($A) {
            $length = count($A);

            $leftSides = [];
            $rightSides = [];

            foreach ($A as $key => $item) {
                $leftSides[$key] = $key - $item;
                $rightSides[$key] = $key + $item;
            }


            sort($leftSides);
            sort($rightSides);

            $count = 0;
            $leftCenter = 0;
            foreach ($rightSides as $rightCenter => $rightSide) {
                if ($leftCenter >= $length) break;

                while ($leftSides[$leftCenter] <= $rightSide) {
                    $distance = $leftCenter - $rightCenter;
                    $count += $distance;

                    $leftCenter++;
                    if ($leftCenter >= $length) break;
                }
            }

            if ($count > 10000000) {
                return -1;
            }

            return $count;
        }

        $A = [
            0 => 1,
            1 => 5,
            2 => 2,
            3 => 1,
            4 => 4,
            5 => 0,
        ];

        $A = [
            0 => 1,
            4 => 3
        ];

        $intersections = solution($A);

        dd($intersections);
    }
}
