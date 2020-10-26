<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function store(Request $request) {
        echo print_r($request->all());
        if($request->hasFile('image')) {
            return "true";
        } else {
            return "false";
        }

    }
}
