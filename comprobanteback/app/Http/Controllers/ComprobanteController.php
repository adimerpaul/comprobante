<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Comprobante;
use App\Models\Detalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Luecano\NumeroALetras\NumeroALetras;

class ComprobanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Comprobante::with('cliente')->with('detalles')->where('unid_id',$request->user()->unid_id)->where('estado','CREADO')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request;
        if (Cliente::where('ci',$request->ci)->get()->count()==0 && $request->ci!=''){
            $cliente=Cliente::create([
                'paterno'=>$request->paterno,
                'ci'=>$request->ci,
                'materno'=>$request->materno,
                'nombre'=>$request->nombre,
                'padron'=>$request->padron,
                'expedido'=>$request->expedido,
                'direccion'=>$request->direccion,
                'numcasa'=>$request->numcasa,
            ]);
//            return $cliente;
        }else{
            $cliente=Cliente::where('ci',$request->ci)->firstOrFail();
            $cliente->nombre=$request->nombre;
            $cliente->paterno=$request->paterno;
            $cliente->materno=$request->materno;
            $cliente->padron=$request->padron;
            $cliente->expedido=$request->expedido;
            $cliente->direccion=$request->direccion;
            $cliente->numcasa=$request->numcasa;
            $cliente->save();
        }
//        return $cliente;
        $formatter = new NumeroALetras();
        $literal= $formatter->toWords($request->total);
        $comprobante=Comprobante::create([
            'nrotramite'=>$request->nrotramite,
//            'nrocomprobante'=>'139044',
            'fecha'=>date('Y-m-d'),
            'fechalimite'=>date("Y-m-d",strtotime(now()."+ 7 days")),
            'tipo'=>'VARIOS',
            'codigo'=>'',
            'valorcatastral'=>'',
            'mtsfrte'=>'',
            'placa'=>'',
            'marca'=>'',
            'modelo'=>'',
            'padron'=>$cliente->padron,
            'capital'=>'',
            'varios'=>'PMC '.$cliente->padron,
            'tipopago'=>'EFECTIVO',
            'banco'=>'',
            'banconro'=>'',
            'intere'=>'',
            'multa'=>'',
            'otros'=>'',
            'formulario'=>'',
            'total'=>$request->total,
            'literal'=>$literal,
            'controlinterno'=>'',
            'estado'=>'CREADO',
            'cajero'=>'',
            'user_id'=>$request->user()->id,
            'cliente_id'=>$cliente->id,
            'unid_id'=>$request->user()->unid_id,
        ]);
//        return $comprobante;
        foreach ($request->data as $row){
//            echo $row['subtotal'].' -';
            Detalle::create([
                'coditem'=>$row['coditem'],
                'nombreitem'=>$row['nombreitem'],
                'codsubitem'=>$row['codsubitem'],
                'nombresubitem'=>$row['nombresubitem'],
                'detalle'=>$row['detalle'],
                'precio'=>$row['precio'],
                'cantidad'=>$row['cantidad'],
                'subtotal'=>$row['subtotal'],
                'comprobante_id'=>$comprobante->id,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comprobante  $comprobante
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        return Comprobante::where('user_id',$request->user()->id)->get()->count();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comprobante  $comprobante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comprobante $comprobante)
    {
        $comprobante->update([
            'fechapago'=>date('Y-m-d'),
            'cajero'=>$request->user()->name,
            'estado'=>'CANCELADO',
            'nrocomprobante'=>$request->nrocomprobante,
            'controlinterno'=>$request->nrocomprobante.date('d/m/Y'),
        ]);
//        echo $comprobante;
        return Comprobante::with('cliente')->where('id',$comprobante->id)->with('detalles')->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comprobante  $comprobante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comprobante $comprobante)
    {
        //
    }

    public function contribuyente($comun){
        return DB::connection('simat')->table('pm01cont')->select('comun','expedido','paterno','materno','nombre','descrip','numcasa','telefono')->where('comun','like','%'.$comun.'%')->limit(10)->get();
    }
}
