<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Comprobante;
use App\Models\Detalle;
use App\Models\Unid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Luecano\NumeroALetras\NumeroALetras;

class MercadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Comprobante::with('cliente')
            ->with('detalles')
            ->with('user')
            ->whereDate('fechalimite','>=',now())
            ->where('user_id',$request->user()->id)
            ->whereDate('fecha',now())
            ->orderBy('id')
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return Unid::find($request->user()->unid_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return DB::select("SELECT fecha,COUNT(*) as num,SUM(total) as total FROM comprobantes WHERE nrocomprobante!='' AND  unid_id='".$request->user()->unid_id."' AND fecha >= '".$request->fecha1."' AND fecha <= '".$request->fecha2."' GROUP BY fecha");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($fecha,Request $request)
    {
        return Comprobante::with('cliente')
            ->with('detalles')
            ->with('user')
//            ->whereDate('fechalimite','>=',now())
            ->where('unid_id',$request->user()->unid_id)
            ->whereDate('fecha',$fecha)
            ->orderBy('nrocomprobante')
            ->get();
    }
    public function reportemes(Request $request){
        return Comprobante::with('cliente')
            ->with('detalles')
            ->with('user')
//            ->whereDate('fechalimite','>=',now())
            ->where('unid_id',$request->user()->unid_id)
            //->where('temporada','TODOS SANTOS')
            ->whereDate('fecha','>=',$request->inicio)
            ->whereDate('fecha','<=',$request->fin)
            ->orderBy('nrocomprobante')
            ->get();
    }
    public function reportemestemporada(Request $request){
        return Comprobante::with('cliente')
            ->with('detalles')
            ->with('user')
//            ->whereDate('fechalimite','>=',now())
            ->where('unid_id',$request->user()->unid_id)
            ->where('temporada',$request->temporada['nombre'])
            ->orderBy('nrocomprobante')
            ->get();
    }
    public function comprobanteusuario($fecha,Request $request)
    {
        return Comprobante::with('cliente')
            ->with('detalles')
            ->with('user')
//            ->whereDate('fechalimite','>=',now())
            ->where('unid_id',$request->user()->unid_id)
            ->where('user_id',$request->user()->id)
            ->whereDate('fecha',$fecha)
            ->orderBy('nrocomprobante')
            ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        return Comprobante::with('cliente')
            ->with('detalles')
            ->with('user')
            ->whereDate('fechalimite','>=',now())
            ->where('user_id',$request->user()->id)
            ->whereDate('fecha',now())
            ->orderBy('id','desc')
            ->get();
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
        //        return $request->data;
        if (count($request->data)==1){
            $item=$request->data[0]['coditem'];
        }else{
            $item=$request->data[1]['coditem'];
        }
        if (Cliente::where('ci',$request->ci)->get()->count()==0 && $request->ci!=''){
            $cliente=Cliente::create([
                'paterno'=>strtoupper($request->paterno==null?'':$request->paterno),
                'ci'=>$request->ci==null?'':$request->ci,
                'materno'=> strtoupper($request->materno==null?'':$request->materno),
                'nombre'=>strtoupper($request->nombre==null?'':$request->nombre),
                'padron'=>strtoupper($request->padron==null?'':$request->padron),
                'expedido'=>strtoupper($request->expedido==null?'':$request->expedido),
                'direccion'=>strtoupper($request->direccion==null?'':$request->direccion),
                'numcasa'=>strtoupper($request->numcasa==null?'':$request->numcasa),
            ]);
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
        $cliente=Cliente::where('ci',$request->ci)->firstOrFail();
        $formatter = new NumeroALetras();
        $literal= $formatter->toWords($request->total);
//        return $request->user()->unid_id;
        Comprobante::where('id',$request->comprobante_id)->update([
            'unid_id'=>$request->user()->unid_id,
//            'nrotramite'=>$request->nrotramite,
//            'nrocomprobante'=>'139044',
            'fecha'=>date('Y-m-d'),
            'fechalimite'=>date("Y-m-d",strtotime(now()."+ 21 days")),
//            'tipo'=>'VARIOS',
//            'codigo'=>'',
//            'valorcatastral'=>'',
//            'mtsfrte'=>'',
//            'placa'=>'',
//            'marca'=>'',
//            'modelo'=>'',
            'padron'=>$cliente->padron,
//            'capital'=>'',
//            'varios'=>"",
//            'tipopago'=>'EFECTIVO',
//            'banco'=>'',
//            'banconro'=>'',
//            'intere'=>'',
//            'multa'=>'',
//            'otros'=>'',
//            'formulario'=>'',
            'total'=>$request->total,
            'literal'=>$literal,
//            'controlinterno'=>'',
//            'estado'=>'CREADO',
//            'cajero'=>'',
            'user_id'=>$request->user()->id,
            'cliente_id'=>$cliente->id,
            'item'=>$item,
            'ci'=>$cliente->ci,
            'paterno'=>$cliente->paterno,
            'materno'=>$cliente->materno,
            'nombre'=>$cliente->nombre,
        ]);
        $comprobante=Comprobante::where('id',$request->comprobante_id)->firstOrFail();
        DB::select("DELETE FROM detalles where comprobante_id='".$comprobante->id."'");
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
//        return $request->data[1]['coditem'];
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
