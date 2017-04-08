<?php

use \Illuminate\Support\Facades\Route;
use \Illuminate\Routing\Router;

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

Route::group(['namespace' => 'Lessons'], function(Router $route) {
    $route->get('/cyclic_rotation', 'ArraysController@cyclic_rotation');

    $route->get('/binary_gap', 'IterationsController@binary_gap');

    $route->get('/tape_equilibrium', 'TimeComplexityController@tape_equilibrium');

    $route->get('/missing_integer', 'CountingElementsController@missing_integer');
    $route->get('/perm_check', 'CountingElementsController@perm_check');
    $route->get('/frog_river_one', 'CountingElementsController@frog_river_one');
    $route->get('/max_counters', 'CountingElementsController@max_counters');

    $route->get('/count_div', 'PrefixSumsController@count_div');
    $route->get('/passing_cars', 'PrefixSumsController@passing_cars');
    $route->get('/genomic_range_query', 'PrefixSumsController@genomic_range_query');
    $route->get('/min_avg_two_slice', 'PrefixSumsController@min_avg_two_slice');

    $route->get('/distinct', 'SortingController@distinct');
    $route->get('/max_product_of_three', 'SortingController@max_product_of_three');
    $route->get('/triangle', 'SortingController@triangle');
    $route->get('/number_of_disc_intersections', 'SortingController@number_of_disc_intersections');

    $route->get('/ ', 'StackAndQueuesController@brackets');
    $route->get('/fish', 'StackAndQueuesController@fish');
});

Route::group(['namespace' => 'Alex'], function (Router $route) {
    $route->group(['namespace' => 'Algorithms'], function (Router $route) {
        $route->get('/alex/algorithms/simple', 'SimpleController@index');
    });
});


Route::get('/count_palindromic_slices', 'Gamma2011Controller@count_palindromic_slices');
Route::get('/diagonal_difference', 'HackerRancController@diagonal_difference');
Route::get('/min_abs_sum', 'Delta2011Controller@min_abs_sum');
Route::get('/ball_switch_board', 'Zeta2011Controller@ball_switch_board');


