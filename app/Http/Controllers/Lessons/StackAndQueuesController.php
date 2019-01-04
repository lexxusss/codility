<?php

namespace App\Http\Controllers\Lessons;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StackAndQueuesController extends Controller
{
    /**
     *

    A string S consisting of N characters is considered to be properly nested if any of the following conditions is true:

    S is empty;
    S has the form "(U)" or "[U]" or "{U}" where U is a properly nested string;
    S has the form "VW" where V and W are properly nested strings.

    For example, the string "{[()()]}" is properly nested but "([)()]" is not.

    Write a function:

    function solution($S);

    that, given a string S consisting of N characters, returns 1 if S is properly nested and 0 otherwise.

    For example, given S = "{[()()]}", the function should return 1 and given S = "([)()]", the function should return 0, as explained above.

    Assume that:

    N is an integer within the range [0..200,000];
    string S consists only of the following characters: "(", "{", "[", "]", "}" and/or ")".

    Complexity:

    expected worst-case time complexity is O(N);
    expected worst-case space complexity is O(N) (not counting the storage required for input arguments).
     *
     * 100%

     */
    public function brackets()
    {
        function solution($S) {
            $pairs = [
                '(' => ')',
                '[' => ']',
                '{' => '}',
            ];

            $N = strlen($S);
            if ($N % 2 != 0) {
                return 0;
            }

            $stack = [];
            for ($i = 0; $i < $N; $i++) {
                $sN = $S[$i];

                // if opened bracket
                if (array_key_exists($sN, $pairs)) {
                    array_push($stack, $sN);
                } else {
                    $s = array_pop($stack);

                    if ($s && $sN != $pairs[$s]) {
                        return 0;
                    }
                }
            }

            return (int) !$stack;
        }

//        $S = '{[()()]}'; // 1
//        $S = '([)()]'; // 0
//        $S = '{()[()]}'; // 1
        $S = '[(){}]{()}'; // 1

        $isNested = solution($S);

        dd($isNested);
    }

    /**
     *

    You are given two non-empty zero-indexed arrays A and B consisting of N integers.
    Arrays A and B represent N voracious fish in a river, ordered downstream along the flow of the river.

    The fish are numbered from 0 to N − 1. If P and Q are two fish and P < Q, then fish P is initially upstream of fish Q.
    Initially, each fish has a unique position.

    Fish number P is represented by A[P] and B[P].
    Array A contains the sizes of the fish. All its elements are unique.
    Array B contains the directions of the fish.
    It contains only 0s and/or 1s, where:

    0 represents a fish flowing upstream,
    1 represents a fish flowing downstream.

    If two fish move in opposite directions and there are no other (living) fish between them, they will eventually meet each other.
    Then only one fish can stay alive − the larger fish eats the smaller one.
    More precisely, we say that two fish P and Q meet each other when P < Q, B[P] = 1 and B[Q] = 0, and there are no living fish between them.
    After they meet:

    If A[P] > A[Q] then P eats Q, and P will still be flowing downstream,
    If A[Q] > A[P] then Q eats P, and Q will still be flowing upstream.

    We assume that all the fish are flowing at the same speed.
    That is, fish moving in the same direction never meet.
    The goal is to calculate the number of fish that will stay alive.

    For example, consider arrays A and B such that:
    A[0] = 4    B[0] = 0
    A[1] = 3    B[1] = 1
    A[2] = 2    B[2] = 0
    A[3] = 1    B[3] = 0
    A[4] = 5    B[4] = 0

    Initially all the fish are alive and all except fish number 1 are moving upstream.
    Fish number 1 meets fish number 2 and eats it, then it meets fish number 3 and eats it too.
    Finally, it meets fish number 4 and is eaten by it.
    The remaining two fish, number 0 and 4, never meet and therefore stay alive.

    Write a function:

    function solution($A, $B);

    that, given two non-empty zero-indexed arrays A and B consisting of N integers, returns the number of fish that will stay alive.

    For example, given the arrays shown above, the function should return 2, as explained above.

    Assume that:

    N is an integer within the range [1..100,000];
    each element of array A is an integer within the range [0..1,000,000,000];
    each element of array B is an integer that can have one of the following values: 0, 1;
    the elements of A are all distinct.

    Complexity:

    expected worst-case time complexity is O(N);
    expected worst-case space complexity is O(N), beyond input storage (not counting the storage required for input arguments).

    Elements of input arrays can be modified.
     *
     * 100%

     */
    public function fish()
    {
        // push and pop solution
        function solution($A, $B) {
            $N = count($A);
            $alives = [];

            for ($k = 0; $k < $N; $k++) {
                $b = $B[$k];
                $a = $A[$k];

                if (!$alives) {
                    array_push($alives, [$b => $a]);
                } else {
                    $alive = array_pop($alives);
                    array_push($alives, $alive);
                    if ($b == 1 || key($alive) == 0) {
                        array_push($alives, [$b => $a]);
                    } elseif (key($alive) == 1 && current($alive) < $a) {
                        array_pop($alives);
                        $k--;
                    }
                }
            }

            return count($alives);
        }


//        $A = [1,2,3,4,5,6,7,8];
//        $B = [0,0,0,1,0,1,1,1];

        $A = [4, 3, 2, 1, 5];
        $B = [0, 1, 1, 0, 0];

//            $A = [3,4,5,6,3,1,8,2,7];
//            $B = [1,1,1,1,0,1,0,0,1];

        $alive = solution($A, $B);

        _d($alive);
    }

