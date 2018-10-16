<?php

namespace App\Http\Controllers\Lessons;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrimeAndCompositeNumbersController extends Controller
{
    /**
     * A positive integer D is a factor of a positive integer N if there exists an integer M such that N = D * M.

    For example, 6 is a factor of 24, because M = 4 satisfies the above condition (24 = 6 * 4).

    Write a function:

    function solution($N);

    that, given a positive integer N, returns the number of its factors.

    For example, given N = 24, the function should return 8, because 24 has 8 factors, namely 1, 2, 3, 4, 6, 8, 12, 24. There are no other factors of 24.

    Assume that:

    N is an integer within the range [1..2,147,483,647].
    Complexity:

    expected worst-case time complexity is O(sqrt(N));
    expected worst-case space complexity is O(1).
     */
    public function count_factors()
    {
        function solution($N) {
            $factors = 0;
            for ($i = 1; $i * $i < $N; $i++) {
                if ($N % $i == 0) {
                    $factors += 2;
                }
            }

            if ($i * $i == $N) {
                $factors++;
            }

            return $factors;
        }

        $N = 24;

        dd(solution($N));
    }

    /**
     * An integer N is given, representing the area of some rectangle.

    The area of a rectangle whose sides are of length A and B is A * B, and the perimeter is 2 * (A + B).

    The goal is to find the minimal perimeter of any rectangle whose area equals N. The sides of this rectangle should be only integers.

    For example, given integer N = 30, rectangles of area 30 are:

    (1, 30), with a perimeter of 62,
    (2, 15), with a perimeter of 34,
    (3, 10), with a perimeter of 26,
    (5, 6), with a perimeter of 22.
    Write a function:

    function solution($N);

    that, given an integer N, returns the minimal perimeter of any rectangle whose area is exactly equal to N.

    For example, given an integer N = 30, the function should return 22, as explained above.

    Assume that:

    N is an integer within the range [1..1,000,000,000].
    Complexity:

    expected worst-case time complexity is O(sqrt(N));
    expected worst-case space complexity is O(1).
     */
    public function min_perimeter_rectangle()
    {
        function solution($N) {
            $lastDivisor = 0;
            for ($i = 1; $i * $i <= $N; $i++) {
                if ($N % $i == 0) {
                    $lastDivisor = $i;
                }
            }

            return 2 * ($lastDivisor + ($N / $lastDivisor));
        }

        $N = 36;

        dd(solution($N));
    }

