<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use XBase\TableReader;
use XBase\TableEditor;

class DbfController extends Controller
{
    public function prueba(){
        $fichero_dbf='Y:\INGRES\datos\UNIDADES.DBF';
        $conex = dbase_open($fichero_dbf, 2);

//        if ($conex) {
//            $arrData = array();
//            $total_registros = dbase_numrecords($conex);
//            for ($i = 1; $i <= $total_registros; $i++) {
//                $arrData[] = dbase_get_record($conex, $i);
//            }
//            echo '<pre>', print_r($arrData), '</pre>';
//        } else {
//            echo 'No se pudo acceder al fichero dbf';
//        }

        if ($conex) {
            dbase_add_record($conex, array(
                '23',
                'max@example.com',
                'T'));
            dbase_close($conex);
        }
        $fichero_dbf='Y:\INGRES\datos\UNIDADES.DBF';
        $conex = dbase_open($fichero_dbf, 0);
        if ($conex) {
            $arrData = array();
            $total_registros = dbase_numrecords($conex);
            for ($i = 1; $i <= $total_registros; $i++) {
                $arrData[] = dbase_get_record($conex, $i);
            }
            echo '<pre>', print_r($arrData), '</pre>';
        } else {
            echo 'No se pudo acceder al fichero dbf';
        }



        exit;


//        SIIIIII
        $table = new TableEditor('Y:\INGRES\datos\UNIDADES.DBF',
            [
                'editMode' => TableEditor::EDIT_MODE_CLONE, //default
            ]);

        $r = $table->appendRecord();
        $r->set('unidad', 'te');
        $r->set('descrip', 'test');
        $r->set('talonario', '20');
        $table
            ->writeRecord()
            ->save()
            ->close()
        ;
//        $table = new TableEditor('Y:\INGRES\datos\UNIDADES.DBF',
//            [
//                'editMode' => TableEditor::EDIT_MODE_CLONE, //default
//            ]);
//        $r = $table->appendRecord();
//        $r->set('unidad', 't2');
//        $r->set('descrip', 't2');
//        $r->set('talonario', '20');
//        $table
//            ->writeRecord()
//            ->save()
//            ->close()
//        ;

        $table = new TableEditor('Y:\INGRES\datos\UNIDADES.DBF');//,
//            [
//                'editMode' => TableEditor::EDIT_MODE_CLONE, //default
//            ]);
        while ($record = $table->nextRecord()) {
//            echo $record->get('Unidad');
            //or
            echo $record->descrip.'<br>';
        }
        exit;
//        $fichero_dbf = 'C:\laravel\comprobante\comprobanteback\app\Http\Controllers\UNIDADES.DBF';
//        $fichero_dbf='Y:\INGRES\datos\UNIDADES.DBF';
//        $conex = dbase_open($fichero_dbf, 0);
//
//        if ($conex) {
//            $arrData = array();
//            $total_registros = dbase_numrecords($conex);
//            for ($i = 1; $i <= $total_registros; $i++) {
//                $arrData[] = dbase_get_record($conex, $i);
//            }
//            echo '<pre>', print_r($arrData), '</pre>';
//        } else {
//            echo 'No se pudo acceder al fichero dbf';
//        }

    }
}
