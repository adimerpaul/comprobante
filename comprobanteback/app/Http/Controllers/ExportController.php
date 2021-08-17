<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Comprobante;
use App\Models\Detalle;
use App\Models\User;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function readCSV($csvFile, $array)
//    {
//        $file_handle = fopen($csvFile, 'r');
//        $i=0;
//        while (!feof($file_handle)) {
//            if ($i==0){
//                $line_of_text[] = fgetcsv($file_handle, 0, $array['delimiter']);
//            }
//            $i++;
//        }
//        fclose($file_handle);
//        return $line_of_text;
//    }

    public function subir(Request  $request){

//        header('Access-Control-Allow-Origin:*');
//        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
//        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
//        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
//        $method = $_SERVER['REQUEST_METHOD'];
//        if($method == "OPTIONS") {
//            die();
//        }

        if ($request->hasFile('file')) {
//            return  "si";

            $path = $request->file('file')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            $i=0;
            $nrocomprobanteant='*';
            $boolduplicado=false;
            foreach ($data as $row){
                if ($i!=0){
                    $nrotramite=$row[0];
                    $nrocomprobante=$row[1];
                    $fecha=$row[2];
                    $fechalimite=$row[3];
                    $fechapago=$row[4];
                    $fechaimpreso=$row[5];
                    $tipo=$row[6];
                    $item=$row[7];
                    $padron=$row[8];
                    $varios=$row[9];
                    $total=$row[10];
                    $literal=$row[11];
                    $controlinterno=$row[12];
                    $estado=$row[13];
                    $cajero=$row[14];
                    $usuarioimp=$row[15];
                    $porcaja=$row[16];
                    $uname=$row[17];
                    $ucodigo=$row[18];
                    $uemail=$row[19];
                    $cname=$row[20];
                    $ccodigo=$row[21];
                    $cemail=$row[22];
                    $iname=$row[23];
                    $icodigo=$row[24];
                    $iemail=$row[25];
                    $cci=$row[26];
                    $cexpedido=$row[27];
                    $cpaterno=$row[28];
                    $cmaterno=$row[29];
                    $cpadron=$row[30];
                    $cnombre=$row[31];
                    $cdireccion=$row[32];
                    $cnumcasa=$row[33];
                    $ctelefono=$row[34];
                    $unid_id=$row[35];
                    $coditem=$row[36];
                    $nombreitem=$row[37];
                    $codsubitem=$row[38];
                    $nombresubitem=$row[39];
                    $detalle=$row[40];
                    $precio=$row[41];
                    $cantidad=$row[42];
                    $subtotal=$row[43];

                    $vcomprobante=Comprobante::where('nrotramite',$nrotramite)->where('unid_id',$unid_id)->get();
                    if ($vcomprobante->count()>0 && $boolduplicado==false){
                        return response()->json(['res'=>'Los archivos ya fueron importados'],400);

                    }else{
                        $boolduplicado=true;
                    }

                    $cliente=Cliente::where('ci',$cci)->get();
                    if ($cliente->count()==0){
                        $c=new Cliente();
                        $c->ci=$cci;
                        $c->expedido=$cexpedido;
                        $c->paterno=$cpaterno;
                        $c->materno=$cmaterno;
                        $c->padron=$cpadron;
                        $c->nombre=$cnombre;
                        $c->direccion=$cdireccion;
                        $c->numcasa=$cnumcasa;
                        $c->telefono=$ctelefono;
                        $c->save();
                        $cliente_id=$c->id;
                    }else{
                        $c=Cliente::find($cliente[0]->id);
                        $c->expedido=$cexpedido;
                        $c->paterno=$cpaterno;
                        $c->materno=$cmaterno;
                        $c->padron=$cpadron;
                        $c->nombre=$cnombre;
                        $c->direccion=$cdireccion;
                        $c->numcasa=$cnumcasa;
                        $c->telefono=$ctelefono;
                        $c->save();
                        $cliente_id=$c->id;
                    }

                    $usuario=User::where('email',$uemail)->get();
                    if ($usuario->count()==0){
                        $c=new User();
                        $c->name=$uname;
                        $c->codigo=$ucodigo;
                        $c->email=$uemail;
                        $c->unid_id=$unid_id;
                        $c->password='';
                        $c->save();
                        $user_id=$c->id;
                    }else{
                        $c=User::find($usuario[0]->id);
                        $user_id=$c->id;
                    }

                    $usuario=User::where('email',$cemail)->get();
                    if ($usuario->count()==0){
                        $c=new User();
                        $c->name=$cname;
                        $c->codigo=$ccodigo;
                        $c->email=$cemail;
                        $c->unid_id=$unid_id;
                        $c->password='';
                        $c->save();
                        $cajero_id=$c->id;
                    }else{
                        $c=User::find($usuario[0]->id);
                        $cajero_id=$c->id;
                    }

                    $usuario=User::where('email',$iemail)->get();
                    if ($usuario->count()==0){
                        $c=new User();
                        $c->name=$iname;
                        $c->codigo=$icodigo;
                        $c->email=$iemail;
                        $c->unid_id=$unid_id;
                        $c->password='';
                        $c->save();
                        $impreso_id=$c->id;
                    }else{
                        $c=User::find($usuario[0]->id);
                        $impreso_id=$c->id;
                    }
//                    return $user_id;
                    if ($nrocomprobanteant!=$nrocomprobante){
//                        echo $nrocomprobante.'-';
                        $nrocomprobanteant=$nrocomprobante;
                        $com=new Comprobante();
                        $com->nrotramite=$nrotramite;
                        $com->nrocomprobante=$nrocomprobante;
                        $com->fecha=$fecha;
                        $com->fechalimite=$fechalimite;
                        $com->fechapago=$fechapago==''?NULL:$fechapago;
                        $com->fechaimpreso=$fechaimpreso;
                        $com->tipo=$tipo;
                        $com->item=$item;
                        $com->padron=$padron;
                        $com->varios=$varios;
                        $com->total=$total;
                        $com->literal=$literal;
                        $com->controlinterno=$controlinterno;
                        $com->estado=$estado;
                        $com->cajero=$cajero;
                        $com->usuarioimp=$usuarioimp;
                        $com->porcaja=$porcaja;
                        $com->user_id=$user_id;
                        $com->unid_id=$unid_id;
                        $com->cajero_id=$cajero_id;
                        $com->impreso_id=$impreso_id;
                        $com->cliente_id=$cliente_id;

                        $com->save();
                        $comprobante_id=$com->id;

                        $de=new Detalle();
                        $de->coditem=$coditem;
                        $de->nombreitem=$nombreitem;
                        $de->codsubitem=$codsubitem;
                        $de->nombresubitem=$nombresubitem;
                        $de->detalle=$detalle;
                        $de->precio=$precio;
                        $de->cantidad=$cantidad;
                        $de->subtotal=$subtotal;
                        $de->comprobante_id=$comprobante_id;
                        $de->save();
                    }else{
                        $de=new Detalle();
                        $de->coditem=$coditem;
                        $de->nombreitem=$nombreitem;
                        $de->codsubitem=$codsubitem;
                        $de->nombresubitem=$nombresubitem;
                        $de->detalle=$detalle;
                        $de->precio=$precio;
                        $de->cantidad=$cantidad;
                        $de->subtotal=$subtotal;
                        $de->comprobante_id=$comprobante_id;
                        $de->save();
                    }

                }
                $i++;
            }
//            var_dump($data);
//            $nombreArchivo = time() . "." . $request->file->getClientOriginalExtension();
//            $request->file->move(\public_path('csv'), $nombreArchivo);
////            $csvFile = public_path('csv/' . $nombreArchivo);
////            var_dump($this->readCSV($csvFile,array('delimiter' => ',')));
//            return 10;
//            var_dump(['res'=>'respuesta','res2'=>'respuesta']);
//            return 1;
//            $data = [];
//            if (($handle = fopen("csv/".$nombreArchivo, "r")) !== FALSE) {
//                $i = 0; // Define a counter that tells us which row we're looking at
//                while (($row = fgetcsv($handle, 9999, ",")) !== FALSE) {
//                    // Only capture rows that are greater than 0, i.e. we skip the first row (Headers)
//                    if ($i > 0) {
//                        $data[] = $row;
////                        var_dump($row);
////                        echo $row[0];
//                    }
//                    $i++;
//                }
//                fclose($handle);
//            }

//            var_dump($data);
//            echo  "1asdsdasd";
//            var_dump(new array(['a']));
        }else{
//            return  "no";
            return response()->json(['res'=>'No llego el archivo para su insersion'],400);
        }
//        $csvFileName = "file.csv";
//        $csvFile = public_path('csv/' . $csvFileName);
//        $this->readCSV($csvFile,array('delimiter' => ','));
    }
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
        return Comprobante::with('cliente')
            ->with('detalles')
            ->join('detalles', 'comprobantes.id', '=', 'detalles.comprobante_id')
            ->with('user')
            ->with('cajero')
            ->with('impreso')
            ->whereDate('fechaimpreso',$request->fecha)
//            ->whereRaw('(  date(fechapago) = date("'.$request->fecha.'") OR fechapago = null")')
            //            ->where('cajero',$request->user()->name)
            ->where('unid_id',$request->user()->unid_id)
            ->with('unid')
//            ->where('estado','PAGADO')
//            ->orWhere('estado','ANULADO')
            ->whereRaw('(estado = "ANULADO" OR estado = "PAGADO")')
            ->orderBy('nrocomprobante')
            ->get();

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
