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
        return Comprobante::with('cliente')->with('detalles')->whereDate('fechalimite','>=',now())->where('unid_id',$request->user()->unid_id)->where('estado','CREADO')->get();
//        return Comprobante::with('cliente')->with('detalles')->get();
    }

    public function buscarimpreso(Request $request)
    {
        return Comprobante::with('cliente')
            ->with('detalles')
            ->whereDate('fechalimite','>=',now())
            ->where('unid_id',$request->user()->unid_id)
            ->where('estado','IMPRESO')
            ->get();
    }

    public function mispagos(Request $request)
    {
//        return Comprobante::all();
        return Comprobante::with('cliente')
            ->with('detalles')
            ->whereDate('fechapago',$request->fecha)
//            ->where('cajero',$request->user()->name)
            ->where('porcaja',false)
            ->where('unid_id',$request->user()->unid_id)
            ->where('estado','PAGADO')
            ->get();
    }

    public function misimpreso(Request $request)
    {
//        return Comprobante::all();
        return Comprobante::with('cliente')
            ->with('detalles')
            ->whereDate('fechaimpreso','>=',$request->inicio)
            ->whereDate('fechaimpreso','<=',$request->fin)
//            ->where('cajero',$request->user()->name)
            ->where('unid_id',$request->user()->unid_id)
            ->where('estado','IMPRESO')
            ->get();
    }

    public function mispagoscaja(Request $request)
    {
//        return Comprobante::all();
        return Comprobante::with('cliente')
            ->with('detalles')
            ->with('unid')
            ->whereDate('fechapago',$request->fecha)
            ->where('cajero',$request->user()->id)
            ->where('porcaja',true)
//            ->where('unid_id',$request->unid_id)
            ->where('estado','PAGADO')
            ->get();
    }

    public function historial(Request $request){
//        return $request;
        return Comprobante::with('cliente')
            ->with('detalles')
            ->whereDate('fechapago',$request->fecha)
//            ->where('cajero',$request->user()->name)
            ->where('unid_id',$request->unid_id)
            ->with('unid')
            ->where('estado','PAGADO')
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

//        return count( $request->data);
        if (count($request->data)==1){
            $item=$request->data[0]['coditem'];
        }else{
            $item=$request->data[1]['coditem'];
        }
//        return $request->user();
        if (Cliente::where('ci',$request->ci)->get()->count()==0 && $request->ci!=''){
            $cliente=Cliente::create([
                'paterno'=>$request->paterno==null?'':$request->paterno,
                'ci'=>$request->ci==null?'':$request->ci,
                'materno'=> strtoupper($request->materno==null?'':$request->materno),
                'nombre'=>strtoupper($request->nombre==null?'':$request->nombre),
                'padron'=>strtoupper($request->padron==null?'':$request->padron),
                'expedido'=>strtoupper($request->expedido==null?'':$request->expedido),
                'direccion'=>strtoupper($request->direccion==null?'':$request->direccion),
                'numcasa'=>strtoupper($request->numcasa==null?'':$request->numcasa),
            ]);
//            return $cliente;
        }else{
            $cliente=Cliente::where('ci',$request->ci)->firstOrFail();
            $cliente->nombre=strtoupper($request->nombre==null?'':$request->nombre);
            $cliente->paterno=strtoupper($request->paterno==null?'':$request->paterno);
            $cliente->materno=strtoupper($request->materno==null?'':$request->materno);
            $cliente->padron=strtoupper($request->padron==null?'':$request->padron);
            $cliente->expedido=strtoupper($request->expedido==null?'':$request->expedido);
            $cliente->direccion=strtoupper($request->direccion==null?'':$request->direccion);
            $cliente->numcasa=strtoupper($request->numcasa==null?'':$request->numcasa);
            $cliente->save();
        }
//        return $cliente;
        $formatter = new NumeroALetras();
        $literal= $formatter->toWords($request->total);
//        return $request->user()->unid_id;
        $comprobante=Comprobante::create([
            'unid_id'=>$request->user()->unid_id,
            'nrotramite'=>$request->nrotramite,
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
            'item'=>$item
        ]);

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
//        return $request->data[1]['coditem'];
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
    public function loscomprobantes(Request $request){
        return Comprobante::with('cliente')
            ->with('detalles')
            ->whereDate('fechalimite','>=',now())
            ->where('unid_id',$request->unid_id)
            ->where('estado','IMPRESO')
            ->get();
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
//            'fechapago'=>date('Y-m-d'),
            'usuarioimp'=>$request->user()->name,
            'impreso_id'=>$request->user()->id,
            'fechaimpreso'=>date('Y-m-d'),
            'estado'=>'IMPRESO',
            'nrocomprobante'=>str_pad($request->nrocomprobante, 6, '0', STR_PAD_LEFT),
            'controlinterno'=>str_pad($request->nrocomprobante, 6, '0', STR_PAD_LEFT).date('d/m/Y'),
        ]);
//        echo $comprobante;
        return Comprobante::with('cliente')->where('id',$comprobante->id)->with('detalles')->get();
    }
    public function pago(Request $request, Comprobante $comprobante)
    {
//         return $comprobante;
        $comprobante->update([
            'fechapago'=>date('Y-m-d'),
            'cajero'=>$request->user()->name,
            'cajero_id'=>$request->user()->id,
            'estado'=>'PAGADO',
//            'nrocomprobante'=>$request->nrocomprobante,
//            'controlinterno'=>$request->nrocomprobante.date('d/m/Y'),
        ]);
        echo $comprobante;
//        return Comprobante::with('cliente')->where('id',$comprobante->id)->with('detalles')->get();
    }
    public function pagocaja(Request $request, Comprobante $comprobante)
    {
//        return 12;
        $comprobante->update([
            'fechapago'=>date('Y-m-d'),
            'cajero'=>$request->user()->name,
            'cajero_id'=>$request->user()->id,
            'estado'=>'PAGADO',
            'porcaja'=>1
        ]);
        echo $comprobante;
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

    public function proforma($id){
        return Comprobante::with('cliente')->with('user')->with('unid')->where('id',$id)->with('detalles')->get();
    }

    public function resumen(Request $request){
        return comprobante::whith('cliente')->where('estado','pagado')->whereDate('fechapago','>=',$request->inicio)
        ->whereDate('fechapago','<=',$request->fin)->where('cajero',$request->cajero);
    }

    public function listcajero(){
        return '';
    }
}
