<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::match(array('GET', 'POST'), '/getebay', function()
{
    $app = new Cubet\Ebay\Ebay;
    $input = Input::all();
    $data = $app->ebayManagement($input) ;
    return View::make('ebay::ebay',$data);
});
