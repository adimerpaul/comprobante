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


//        $comprobante=Comprobante::create([
//            'unid_id'=>$comprobante->unid_id,
//            'nrotramite'=>$comprobante->nrotramite,
//            'fecha'=>$comprobante->fecha,
//            'fechalimite'=>$comprobante->fechalimite,
//            'tipo'=>$comprobante->tipo,
//            'codigo'=>'',
//            'valorcatastral'=>'',
//            'mtsfrte'=>'',
//            'placa'=>'',
//            'marca'=>'',
//            'modelo'=>'',
//            'padron'=>$comprobante->padron,
//            'capital'=>'',
//            'varios'=>$comprobante->varios,
//            'tipopago'=>$comprobante->tipopago,
//            'banco'=>'',
//            'banconro'=>'',
//            'intere'=>'',
//            'multa'=>'',
//            'otros'=>'',
//            'formulario'=>'',
//            'total'=>$comprobante->total,
//            'literal'=>$comprobante->literal,
//            'controlinterno'=>'',
//            'estado'=>$comprobante->estado,
//            'cajero'=>'',
//            'user_id'=>$comprobante->user_id,
//            'cliente_id'=>$comprobante->cliente_id,
//            'item'=>$comprobante->item
//        ]);
        $com=new Comprobante();
        $com->unid_id=$comprobante->unid_id;
        $com->nrotramite=$comprobante->nrotramite;
        $com->fecha=$comprobante->fecha;
        $com->fechalimite=$comprobante->fechalimite;
        $com->tipo=$comprobante->tipo;
        $com->codigo='';
        $com->valorcatastral='';
        $com->mtsfrte='';
        $com->placa='';
        $com->marca='';
        $com->modelo='';
        $com->padron=$comprobante->padron;
        $com->capital='';
        $com->varios=$comprobante->varios;
        $com->tipopago=$comprobante->tipopago;
        $com->banco='';
        $com->banconro='';
        $com->intere='';
        $com->multa='';
        $com->otros='';
        $com->formulario='';
        $com->total=$comprobante->total;
        $com->literal=$comprobante->literal;
        $com->controlinterno='';
        $com->estado='CREADO';
        $com->cajero='';
        $com->user_id=$comprobante->user_id;
        $com->cliente_id=$comprobante->cliente_id;
        $com->item=$comprobante->item;
        $com->save();

        $detalles=Detalle::where('comprobante_id',$comprobante->id)->get();
        foreach ($detalles as $detalle){
            $d= new Detalle();
            $d->coditem=$detalle->coditem;
            $d->nombreitem=$detalle->nombreitem;
            $d->codsubitem=$detalle->codsubitem;
            $d->nombresubitem=$detalle->nombresubitem;
            $d->detalle=$detalle->detalle;
            $d->precio=$detalle->precio;
            $d->cantidad=$detalle->cantidad;
            $d->subtotal=$detalle->subtotal;
            $d->comprobante_id=$com->id;
        }

        $nroprobante=$comprobante->nrocomprobante;

        $comprobante->estado='ANULADO';
        $comprobante->cliente_id=1;
        $comprobante->cajero=$request->user()->codigo;
        $comprobante->cajero_id=$request->user()->id;
//        $comprobante->nrocomprobante='';
        $comprobante->total=0;
//        $comprobante->controlinterno='';
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
    public function show($fecha,Request $request)
    {
        return Anulado::with('user')
            ->with('unid')
            ->with('comprobante')
//            ->where('user_id',$request->user()->id)
            ->where('unid_id',$request->user()->unid_id)
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
