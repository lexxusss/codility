<?php

namespace App\Http\Controllers\Lessons;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

     */
    public function equi_leader()
    {
        function isLeader($countOfNumber, $totalNumbers) {
            return $countOfNumber > ($totalNumbers / 2);
        }

        function solution($A) {
            

            return 1;
        }

//        $A = [4,3,4,4,4,2];
        $A = [4, 4, 2, 5, 3, 4, 4, 4];

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

     */
    public function dominator()
    {
        function solution($A) {
            $stack = [];
            $keysStack = [];

            foreach ($A as $key => $item) {
                $lastStackItem = array_pop($stack);
                $lastStackKey = array_pop($keysStack);

                if ($lastStackItem === null) {
                    array_push($stack, $item);
                    array_push($keysStack, $key);
                } elseif ($item == $lastStackItem) {
                    array_push($stack, $lastStackItem);
                    array_push($keysStack, $lastStackKey);

                    array_push($stack, $item);
                    array_push($keysStack, $key);
                }
            }

            $candidate = array_pop($stack);
            $candidateKey = array_pop($keysStack);
            if ($candidate) {
                $count = 0;
                foreach ($A as $item) {
                    if ($item == $candidate) {
                        $count++;
                    }
                }

                if ($count > count($A) / 2) {
                    return $candidateKey;
                }
            }

            return -1;
        }

//        $A = [3,4,3,2,3,-1,3,3];
        $A = [2, 1, 1, 1, 3];

        $dominator = solution($A);

        dd($dominator);
    }
}
