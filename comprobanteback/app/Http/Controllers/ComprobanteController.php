<?php

namespace App\Http\Controllers;

use App\Models\Anulado;
use App\Models\Cliente;
use App\Models\Comprobante;
use App\Models\Detalle;
use App\Models\User;
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
    public function index(Request $request){
        return Comprobante::with('cliente')
            ->with('detalles')
            ->whereDate('fechalimite','>=',now())
            ->where('unid_id',$request->user()->unid_id)
            ->where('estado','CREADO')
            ->get();
//        return Comprobante::with('cliente')->with('detalles')->get();
    }
    public function ultimoscomprobante(Request $request){
        return Comprobante::where('unid_id',$request->user()->unid_id)
            ->where('nrocomprobante','!=','')
            ->limit(5)
            ->orderBy('nrocomprobante','DESC')
            ->get();
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

    public function mispagos(Request $request){
//        $comprobantes=DB::table('comprobantes')
////            ->join('users as u', 'u.id', '=', 'comprobantes.user_id')
//            ->join('users as c', 'c.id', '=', 'comprobantes.cajero_id')
//            ->join('clientes as cl', 'cl.id', '=', 'comprobantes.cliente_id')
////            ->join('users c', 'c.id', '=', 'comprobantes.cajero_id')
////            ->join('orders', 'users.id', '=', 'orders.user_id')
//            ->whereDate('comprobantes.fechapago',$request->fecha)
//            ->where('comprobantes.porcaja',false)
//            ->where('comprobantes.unid_id',$request->user()->unid_id)
//            ->where('comprobantes.estado','PAGADO')
//            ->select('comprobantes.nrocomprobante',
//                'comprobantes.nrotramite',
//                'comprobantes.total',
//                'cl.nombre',
//                'cl.paterno',
//                'cl.materno',
//                'cl.ci' ,
//                'c.codigo as cajero');
////            ->get();
//
////        $comprobantes=Comprobante::select(DB::raw(" nrocomprobante,user.codigo"))
//////            ->with('cliente')
////            ->join('user', 'users.id', '=', 'comprobantes.user_id')
////
////            //            ->with('detalles')
//////            ->whereDate('fechapago',$request->fecha)
//////            ->where('porcaja',false)
//////            ->where('unid_id',$request->user()->unid_id)
////            ->where('estado','PAGADO')
//////            ->orderBy('nrocomprobante')
////            ->get();
//
//        $anulados=Anulado::select(DB::raw(" nrocomprobante,'ANULADO' as nrotramite,'0' as total,'ANULADO' as paterno,'ANULADO' as materno,'ANULADO' as nombre,'ANULADO' as ci,u.codigo as cajero"))
////        $anulados=DB::table('anulados')
////            ->with('user')
//            ->join('users as u','u.id','=','anulados.user_id')
//            ->where('anulados.unid_id',$request->user()->unid_id)
//            ->whereDate('anulados.fecha',$request->fecha)
//            ->union($comprobantes)
//            ->orderBy('nrocomprobante')
//            ->get();
//
//        return $anulados;


//        $comprobantes=Comprobante::with('cliente')
//            ->with('detalles')
//            ->whereDate('fechapago',$request->fecha)
//            ->where('porcaja',false)
//            ->where('unid_id',$request->user()->unid_id)
//            ->where('estado','PAGADO')
//            ->orderBy('nrocomprobante')
//            ->get();
//        foreach ($comprobantes as $comprobante){
//            $com[]=$comprobante;
//        }
//
//        $anulados=Anulado::with('user')->where('unid_id',$request->user()->unid_id)->whereDate('fecha',$request->fecha)->get();
//        foreach ($anulados as $comprobante){
////            $comprobante['cliente']->paterno='ANULADO';
////            $comprobante['cliente']->materno='ANULADO';
////            $comprobante['cliente']->nombre='ANULADO';
////            $comprobante['cliente']->ci='ANULADO';
////            array_push($comprobante,'a');
////            $com[]=[,'user'=>['codigo'=>$comprobante->user->codigo]];
//            $com[]=[
//                'nrocomprobante'=>$comprobante->nrocomprobante,
//                'nrotramite'=>'ANULADO',
//                'total'=>'0',
//                'cajero'=>$comprobante->user->codigo,
//                'cliente'=>['paterno'=>'ANULADO','materno'=>'ANULADO','nombre'=>'ANULADO','ci'=>'ANULADO'],
//                ];
//        }
//        foreach ($com as $co){
//
//            $c[]=$co;
//
//        }
//
//        return $c;

        return $comprobantes=Comprobante::with('cliente')
            ->with('detalles')
            ->whereDate('fecha',$request->fecha)
//            ->where('porcaja',false)
//            ->where('unid_id',$request->user()->unid_id)
//            ->where('estado','PAGADO')
//            ->orWhere('estado','ANULADO')
            ->whereRaw('(estado = "ANULADO" OR estado = "PAGADO") AND  unid_id="'.$request->user()->unid_id.'"')
            ->orderBy('nrocomprobante')
            ->get();


    }
    public function impresosunidad(Request $request){
        return Comprobante::with('cliente')
            ->with('detalles')
            ->with('cajero')
            ->whereDate('fechaimpreso','>=',$request->inicio)
            ->whereDate('fechaimpreso','<=',$request->fin)
            ->where('unid_id',$request->user()->unid_id)
//            ->where_in
            ->whereRaw('(estado = "PAGADO"  OR estado = "ANULADO")')
            ->orderBy('nrocomprobante')
            //            ->where('estado','PAGADO')
//            ->orWhere('estado','IMPRESO')
//            ->orWhere('estado','ANULADO')
            ->get();
    }

    public function reporteunidad(Request $request){
        return Comprobante::with('cliente')
            ->with('detalles')
            ->with('user')
            ->whereDate('fechaimpreso','>=',$request->inicio)
            ->whereDate('fechaimpreso','<=',$request->fin)
            ->where('unid_id',$request->user()->unid_id)
            ->whereRaw('(estado = "PAGADO"  OR estado = "IMPRESO")')
            ->orderBy('nrocomprobante')
            ->get();
    }

    public function misimpreso(Request $request)
    {
//        return Comprobante::all();
        return Comprobante::with('cliente')
            ->with('detalles')
            ->with('cajero')
            ->whereDate('fechaimpreso','>=',$request->inicio)
            ->whereDate('fechaimpreso','<=',$request->fin)
//            ->where('cajero',$request->user()->name)
            ->where('unid_id',$request->user()->unid_id)
            ->where('cajero_id',$request->user()->id)
            ->where('estado','PAGADO')
            ->orderBy('nrocomprobante')

            ->get();
    }

    public function mispagoscaja(Request $request)
    {
//        return Comprobante::all();
        return Comprobante::with('cliente')
            ->with('detalles')
            ->with('unid')
            ->whereDate('fecha',$request->fecha)
            ->where('cajero_id',$request->user()->id)
//            ->where('porcaja',true)
            ->whereRaw('(estado = "PAGADO" OR estado = "ANULADO")')
            ->orderBy('nrocomprobante')
            ->get();
    }

    public function historial(Request $request){
//        return $request;
        return Comprobante::with('cliente')
            ->with('detalles')
            ->whereDate('fechaimpreso',$request->fecha)
//            ->where('cajero',$request->user()->name)
            ->where('unid_id',$request->unid_id)
            ->with('unid')
//            ->where('estado','PAGADO')
//            ->orWhere('estado','ANULADO')
            ->whereRaw('(estado = "PAGADO" OR estado = "ANULADO")')
            ->get();
    }

    public function historial2(Request $request){
        //        return $request;
                return Comprobante::with('cliente')
                    ->with('detalles')
                    ->whereDate('fechaimpreso',$request->fecha)
        //            ->where('cajero',$request->user()->name)
                    ->where('unid_id',$request->unid_id)
                    ->with('unid')
//                    ->where('estado','PAGADO')
                    ->whereRaw('(estado = "PAGADO" OR estado = "ANULADO")')
                    ->whereNull('fechacaja')
                    ->get();
            }
    public function historial3(Request $request){
        //        return $request;
                return Comprobante::with('cliente')
                    ->with('detalles')
                    ->with('unid')
                    ->whereDate('fecha',$request->fecha)
        //            ->where('cajero',$request->user()->name)
                    //->where('unid_id',$request->unid_id)
//                    ->where('estado','PAGADO')
                    ->whereRaw('(estado = "PAGADO" OR estado = "ANULADO" OR estado = "IMPRESO")')
//                            ->whereNull('fechasistema')
                    ->orderBy('unid_id','ASC')
                    ->orderBy('nrocomprobante','ASC')
                    ->get();
    }
    public function resumenporunidad(Request $request){
        return DB::select("SELECT u.codigo,u.nombre,SUM(c.total) as total
        FROM comprobantes c INNER JOIN unids u ON c.unid_id=u.id
        WHERE date(fecha)='".$request->fecha."'
        AND nrocomprobante!=''
        GROUP BY u.codigo,u.nombre");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        $cliente=Cliente::where('ci',$request->ci)->firstOrFail();
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
            ->with('unid')
            ->whereDate('fechalimite','>=',now())
//            ->where('unid_id',$request->unid_id)
            ->whereRaw('(estado = "ANULADO" OR estado = "IMPRESO")')
//            ->where('estado','IMPRESO')
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
//        if ()
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
    }
    public function pago(Request $request, Comprobante $comprobante)
    {
//         return $comprobante;
        $comprobante->update([
            'fechapago'=>date('Y-m-d H:i:s'),
            'cajero'=>$request->user()->codigo,
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
            'fechapago'=>date('Y-m-d H:i:s'),
            'cajero'=>$request->user()->codigo,
            'cajero_id'=>$request->user()->id,
            'estado'=>'PAGADO',
            'porcaja'=>1
        ]);
        echo $comprobante;
    }

    public function verificadocaja(Request $request)
    {
        $comprobante=Comprobante::find($request->id);
        $comprobante->fechacaja=date('Y-m-d H:i:s');
        $comprobante->verificadocaja=$request->verificadocaja;
        $comprobante->verificadocaja_id=$request->user()->id;
        $comprobante->porcaja=true;
        $comprobante->cajero=$request->user()->codigo;
        $comprobante->cajero_id=$request->user()->id;
        $comprobante->save();
        return true;
    }

    public function verificadosistema(Request $request)
    {
//        return 12;

        $comprobante=Comprobante::find($request->id);
        $comprobante->fechasistema=date('Y-m-d H:i:s');
        $comprobante->verificadosistema=$request->verificadosistema;
        $comprobante->verificadosistema_id=$request->user()->id;
        $comprobante->save();

//        DB::connection('ingres')->table('entradas')->insert([
//            'nro_comp'=>$comprobante->nrocomprobante,
//            'nro_item'=>$comprobante->item,
//            'monto'=>$comprobante->total
//        ]);
//
//        $user1=User::find($comprobante->cajero_id);
//
//        DB::connection('ingres')->table('diario')->insert([
//            'nro_comp'=>$comprobante->nrocomprobante,
//            'fecha'=>date('Y-m-d H:i:s'),
//            'efectivo'=>floatval($comprobante->total),
//            'cheque'=>0,
//            'observ'=>($comprobante->estado=='ANULADO'?$comprobante->estado:''),
//            'oper'=>$user1->codigo
//        ]);
//
//        DB::connection('ingres')->table('compro')->insert([
//            'nro'=>$comprobante->nrocomprobante,
//            'unidad'=>$comprobante->unid_id,
//            'fecha'=>date('Y-m-d H:i:s'),
//            'observa'=>($comprobante->estado=='ANULADO'?$comprobante->estado:''),
//            'flag'=>'T',
//            'caja'=>'T'
//        ]);

        return true;
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

    public function reimprimir(Request $request){
        return comprobante::with('cliente')
            ->where('estado','IMPRESO')
            ->where('fecha',date('Y-m-d'))
            ->where('user_id',$request->user()->id)
            ->get();
    }


    public function convertirletra($total){
        $formatter = new NumeroALetras();

        return  $formatter->toWords(str_replace(',','',$total));
    }

    public function reportitem(Request $request){
        $ini=$request->inicio;
        $fin=$request->fin;
//        $datos= DB::select('SELECT c.fechasistema as fecha,d.codsubitem as cod ,d.nombresubitem as nombre,COUNT(d.codsubitem) as cantidad,d.precio as precio,SUM(d.subtotal) as monto
//        from comprobantes c
//        INNER JOIN detalles d on d.comprobante_id=c.id
//        WHERE c.fechasistema>= "'.$ini.'" and c.fechasistema <= "'.$fin.'"
//        AND c.verificadosistema=1
//        AND c.estado!="ANULADO"
//        GROUP by c.fechasistema,d.codsubitem,d.nombresubitem, d.precio');
        if ($request->unid_id==0){
            $datos=DB::SELECT( "SELECT
d.coditem as cod ,
d.nombreitem as nombre,
COUNT(d.coditem) as cantidad,
SUM(d.subtotal) as monto
        from comprobantes c
        INNER JOIN detalles d on d.comprobante_id=c.id
        WHERE date(c.fecha)>= '$ini' and date(c.fecha) <= '$fin'
        AND c.verificadosistema=1
        AND d.subtotal!=0
        GROUP by d.coditem,d.nombreitem;");
        }else{
            $datos=DB::SELECT( "SELECT
d.coditem as cod ,
d.nombreitem as nombre,
COUNT(d.coditem) as cantidad,
SUM(d.subtotal) as monto
        from comprobantes c
        INNER JOIN detalles d on d.comprobante_id=c.id
        WHERE date(c.fecha)>= '$ini' and date(c.fecha) <= '$fin'
        AND c.verificadosistema=1
        AND c.unid_id='".$request->unid_id."'
        AND d.subtotal!=0
        GROUP by d.coditem,d.nombreitem;");

        }
        return $datos;
    }

    public function reportecomp(Request $request){
        return DB::select('
    SELECT c.fecha ,u.nombre,
    MIN(c.nrocomprobante) as menor,
    MAX(c.nrocomprobante) as mayor
    FROM comprobantes c INNER JOIN unids u on c.unid_id=u.id
    WHERE c.fecha >= "'.$request->inicio.'" and c.fecha<="'.$request->fin.'"
    AND c.verificadosistema =1
    GROUP by c.fecha,u.nombre;
    ');
    }
    public function listramite(){
//        return DB::table('comprobantes')
//            ->whereNull('fechaimpreso')
//            ->whereNull('nrocomprobante')
//            ->orwhere('nrocomprobante','')
//            ->where('user_id',auth()->user()->id)
//            ->get();
        return Comprobante::with('cliente')
            ->with('detalles')
            ->with('unid')
            ->whereNull('fechaimpreso')
            ->whereNull('nrocomprobante')
            ->orwhere('nrocomprobante','')
            ->where('user_id',auth()->user()->id)
            ->get();
    }

    public function modcomp($id){
        return Comprobante::with('cliente')
            ->with('detalles')
            ->with('unid')
            ->where('id',$id)
            ->get();
    }
    public function imprimir(Request $request){
//        return $request;
        return Comprobante::with('cliente')->where('id',$request->id)->with('detalles')->get();
    }

    public function modcomprobante(Request $request)
    {

        //return  $request->data;
        DB::table('detalles')->where('comprobante_id',$request->id)->delete();
        if (count($request->detalles)==1){
            $item=$request->detalles[0]['coditem'];
        }else{
            $item=$request->detalles[1]['coditem'];
        }
        $formatter = new NumeroALetras();
        $literal= $formatter->toWords($request->total);
//        return $request->user()->unid_id;

        $comprobante=Comprobante::find($request->id);
        $comprobante->total=$request->total;
        $comprobante->literal=$literal;
        $comprobante->item=$item;
        $comprobante->save();

        foreach ($request->detalles as $row){
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

    public function buscarcomprobante(Request $request)
    {
        $comprobante = Comprobante::with('cliente')
         ->with('detalles')
         ->where('porcaja',true)
         ->where('estado','PAGADO')
         ->where('unid_id',$request->user()->unid_id);
        if(!is_null($request->ci) || $request->ci!="")
         $comprobante->where('ci','LIKE','%'.$request->ci.'%');
        if(!is_null($request->paterno) || $request->paterno!="")
         $comprobante->where('paterno','LIKE','%'.$request->paterno.'%');
        if(!is_null($request->materno) || $request->materno!="")
         $comprobante->where('materno','LIKE','%'.$request->materno.'%');
        if(!is_null($request->nombre) || $request->nombre!="")
         $comprobante->where('nombre','LIKE','%'.$request->nombre.'%');
        return $comprobante->orderBy('fecha', 'desc')->get();
    }
}