    /**
     *

    A non-empty array A consisting of N integers is given.

    A peak is an array element which is larger than its neighbors. More precisely, it is an index P such that 0 < P < N − 1,  A[P − 1] < A[P] and A[P] > A[P + 1].

    For example, the following array A:
    A[0] = 1
    A[1] = 2
    A[2] = 3
    A[3] = 4
    A[4] = 3
    A[5] = 4
    A[6] = 1
    A[7] = 2
    A[8] = 3
    A[9] = 4
    A[10] = 6
    A[11] = 2

    has exactly three peaks: 3, 5, 10.

    We want to divide this array into blocks containing the same number of elements. More precisely, we want to choose a number K that will yield the following blocks:

    A[0], A[1], ..., A[K − 1],
    A[K], A[K + 1], ..., A[2K − 1],
    ...
    A[N − K], A[N − K + 1], ..., A[N − 1].

    What's more, every block should contain at least one peak. Notice that extreme elements of the blocks (for example A[K − 1] or A[K]) can also be peaks, but only if they have both neighbors (including one in an adjacent blocks).

    The goal is to find the maximum number of blocks into which the array A can be divided.

    Array A can be divided into blocks as follows:

    one block (1, 2, 3, 4, 3, 4, 1, 2, 3, 4, 6, 2). This block contains three peaks.
    two blocks (1, 2, 3, 4, 3, 4) and (1, 2, 3, 4, 6, 2). Every block has a peak.
    three blocks (1, 2, 3, 4), (3, 4, 1, 2), (3, 4, 6, 2). Every block has a peak. Notice in particular that the first block (1, 2, 3, 4) has a peak at A[3], because A[2] < A[3] > A[4], even though A[4] is in the adjacent block.

    However, array A cannot be divided into four blocks, (1, 2, 3), (4, 3, 4), (1, 2, 3) and (4, 6, 2), because the (1, 2, 3) blocks do not contain a peak. Notice in particular that the (4, 3, 4) block contains two peaks: A[3] and A[5].

    The maximum number of blocks that array A can be divided into is three.

    Write a function:

    function solution($A);

    that, given a non-empty array A consisting of N integers, returns the maximum number of blocks into which A can be divided.

    If A cannot be divided into some number of blocks, the function should return 0.

    For example, given:
    A[0] = 1
    A[1] = 2
    A[2] = 3
    A[3] = 4
    A[4] = 3
    A[5] = 4
    A[6] = 1
    A[7] = 2
    A[8] = 3
    A[9] = 4
    A[10] = 6
    A[11] = 2

    the function should return 3, as explained above.

    Write an efficient algorithm for the following assumptions:

    N is an integer within the range [1..100,000];
    each element of array A is an integer within the range [0..1,000,000,000].
     *
     *
     * 100%
     *
     *
     *

     */
    public function peaks()
    {
        function findPeaks($A) {
            $last = count($A) - 1;
            $peaks = [];
            for ($i = 1; $i < $last; $i++) {
                $p = $A[$i - 1];
                $v = $A[$i];
                $n = $A[$i + 1];
                if ($p < $v && $v > $n) {
                    $peaks[] = $i;
                    $i++;
                }
            }

            return $peaks;
        }

        function getLastChunkPeakEnds($peaks, $size) {
            $chunkKey = 0;
            foreach ($peaks as $peak) {
                $peakInChunk = intval($peak / $size);
                if ($peakInChunk > $chunkKey) {
                    break;
                }
                if ($peakInChunk == $chunkKey) {
                    $chunkKey++;
                }
            }

            return $chunkKey;
        }

        function solution($A) {
            $countA = count($A);

            $peaks = findPeaks($A);
            $countPeaks = count($peaks);

            switch ($countPeaks) {
                case 0:
                case 1:
                    return $countPeaks;
            }

            $dividers = [];

            if ($countPeaks * $countPeaks >= $countA) {
                /**
                 * find all chunks for peaks count that give square production more than array length:
                 * 60: ($i = divisors located right side (except 60 and 30 - impossible amount of peaks); store left divisors in $dividers)
                 * 1 = 60
                 * 2 = 30
                 * 3 = 20
                 * 4 = 15
                 * 5 = 12
                 * 6 = 10
                 */
                for ($i = $countPeaks, $production = $i * $i; $production >= $countA; $i--, $production = $i * $i) {
                    if ($countA % $i == 0) {
                        $divider = $countA / $i;

                        if ($production != $countA) {
                            $dividers[] = $divider;
                        }

                        $chunkKey = getLastChunkPeakEnds($peaks, $divider);
                        if ($chunkKey == $i) {
                            return $i;
                        }
                    }
                }

                /**
                 * 60: ($dividers = divisors located left side except 1 and 2)
                 * 1 = 60
                 * 2 = 30
                 * 3 = 20
                 * 4 = 15
                 * 5 = 12
                 * 6 = 10
                 */
                foreach ($dividers as $i) {
                    $chunkKey = getLastChunkPeakEnds($peaks, $countA / $i);
                    if ($chunkKey == $i) {
                        return $i;
                    }
                }

                /**
                 * handle last dividers: 1 and 2
                 */
                foreach ([1, 2] as $i) {
                    $chunkKey = getLastChunkPeakEnds($peaks, $countA / $i);
                    if ($chunkKey == $i) {
                        return $i;
                    }
                }
            } else {
                for ($i = $countPeaks; $i > 0; $i--) {
                    if ($countA % $i == 0) {
                        $chunkKey = getLastChunkPeakEnds($peaks, $countA / $i);
                        if ($chunkKey == $i) {
                            return $i;
                        }
                    }
                }
            }

            return 0;
        }

        $A = [1,2,3,"4", 3,"4",1,"4", 3,4,"6",2];
//        $A = [0, 1000000000];
//        $A = [1, 1, 3, 2, 1, 3, 2, 3, 2, 3, 2, 1];

        dd(solution($A));
    }


    /**
     * 100% (copy-paste)
     */
    public function peaks2()
    {
        function solution($A) {
            $n = count($A);
            $prev = $n - 1;
            if ($n <= 2) {
                return 0;
            }

            $sum = array_fill(0, $n,0);
            $last = -1;
            $D = 0;

            // fill $sum by amount of peaks on each index
            for ($i = 1; $i < $prev; $i++) {
                $sum[$i] = $sum[$i - 1];
                if (($A[$i] > $A[$i - 1]) && ($A[$i] > $A[$i + 1])) {
                    $D = max($D, $i - $last);
                    $last = $i;
                    ++$sum[$i];
                }
            }

            // if no peaks
            if (($sum[$n - 1] = $sum[$n - 2]) == 0) {
                return 0;
            }

            $D = max($D, $n - $last);
            for ($i = ($D >> 1) + 1; $i < $D; $i++) {
                if ($n % $i == 0) {
                    $last = 0;
                    for ($j = $i; $j <= $n; $j += $i) {
                        if ($sum[$j - 1] <= $last) {
                            break;
                        }
                        $last = $sum[$j - 1];
                    }
                    if ($j > $n) {
                        return $n / $i;
                    }
                }
            }
            for ($last = $D; $n % $last; ++$last);
            return intval($n / $last);
        }

        $A = [1,2,3,"4",3,"4",1,2,3,4,"6",2];
//        $A = [1, 1, 3, 2, 1, 3, 2, 3, 2, 3, 2, 1];

        dd(solution($A));
    }
}
