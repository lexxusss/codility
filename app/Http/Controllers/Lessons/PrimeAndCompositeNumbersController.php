<?php

namespace App\Http\Controllers\Lessons;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrimeAndCompositeNumbersController extends Controller
{
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
}
