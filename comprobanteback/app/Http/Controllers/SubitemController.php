<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Subitem;
use Illuminate\Http\Request;

class SubitemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return "aa";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subitem  $subitem
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$item_id)
    {
        return Subitem::where('item_id',$item_id)->where('unid_id',$request->user()->unid_id)->orderBy('monto')->get();
//        return
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subitem  $subitem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subitem $subitem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subitem  $subitem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subitem $subitem)
    {
        //
    }
}
