<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function test(Request $request) {
        function esc($data)
        {
            return $data .= '1123';
        }

        if ($request->get('user_login_name')) {
            $getData = array_map(function($item) {
                return htmlspecialchars($item, ENT_QUOTES , "UTF-8");
            }, $_GET);
            $postData = array_map(function($item) {
                return htmlspecialchars($item, ENT_QUOTES , "UTF-8");
            }, $_POST);

            die;
        } else {
            return view('test');
        }
    }
}
