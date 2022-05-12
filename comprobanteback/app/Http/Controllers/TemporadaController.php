<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Comprobante;
use App\Models\Detalle;
use App\Models\Registro;
use Illuminate\Http\Request;
use Luecano\NumeroALetras\NumeroALetras;

class TemporadaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $registro=Registro::find($request->registro_id);
        $registro->largo=$request->largo==null?'':$request->largo;
        $registro->ancho=$request->ancho==null?'':$request->ancho;
        $registro->rubro_id=$request->rubro_id;
        $registro->save();

        if (count($request->data)==1){
            $item=$request->data[0]['coditem'];
        }else{
            $item=$request->data[1]['coditem'];
        }
//        return $request->user();
        $cliente=Cliente::where('ci',$request->ci)->firstOrFail();
//        return $cliente;
        $formatter = new NumeroALetras();
        $literal= $formatter->toWords($request->total);
//        return $request->user()->unid_id;
        $comprobante=Comprobante::create([
            'unid_id'=>$request->user()->unid_id,
            'nrotramite'=>$request->nrotramite,
            'temporada'=>$registro->temporada,
//            'nrocomprobante'=>'139044',
            'fecha'=>date('Y-m-d'),
            'fechalimite'=>date("Y-m-d",strtotime(now()."+ 21 days")),
            'tipo'=>'VARIOS',
            'codigo'=>'',
            'valorcatastral'=>'',
            'mtsfrte'=>'',
            'placa'=>'',
            'marca'=>'',
            'modelo'=>'',
//            'padron'=>$cliente->padron,
            'capital'=>'',
            'varios'=>"",
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
            'item'=>$item,
            'ci'=>$cliente->ci,
            'paterno'=>$cliente->paterno,
            'materno'=>$cliente->materno,
            'nombre'=>$cliente->nombre,
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
                'subtotal'=>$row['monto'],
                'comprobante_id'=>$comprobante->id,
            ]);
        }
        $numcomprobante=str_pad($request->nrocomprobante, 6, '0', STR_PAD_LEFT);
        $count=Comprobante::where('nrocomprobante',$numcomprobante)->where('unid_id',$request->user()->unid_id)->get()->count();
        if ($count>0){
            return response()->json(["res"=>'El numero de comprobante ya se encuentra en uso de esa unidad'],400);
        }
        $comprobante->update([
//            'fechapago'=>date('Y-m-d'),
            'usuarioimp'=>$request->user()->codigo,
            'impreso_id'=>$request->user()->id,
            'fechaimpreso'=>date('Y-m-d H:i:s'),
            'estado'=>'IMPRESO',
            'nrocomprobante'=>str_pad($request->nrocomprobante, 6, '0', STR_PAD_LEFT),
            'controlinterno'=>str_pad($request->nrocomprobante, 6, '0', STR_PAD_LEFT).date('d/m/Y'),
//            'nrocomprobante'=>$numcomprobante,
//            'controlinterno'=>$numcomprobante.date('d/m/Y'),
        ]);
//        echo $comprobante;
        return Comprobante::with('cliente')->where('id',$comprobante->id)->with('detalles')->get();
//        return $request->data[1]['coditem'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
