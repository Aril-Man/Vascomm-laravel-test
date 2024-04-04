<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use stdClass;

class LandingController extends Controller
{
    public function index() {

        $data = new stdClass();
        $data->new_product_desc = Product::orderBy('id', 'DESC')->limit(4)->get();
        $data->new_product_asc = Product::orderBy('id', 'ASC')->limit(4)->get();
        $data->all_product = Product::all();

        return view('landing', compact('data'));
    }
}
