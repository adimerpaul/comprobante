<?php

namespace App\Http\Controllers;

use App\Models\Anulado;
use App\Models\Comprobante;
use App\Models\Unid;
use Illuminate\Http\Request;

class UnidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Unid::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $unid=Unid::create($input);
        return $unid;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unid  $unid
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$comprobante)
    {
//        return $comprobante;
        $numcomprobante=str_pad($comprobante, 6, '0', STR_PAD_LEFT);
//        return $numcomprobante;
//        return Comprobante::where('nrocomprobante',$numcomprobante)->get();
        if(Comprobante::where('unid_id',$request->user()->unid_id)->where('nrocomprobante',$numcomprobante)->get()->count()>0){
            return "usado";
        }
        if(Anulado::where('unid_id',$request->user()->unid_id)->where('nrocomprobante',$numcomprobante)->get()->count()>0){
            return "anulado";
        }
        return Unid::where('id',$request->user()->unid_id)->firstOrFail();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unid  $unid
     * @return \Illuminate\Http\Response
     */
    public function edit(Unid $unid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unid  $unid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unid $unid)
    {
        //
        $unid->update($request->all());
        return $unid;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unid  $unid
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unid=Unid::find($id);
        $unid->delete();
        return response()->json(['res'=>'Borrado exitoso'],200);
    }
}
