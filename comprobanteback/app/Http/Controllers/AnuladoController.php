<?php

namespace App\Http\Controllers;

use App\Models\Anulado;
use App\Models\Comprobante;
use App\Models\Detalle;
use Illuminate\Http\Request;

class AnuladoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        return $request->all();
        return Anulado::with('user')
            ->with('unid')
            ->with('comprobante')
            ->where('user_id',$request->user()->id)
//            ->where('user_id',$request->user()->id)
            ->whereDate('fecha',$request->fecha)
            ->get();
//        return Anulado::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        /*no usado*/
        return Comprobante::with('cliente')
            ->with('detalles')
            ->with('unid')
//            ->whereDate('fechalimite','>=',now())
            ->whereDate('fecha',now())
            ->where('unid_id',$request->user()->unid_id)
            ->where('impreso_id',$request->user()->id)
            ->where('estado','IMPRESO')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comprobante=Comprobante::find($request->comprobante_id);
        $comprobante->ci='0';
        $comprobante->paterno='ANULADO';
        $comprobante->materno='ANULADO';
        $comprobante->nombre='ANULADO';
        $comprobante->estado='ANULADO';
        $comprobante->cliente_id=1;
//        $comprobante->cajero=$request->user()->codigo;
//        $comprobante->cajero_id=$request->user()->id;
        $comprobante->total=0;
        $comprobante->save();
        $detalles=Detalle::where('comprobante_id',$request->comprobante_id)->get();
        foreach ($detalles as $detalle){
            Detalle::where('id',$detalle['id'])->update(['precio'=>0,'subtotal'=>0]);
        }
        return  $comprobante;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Anulado  $anulado
     * @return \Illuminate\Http\Response
     */
    public function show($fecha,Request $request)
    {
//        return Anulado::with('user')
//            ->with('unid')
//            ->with('comprobante')
////            ->where('user_id',$request->user()->id)
//            ->where('unid_id',$request->user()->unid_id)
//            ->whereDate('fecha',$fecha)
//            ->get();

        return Comprobante::with('user')
            ->with('unid')
            ->with('cliente')
//            ->where('user_id',$request->user()->id)
            ->where('unid_id',$request->user()->unid_id)
            ->where('estado','ANULADO')
            ->whereDate('fecha',$fecha)
            ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Anulado  $anulado
     * @return \Illuminate\Http\Response
     */
    public function edit(Anulado $anulado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Anulado  $anulado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Anulado $anulado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Anulado  $anulado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Anulado $anulado)
    {
        //
    }
}
