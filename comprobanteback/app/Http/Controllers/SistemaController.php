<?php

namespace App\Http\Controllers;

use App\Models\Comprobante;
use App\Models\Detalle;
use Illuminate\Http\Request;

class SistemaController extends Controller
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
//        return $request->datos;
        foreach ($request->datos  as $c){
//            echo $c['id'];
            $comprobante=Comprobante::find($c['id']);
            $comprobante->fechasistema=date('Y-m-d H:i:s');
            $comprobante->verificadosistema=$c['verificadosistema'];
            $comprobante->verificadosistema_id=$request->user()->id;
            $comprobante->save();
        }
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
        $comprobante=Comprobante::find($id);
        $comprobante->verificadosistema=$request->verificadosistema;
        $comprobante->fechasistema=date('Y-m-d');
        $comprobante->verificadosistema_id=$request->user()->id;
        $comprobante->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comprobante=Comprobante::find($id);
        $comprobante->delete();
    }
    public function modificarcomprobantesistemas(Request $request,$comprobante_id){
        $comprobante=Comprobante::find($comprobante_id);
        $comprobante->fecha=$request->fecha;
        $comprobante->unid_id=$request->unid_id;
        $comprobante->nrocomprobante=$request->nrocomprobante;
        $comprobante->update();
//        return $request->detalles;
        Detalle::where('comprobante_id',$comprobante->id)->delete();
        foreach ($request->detalles as $row){
            if ($row['coditem']!=null ){
                $detalle=new Detalle();
                $detalle->coditem=$row['coditem'];
                $detalle->nombreitem=$row['item'];
                $detalle->codsubitem='';
                $detalle->nombresubitem='';
                $detalle->detalle='';
                $detalle->precio=$row['monto'];
                $detalle->cantidad=1;
                $detalle->subtotal=$row['monto'];
                $detalle->comprobante_id=$comprobante->id;
                $detalle->save();
            }
        }
    }
}
