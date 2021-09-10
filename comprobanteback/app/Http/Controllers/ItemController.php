<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function misitems(Request $request){
        return Item::with('unid')->with('subitems')->where('unid_id',$request->user()->unid_id)->where('estado','ACTIVO')->orderBy('nombre')->get();

    }
    public function index(Request $request)
    {
//        return $request->user()->unid_id;
        return Item::where('unid_id',$request->user()->unid_id)->where('estado','ACTIVO')->orderBy('nombre')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input=$request->all();
        //        $input['imagen']=$ruta;
        $item=Item::create($input);
        return $item;
    }
    public function misitemcrear(Request $request){
        $item= new Item();
        $item->codigo=$request->codigo;
        $item->nombre=$request->nombre;
        $item->unid_id=$request->user()->unid_id;
        $item->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return Item::with('unid')->with('subitems')->orderBy('nombre')->get();
    }
    public function cambio(Item $item)
    {
        if ($item->estado=='ACTIVO'){
            $item->estado='INACTIVO';
        }else{
            $item->estado='ACTIVO';
        }
        $item->save();
        echo 1;
//        return Item::with('unid')->with('subitems')->orderBy('nombre')->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
        $item->update($request->all());
        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $item=Item::find($id);
        $item->delete();
        return response()->json(['res'=>'Borrado exitoso'],200);

    }
}
