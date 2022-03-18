<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Subitem;
use Illuminate\Http\Request;
use Illuminate\Http\DB;


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
//        return $item;
        if(($item->count())>0)
        {
            $num=trim(Subitem::where('item_id',$item->id)->max('codigo'));
//            return $num;
            if ($num==''){
//                $num1=strlen(trim($item->codigo));
                $num2=intval(1);
            }else{
                $num1=strlen(trim($item->codigo));
                $num2=intval(substr($num,$num1) + 1);
            }
//            return $num;


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
        return Subitem::where('item_id',$item_id)
//            ->where('unid_id',$request->user()->unid_id)
            ->orderBy('id')
            ->where('estado','ACTIVO')
            ->get();
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
        $subitem->update($request->all());
        return $subitem;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subitem  $subitem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $subitem=Subitem::find($id);
        $subitem->delete();
        return response()->json(['res'=>'Borrado exitoso'],200);
    }

    public function listasubitem($id){
        return Subitem::where('item_id',$id)->get();
    }
    public function cambiosubitem(Subitem $subitem){
//        return  $subitem;
        if ($subitem->estado=='ACTIVO'){
            $subitem->estado='INCATIVO';
        }else{
            $subitem->estado='ACTIVO';
        }
        $subitem->save();
        return 1;
    }
}
