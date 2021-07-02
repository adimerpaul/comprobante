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
        $item=Item::find($request->id);
        if(($item->count())>0)
        {
            $num=trim(Subitem::where('item_id',$item->id)->max('codigo'));
        
            $num1=strlen(trim($item->codigo));
            $num2=intval(substr($num,$num1) + 1);
            //$num2= intval(substr($num,strlen($num)-2) + 1) ;
            //echo $num2; 
            //exit;
        }
        else $num2=1;
        if($num2<10)
            $subcodigo=strtoupper($request->codigo.'0'.$num2);
        else
            $subcodigo=strtoupper($request->codigo.$num2);

        $subitem=new Subitem();
        $subitem->codigo=$subcodigo;
        $subitem->nombre=$request->subnombre;
        $subitem->monto=$request->submonto;
        $subitem->unid_id=$request->unid_id;
        $subitem->item_id=$request->id;
        $subitem->save();
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
