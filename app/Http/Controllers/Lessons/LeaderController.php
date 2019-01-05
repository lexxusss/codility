<?php

namespace App\Http\Controllers\Lessons;

use App\Http\Controllers\Controller;

class LeaderController extends Controller
{
    /**
     *

    A non-empty zero-indexed array A consisting of N integers is given.

    The leader of this array is the value that occurs in more than half of the elements of A.

    An equi leader is an index S such that 0 ≤ S < N − 1 and two sequences A[0], A[1], ..., A[S] and A[S + 1], A[S + 2], ..., A[N − 1] have leaders of the same value.

    For example, given array A such that:
    A[0] = 4
    A[1] = 3
    A[2] = 4
    A[3] = 4
    A[4] = 4
    A[5] = 2

    we can find two equi leaders:

    0, because sequences: (4) and (3, 4, 4, 4, 2) have the same leader, whose value is 4.
    2, because sequences: (4, 3, 4) and (4, 4, 2) have the same leader, whose value is 4.

    The goal is to count the number of equi leaders.

    Write a function:

    function solution($A);

    that, given a non-empty zero-indexed array A consisting of N integers, returns the number of equi leaders.

    For example, given:
    A[0] = 4
    A[1] = 3
    A[2] = 4
    A[3] = 4
    A[4] = 4
    A[5] = 2

    the function should return 2, as explained above.

    Assume that:

    N is an integer within the range [1..100,000];
    each element of array A is an integer within the range [−1,000,000,000..1,000,000,000].

    Complexity:

    expected worst-case time complexity is O(N);
    expected worst-case space complexity is O(N), beyond input storage (not counting the storage required for input arguments).

    Elements of input arrays can be modified.
     *
     * 100%

     */
    public function equi_leader()
    {
        function initOccurs($A) {
            $occurs = [];
            foreach ($A as $a) {
                $occurs[$a] = 0;
            }

            return $occurs;
        }

        function solution($A) {
            $N = count($A);

            // find leader and total
            $occurs = initOccurs($A);
            $leader = null;
            $total = 0;
            foreach ($A as $a) {
                $occurs[$a]++;

                if ($occurs[$a] > $total) {
                    $total = $occurs[$a];
                    $leader = $a;
                }
            }

            if ($total <= $N / 2) {
                return 0;
            }

            $equiLeaders = 0;
            $leftLeaders = 0;
            $rightLeaders = $total - $leftLeaders;
            foreach ($A as $k => $a) {
                if ($a == $leader) {
                    $leftLeaders++;
                    $rightLeaders = $total - $leftLeaders;
                }

                if ($leftLeaders > ($k + 1) / 2 && $rightLeaders > ($N - $k - 1) / 2) {
                    $equiLeaders++;
                }
            }

            return $equiLeaders;
        }

        $A = [4,3,4,4,4,2];
//        $A = [4, 4, 2, 5, 3, 4, 4, 4];

        $equi_leader = solution($A);

        dd($equi_leader);
    }

    /**
     *

    A zero-indexed array A consisting of N integers is given. The dominator of array A is the value that occurs in more than half of the elements of A.

    For example, consider array A such that
    A[0] = 3    A[1] = 4    A[2] =  3
    A[3] = 2    A[4] = 3    A[5] = -1
    A[6] = 3    A[7] = 3

    The dominator of A is 3 because it occurs in 5 out of 8 elements of A (namely in those with indices 0, 2, 4, 6 and 7) and 5 is more than a half of 8.

    Write a function

    function solution($A);

    that, given a zero-indexed array A consisting of N integers, returns index of any element of array A in which the dominator of A occurs. The function should return −1 if array A does not have a dominator.

    Assume that:

    N is an integer within the range [0..100,000];
    each element of array A is an integer within the range [−2,147,483,648..2,147,483,647].

    For example, given array A such that
    A[0] = 3    A[1] = 4    A[2] =  3
    A[3] = 2    A[4] = 3    A[5] = -1
    A[6] = 3    A[7] = 3

    the function may return 0, 2, 4, 6 or 7, as explained above.

    Complexity:

    expected worst-case time complexity is O(N);
    expected worst-case space complexity is O(1), beyond input storage (not counting the storage required for input arguments).

    Elements of input arrays can be modified.
     *
     * 100%

     */
    public function dominator()
    {
        function solution($A) {
            $dominator = -1;
            $occurs = [];
            $leaderK = $total = 0;
            foreach ($A as $k => $a) {
                $occurs[$a] = array_key_exists($a, $occurs) ? $occurs[$a] + 1 : 1;
                if ($occurs[$a] > $total) {
                    $total = $occurs[$a];
                    $leaderK = $k;
                }
            }

            if ($total > count($A) / 2) {
                $dominator = $leaderK;
            }


            return $dominator;
        }

        $A = [3,4,3,2,3,-1,3,3];
//        $A = [2, 1, 1, 1, 3];
//        $A = [0, 0];

        $dominator = solution($A);

        dd($dominator);
    }
}