    /**
     *

    A string S consisting of N characters is called properly nested if:

    S is empty;
    S has the form "(U)" where U is a properly nested string;
    S has the form "VW" where V and W are properly nested strings.

    For example, string "(()(())())" is properly nested but string "())" isn't.

    Write a function:

    function solution($S);

    that, given a string S consisting of N characters, returns 1 if string S is properly nested and 0 otherwise.

    For example, given S = "(()(())())", the function should return 1 and given S = "())", the function should return 0, as explained above.

    Assume that:

    N is an integer within the range [0..1,000,000];
    string S consists only of the characters "(" and/or ")".

    Complexity:

    expected worst-case time complexity is O(N);
    expected worst-case space complexity is O(1) (not counting the storage required for input arguments).
     *
     * 100%

     */
    public function nesting()
    {
        function solution($S) {
            $N = strlen($S);
            if ($N % 2 != 0) {
                 return 0;
            }

            $opened = 0;
            for ($i = 0; $i < $N; $i++) {
                if ($S[$i] == ')') {
                    $opened--;

                    if ($opened < 0) {
                        return 0;
                    }
                } else {
                    $opened++;
                }
            }

            return (int) !$opened;
        }

        $S = '(()(())())';
//        $S = '())';
//        $S = ')(';

        $nesting = solution($S);
        dd($nesting);
    }

    /**
     *

    You are going to build a stone wall. The wall should be straight and N meters long, and its thickness should be constant; however, it should have different heights in different places. The height of the wall is specified by a zero-indexed array H of N positive integers. H[I] is the height of the wall from I to I+1 meters to the right of its left end. In particular, H[0] is the height of the wall's left end and H[N−1] is the height of the wall's right end.

    The wall should be built of cuboid stone blocks (that is, all sides of such blocks are rectangular). Your task is to compute the minimum number of blocks needed to build the wall.

    Write a function:

    function solution($H);

    that, given a zero-indexed array H of N positive integers specifying the height of the wall, returns the minimum number of blocks needed to build it.

    For example, given array H containing N = 9 integers:
    H[0] = 8    H[1] = 8    H[2] = 5
    H[3] = 7    H[4] = 9    H[5] = 8
    H[6] = 7    H[7] = 4    H[8] = 8

    the function should return 7. The figure shows one possible arrangement of seven blocks.
    {picture}
    https://codility-frontend-prod.s3.amazonaws.com/media/task_static/stone_wall/static/images/auto/4f1cef49cc46d451e88109d449ab7975.png

    Assume that:

    N is an integer within the range [1..100,000];
    each element of array H is an integer within the range [1..1,000,000,000].

    Complexity:

    expected worst-case time complexity is O(N);
    expected worst-case space complexity is O(N), beyond input storage (not counting the storage required for input arguments).

    Elements of input arrays can be modified.
     *
     * 100%

     */
    public function stone_wall()
    {
        function solution($H) {
            $stones = 0;
            $levels = [];

            foreach ($H as $i => $h) {
                do {
                    $level = array_pop($levels);
                } while ($level > $h);

                if ($level != $h) {
                    $stones++;
                    array_push($levels, $level);
                }

                array_push($levels, $h);
            }

            return $stones;
        }

        $H = [8,8,5,7,9,8,7,4,8];
//        $H = [1,1,1];
//        $H = [2, 3, 2, 1];

        $blocks = solution($H);

        dd($blocks);
    }
}
