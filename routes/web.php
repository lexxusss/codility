<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/missing_integer', 'CountingElementsController@missing_integer');
Route::get('/perm_check', 'CountingElementsController@perm_check');
Route::get('/frog_river_one', 'CountingElementsController@frog_river_one');
Route::get('/max_counters', 'CountingElementsController@max_counters');

Route::get('/count_palindromic_slices', 'Gamma2011Controller@count_palindromic_slices');

Route::get('/diagonal_difference', 'HackerRancController@diagonal_difference');

Route::get('/min_abs_sum', 'Delta2011Controller@min_abs_sum');

Route::get('/ball_switch_board', 'Zeta2011Controller@ball_switch_board');

Route::get('/binary_gap', 'Lessons\IterationsController@binary_gap');

Route::get('/cyclic_rotation', 'Lessons\ArraysController@cyclic_rotation');

Route::get('/tape_equilibrium', 'Lessons\TimeComplexityController@tape_equilibrium');
