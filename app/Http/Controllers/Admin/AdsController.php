<?php

namespace App\Http\Controllers\Admin;

use App\Ads;

class AdsController extends AdminController
{
    public function index(): null
    {
        $ads = Ads::all();
        return view('admin.ads.index', compact('ads'));
    }

    public function create()
    {
    }

    
    public function store(): null
    {
    }

    public function edit($id)
    {
    }

    public function update($id)
    {
    }

    public function destroy($id)
    {
        
    }

}