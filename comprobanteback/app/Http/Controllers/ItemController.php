<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Unid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function itemunidad(Request $request){
//        return $request;
        $item=Item::find($request->item_id);
        $item->unids()->attach([$request->unid_id]);


    }
    public function eliminaritemunid(Request $request){
//        return $request;
        DB::select("DELETE FROM item_unid WHERE item_id='$request->item_id' AND unid_id='$request->unid_id'");
    }
    public function misitems(Request $request){
        $unid= Unid::where('id',$request->user()->unid_id)->with('items')->get()[0];
        $i= array();
        foreach ($unid->items as $item){
//            echo 's';
            $i[]=$item['id'];
//            var_dump($item);
        }
//        return  $i;
//        exit;
//        return $unid->items;
        return Item::with('unids')
            ->with('subitems')
//            ->where('unid_id',$request->user()->unid_id)
                ->whereIn('id',$i)
            ->where('estado','ACTIVO')
            ->orderBy('nombre')
            ->get();

    }
    public function todoitems(){
        return Item::all();
    }
    public function index(Request $request)
    {
//        return $request->user();
//        $unid=Unid::where('id',$request->user()->unid_id)->with('items')->get();
//        return $unid;

//        return Item::where('unid_id',$request->user()->unid_id)->where('estado','ACTIVO')->orderBy('nombre')->get();

        return DB::select("
    SELECT i.id,i.nombre,i.codigo,i.nombre as nombre2
FROM items i
INNER JOIN item_unid iu ON i.id=iu.item_id
WHERE iu.unid_id='".$request->user()->unid_id."'
AND i.id IN (SELECT item_id FROM subitems GROUP BY item_id)
ORDER BY i.codigo
");
    }
public function nombreitem(Request $request){
//        return $request;
        return Item::where('codigo',$request->coditem)->get();
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
        return Item::with('unids')->with('subitems')->get();
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
//        return Item::with('unids')->with('subitems')->orderBy('nombre')->get();
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
