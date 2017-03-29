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

     */
    public function brackets()
    {
        function solution($S) {
            $pairs = [
                ')' => '(',
                ']' => '[',
                '}' => '{',
            ];

            $length = strlen($S);

            if ($length % 2 != 0) return 0;

            $opened = [];
            $openedLastIndex = -1;
            for ($i = 0; $i < $length; $i++) {
                $char = $S[$i];

                if (in_array($char, $pairs)) {
                    $opened[] = $char;
                    $openedLastIndex++;
                } else {
                    if ($openedLastIndex < 0 || $opened[$openedLastIndex] != $pairs[$char]) {
                        return 0;
                    }

                    array_pop($opened);
                    $openedLastIndex--;
                }
            }

            return (int) empty($opened);
        }

//        $S = '{[()()]}';
//        $S = '([)()]';
        $S = '{()[()]}';

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

     */
    public function fish()
    {
        function getLastDownStreamIndex($from, $B, $DOWN_STREAM) {
            for ($lastDownStream = $from; $lastDownStream > 0 && $B[$lastDownStream] != $DOWN_STREAM; $lastDownStream--);

            return $lastDownStream;
        }

        function exchangeTwoFishes(&$A, &$B, &$currentFishIndex, &$nextFishIndex) {
            $buff = $A[$currentFishIndex];
            $A[$currentFishIndex] = $A[$nextFishIndex];
            $A[$nextFishIndex] = $buff;

            $buff = $B[$currentFishIndex];
            $B[$currentFishIndex] = $B[$nextFishIndex];
            $B[$nextFishIndex] = $buff;

            $buff = $currentFishIndex;
            $currentFishIndex = $nextFishIndex;
            $nextFishIndex = $buff;
        }

        function solution ($A, $B) {
            $DOWN_STREAM = 1;

            $length = count($A);

            $currentFishIndex = getLastDownStreamIndex($length - 1, $B, $DOWN_STREAM);
            $nextFishIndex = $currentFishIndex + 1;

            $nextFishStream = $B[$nextFishIndex];

//            dd($l, $r, $currentFishIndex);
            # (eat OR cross OR will be eaten by) the next upstream fish UNTIL (it meats downstream fish OR there will not more fishes)
            while ($nextFishStream != $DOWN_STREAM && $nextFishIndex < $length) {
                if ($nextFishStream == $DOWN_STREAM) {
                    $currentFishIndex = getLastDownStreamIndex($currentFishIndex, $B, $DOWN_STREAM);
                    $nextFishIndex = $currentFishIndex + 1;
                    continue;
                }

                if (!array_key_exists($currentFishIndex, $A)) dd($currentFishIndex);
                $currentFishSize = $A[$currentFishIndex];
                $nextFishSize = $A[$nextFishIndex];

                if ($currentFishSize > $nextFishSize) {
                    # if it eats upstream fish -> remove upstream fish and compare further
                    array_splice($A, $nextFishIndex, 1);
                    array_splice($B, $nextFishIndex, 1);

                    $nextFishIndex++;
                    $length--;
                } elseif ($currentFishSize < $nextFishSize) {
                    # if it will be eaten -> launch new comparison loop with downstream fish and new upstream fish
                    array_splice($A, $currentFishIndex, 1);
                    array_splice($B, $currentFishIndex, 1);

                    $currentFishIndex = getLastDownStreamIndex($currentFishIndex, $B, $DOWN_STREAM);
                    $nextFishIndex = $currentFishIndex + 1;
                } else {
                    # if it will be crossing through the downstream fish -> exchange two fishes
                    exchangeTwoFishes($A, $B, $currentFishIndex, $nextFishIndex);
                }
            }

            dd($l, $r, $length);

            return $alive;
        }


        $A = [1,2,3,4,5,6,7,8];
        $B = [0,0,0,1,0,1,1,1];

        $A = [4, 3, 2, 1, 5];
        $B = [0, 1, 0, 0, 0];

//        $A = [1,4,3,4,4,3,2,1,2];
//        $B = [1,1,1,1,0,1,0,0,1];

        $alive = solution($A, $B);

        dd($alive);
    }
}
