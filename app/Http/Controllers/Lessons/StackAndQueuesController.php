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
        function getCurrentFishIndex($from, $B, $UP_STREAM) {
            for ($currentFishIndex = $from; $currentFishIndex >= 0 && $B[$currentFishIndex] === $UP_STREAM; $currentFishIndex--);

            return $currentFishIndex;
        }

        function getNextFishIndex($nextFishIndex, $B, $eaten) {
//            if ($eaten == 2) dd($nextFishIndex, $B);
            $nextFishIndex++;

            if (array_key_exists($nextFishIndex, $B) && is_null($B[$nextFishIndex])) {
                $nextFishIndex += $eaten - 1;
            }
            if (is_null($B[$nextFishIndex])) {
                $nextFishIndex++;
            }


            return $nextFishIndex;
        }


        function toString($A, $B, $O = []) {
            $corpse = 'X';
            $S = '';

            foreach ($A as $item) {
                $S .= !is_null($item) ? "$item . " : $corpse . " . ";
            }
            $S = substr($S, 0, -3) . "\r\n";

            foreach ($B as $item) {
                $S .= !is_null($item) ? "$item . " : $corpse . " . ";
            }
            $S = substr($S, 0, -3) . "\r\n" . "\r\n";

            if ($O) {
                foreach ($O as $item) {
                    $S .= !is_null($item) ? "$item . " : $corpse . " . ";
                }
                $S = substr($S, 0, -3) . "\r\n";
            }

            return $S;
        }

        function solution ($A, $B) {
            $UP_STREAM = 0;
            $DOWN_STREAM = 1;

            $survive = $length = count($A);

            $currentFishIndex = getCurrentFishIndex($length - 1, $B, $UP_STREAM);
            $nextFishIndex = $currentFishIndex + 1;

            $eaten = 0;
            while ($currentFishIndex > -1) {
                _d($currentFishIndex, toString($A, $B), $nextFishIndex, "survive: $survive");
                if ($nextFishIndex >= $length || $B[$nextFishIndex] == $DOWN_STREAM) {
                    $currentFishIndex = getCurrentFishIndex($currentFishIndex - 1, $B, $UP_STREAM);
                    $nextFishIndex = getNextFishIndex($currentFishIndex, $B, $eaten);
                    continue;
                }

                $currentFishSize = $A[$currentFishIndex];
                $nextFishSize = $A[$nextFishIndex];

                if ($currentFishSize > $nextFishSize) { # if it eats upstream fish
                    $B[$nextFishIndex] = null;
                    $survive--;
                    $eaten++;

                    $nextFishIndex = getNextFishIndex($nextFishIndex, $B, $eaten);
                } else { # if it will be eaten
                    $B[$currentFishIndex] = null;
                    $survive--;
                    $eaten++;

                    $currentFishIndex = getCurrentFishIndex($currentFishIndex - 1, $B, $UP_STREAM);
                    $nextFishIndex = getNextFishIndex($currentFishIndex, $B, $eaten);
                }
            }

            _d($currentFishIndex, toString($A, $B), $nextFishIndex);

            return $survive;
        }


//        $A = [1,2,3,4,5,6,7,8];
//        $B = [0,0,0,1,0,1,1,1];

//        $A = [4, 3, 2, 1, 5];
//        $B = [0, 1, 0, 0, 0];

        $A = [3,4,5,6,3,1,8,2,7];
        $B = [1,1,1,1,0,1,0,0,1];

//        $count = 100;
//        $A = array_merge(array_fill(0, $count / 2, 0), array_fill(0, $count / 2, 1));
//        $B = range(1, $count);
//        shuffle($B);

        $alive = solution($A, $B);

        dd($alive);
    }
}
