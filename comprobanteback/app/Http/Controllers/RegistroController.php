<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Registro;
use Illuminate\Http\Request;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
//        return $request;
        return Registro::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function show($temporada)
    {

        return Registro::with('cliente')
            ->with('rubro')
            ->where("temporada",$temporada)
            ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function edit(Registro $registro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registro $registro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registro $registro)
    {
        //
    }

    public function registro(Request $request)
    {
        // return $request;
        // $idsCliente =
        return Cliente::where('ci','like','%'.$request->val.'%')
                ->orWhere("paterno",'like','%'.$request->val.'%')
                ->orWhere("materno",'like','%'.$request->val.'%')
                ->orWhere("nombre",'like','%'.$request->val.'%')
                ->skip(0)->take(20)->get();


        // return Registro::
        //     where("temporada",$request->temporada)
        //     ->whereIn("cliente_id",$idsCliente)
        //     ->with('cliente')
        //     ->with('rubro')
        //     ->skip(0)->take(20)->get();
    }
}
