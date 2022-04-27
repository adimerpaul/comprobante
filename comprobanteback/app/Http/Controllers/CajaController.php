<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Comprobante;
use App\Models\Detalle;
use App\Models\User;
use Illuminate\Http\Request;
use Luecano\NumeroALetras\NumeroALetras;

class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::where('unid_id',17)->get();
    }
    public function reportecaja(Request $request){
        return Comprobante::with('cliente')
            ->with('detalles')
            ->with('unid')
            ->whereDate('fecha','>=',$request->fechainicio)
            ->whereDate('fecha','<=',$request->fechafin)
//            ->where('cajero_id',$request->user()->id)
//            ->where('porcaja',true)
            ->whereRaw('(estado = "PAGADO" OR estado = "ANULADO")')
            ->orderBy('nrocomprobante')
            ->get();
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
    public function insertarcorto(Request $request)
    {
        foreach ($request->datos as $row){
            $cliente=Cliente::find(2);
            $formatter = new NumeroALetras();
            $literal= $formatter->toWords($request->total);
            $nrotramite =$request->user()->codigo.(intval(Comprobante::where('user_id',$request->user()->id)->get()->count())+1);
            $comprobante=Comprobante::create([
                'unid_id'=>$request->unid_id,
                'nrotramite'=>$nrotramite,
                'fecha'=>$request->fecha,
                'fechalimite'=>date("Y-m-d",strtotime(now()."+ 36 days")),
                'tipo'=>'VARIOS',
                'codigo'=>'',
                'valorcatastral'=>'',
                'mtsfrte'=>'',
                'placa'=>'',
                'marca'=>'',
                'modelo'=>'',
                'padron'=>'',
                'capital'=>'',
                'varios'=>"",
                'tipopago'=>'EFECTIVO',
                'banco'=>'',
                'banconro'=>'',
                'intere'=>'',
                'multa'=>'',
                'otros'=>'',
                'formulario'=>'',
                'total'=>$row['total'],
                'literal'=>$literal,
                'controlinterno'=>'',
                'estado'=>'CREADO',
                'cajero'=>'',
                'user_id'=>$request->user()->id,
                'cliente_id'=>$cliente->id,
                'item'=>'',
                'ci'=>$cliente->ci,
                'paterno'=>$cliente->paterno,
                'materno'=>$cliente->materno,
                'nombre'=>$cliente->nombre,
            ]);
            $comprobante->update([
                'usuarioimp'=>$request->user()->codigo,
                'impreso_id'=>$request->user()->id,
                'fechaimpreso'=>date('Y-m-d H:i:s'),
                'estado'=>'IMPRESO',
                'nrocomprobante'=>str_pad($row['nrocomprobante'], 6, '0', STR_PAD_LEFT),
                'controlinterno'=>str_pad($row['nrocomprobante'], 6, '0', STR_PAD_LEFT).date('d/m/Y'),
            ]);
            $comprobante->update([
                'fechapago'=>date('Y-m-d H:i:s'),
                'cajero'=>$request->user()->codigo,
                'cajero_id'=>$request->user()->id,
                'estado'=>'PAGADO',
                'porcaja'=>1
            ]);
            if ($row['anulado']){
                $comprobante->paterno='ANULADO';
                $comprobante->materno='ANULADO';
                $comprobante->nombre='ANULADO';
                $comprobante->estado='ANULADO';
                $comprobante->cliente_id=1;
                $comprobante->cajero=$request->user()->codigo;
                $comprobante->cajero_id=$request->user()->id;
                $comprobante->total=0;
                $comprobante->save();
            }
        }

    }

    public function store(Request $request)
    {


//        return $request->data;
        if (count($request->data)==1){
            $item=$request->data[0]['coditem'];
        }else{
            $item=$request->data[1]['coditem'];
        }
//        return $request->user();
        if (Cliente::where('ci',$request->ci)->get()->count()==0 && $request->ci!=''){
            $cliente=Cliente::create([
                'paterno'=>strtoupper($request->paterno==null?'':$request->paterno),
                'ci'=>$request->ci==null?'':$request->ci,
                'materno'=> strtoupper($request->materno==null?'':$request->materno),
                'nombre'=>strtoupper($request->nombre==null?'':$request->nombre),
                'direccion'=>strtoupper($request->direccion==null?'':$request->direccion),
            ]);
//            return $cliente;
        }else{
            $cliente=Cliente::where('ci',$request->ci)->firstOrFail();
            $cliente->nombre=strtoupper($request->nombre==null?'':$request->nombre);
            $cliente->paterno=strtoupper($request->paterno==null?'':$request->paterno);
            $cliente->materno=strtoupper($request->materno==null?'':$request->materno);
            $cliente->direccion=strtoupper($request->direccion==null?'':$request->direccion);
            $cliente->save();
        }
        $cliente=Cliente::where('ci',$request->ci)->firstOrFail();
//        return $cliente;
        $formatter = new NumeroALetras();
        $literal= $formatter->toWords($request->total);
//        return $request->user()->unid_id;
        $nrotramite =$request->user()->codigo.(intval(Comprobante::where('user_id',$request->user()->id)->get()->count())+1);
//        return $nrotramite;
        $comprobante=Comprobante::create([
            'unid_id'=>$request->unid_id,
            'nrotramite'=>$nrotramite,
//            'nrocomprobante'=>'139044',
            'fecha'=>$request->fecha,
            'fechalimite'=>date("Y-m-d",strtotime(now()."+ 36 days")),
            'tipo'=>'VARIOS',
            'codigo'=>'',
            'valorcatastral'=>'',
            'mtsfrte'=>'',
            'placa'=>'',
            'marca'=>'',
            'modelo'=>'',
            'padron'=>$cliente->padron,
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

        foreach ($request->data as $row){
//            echo $row['subtotal'].' -';
            if ($row['coditem']!=null){
                Detalle::create([
                    'coditem'=>$row['coditem'],
                    'nombreitem'=>$row['item'],
//                'codsubitem'=>$row['codsubitem'],
//                'nombresubitem'=>$row['nombresubitem'],
                    'detalle'=>$row['item'],
//                'precio'=>$row['precio'],
//                'cantidad'=>$row['cantidad'],
                    'subtotal'=>$row['monto'],
                    'comprobante_id'=>$comprobante->id,
                ]);
            }
        }
//        $numcomprobante=str_pad($request->nrocomprobante, 6, '0', STR_PAD_LEFT);
//        $count=Comprobante::where('nrocomprobante',$numcomprobante)->where('unid_id',$request->user()->unid_id)->get()->count();
//        if ($count>0){
//            return response()->json(["res"=>'El numero de comprobante ya se encuentra en uso de esa unidad'],400);
//        }
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
        $comprobante->update([
            'fechapago'=>date('Y-m-d H:i:s'),
            'cajero'=>$request->user()->codigo,
            'cajero_id'=>$request->user()->id,
            'estado'=>'PAGADO',
            'porcaja'=>1
        ]);
//        return $request->data[1]['coditem'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($fecha)
    {
        return Comprobante::with('cliente')
            ->with('detalles')
            ->with('unid')
            ->whereDate('fecha',$fecha)
//            ->where('cajero_id',$request->user()->id)
//            ->where('porcaja',true)
            ->whereRaw('(estado = "PAGADO" OR estado = "ANULADO")')
            ->orderBy('nrocomprobante')
            ->get();
    }
    public function  buscarcomprobantesdirecto(Request $request){
//        return $request;
        return Comprobante::
//            with('cliente')
//            ->with('detalles')
//            ->with('unid')
            whereDate('fecha',$request->fecha)
            ->where('unid_id',$request->unid_id)
            ->where('cajero_id',NULL)
//            ->where('cajero_id',$request->user()->id)
//            ->where('porcaja',true)
            ->whereRaw('(estado = "IMPRESO" OR estado = "ANULADO")')
            ->orderBy('nrocomprobante')
            ->get();
    }
    public function cobrarcomprobantedirecto(Request $request){
        foreach ($request->datos as $r){
            if ($r['cobrar']){
                $comprobante=Comprobante::find($r['id']);
                $comprobante->update([
                    'fechapago'=>date('Y-m-d H:i:s'),
                    'cajero'=>$request->user()->codigo,
                    'cajero_id'=>$request->user()->id,
                    'estado'=>'PAGADO',
                    'porcaja'=>1
                ]);
            }
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Comprobante::where('nrocomprobante',$id)->get()->count();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $comprobante_id)
    {
        $comprobante=Comprobante::find($comprobante_id);
        $comprobante->update($request->all());
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
