<?php

namespace App\Http\Controllers;

use App\Models\Anulado;
use App\Models\Comprobante;
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
            ->whereDate('fechalimite','>=',now())
            ->where('unid_id',$request->user()->unid_id)
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
        $nroprobante=$comprobante->nrocomprobante;
        $comprobante->estado='CREADO';
        $comprobante->nrocomprobante='';
        $comprobante->controlinterno='';
        $comprobante->save();
        Anulado::create([
            'nrocomprobante'=>$nroprobante,
            'fecha'=>date('Y-m-d'),
            'hora'=>date('H:i:s'),
            'comprobante_id'=>$comprobante->id,
            'unid_id'=>$request->user()->unid_id,
            'user_id'=>$request->user()->id,
        ]);
        echo 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Anulado  $anulado
     * @return \Illuminate\Http\Response
     */
    public function show($fecha)
    {
        return Anulado::with('user')
            ->with('unid')
            ->with('comprobante')
//            ->where('user_id',$request->user()->id)
//            ->where('user_id',$request->user()->id)
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
