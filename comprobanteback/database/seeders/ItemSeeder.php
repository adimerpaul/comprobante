<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
//            [
//                'codigo'=>"1220007",
//                'nombre'=>"VENTA Y REPOCICION",
//                'detalle'=>"",
//                'monto'=>"2",
//                'unid_id'=>"1",
//            ],
//            [
//                'codigo'=>"1510015",
//                'nombre'=>"DERECHOS VARIOS",
//                'detalle'=>"",
//                'monto'=>"25",
//                'unid_id'=>"2",
//            ],
['codigo'=>'1210000','nombre'=>'VENTA Y REPOSICIÓN                              '],
['codigo'=>'1210001','nombre'=>'VENTA DE TERRENOS BALDIOS                              '],
['codigo'=>'1210002','nombre'=>'VENTA DE TERRENOS CEMENTERIO                           '],
['codigo'=>'1210003','nombre'=>'VENTA DE OTROS BIENES                                  '],
['codigo'=>'1220001','nombre'=>'VENTA DE ENTRADAS AL MUSEO                             '],
['codigo'=>'1220002','nombre'=>'VENTA DE ENTRADAS AL ZOOLOGICO                         '],
['codigo'=>'1220003','nombre'=>'VENTA DE METROS LINEALES, ASIENTOS CARNAVAL            '],
['codigo'=>'1220004','nombre'=>'VENTA DE ENTRADAS AL PARQUE ECOLOGICO                  '],
['codigo'=>'1220005','nombre'=>'VENTA DE OTROS SERVICIOS                               '],
['codigo'=>'1220006','nombre'=>'VENTA DE ENTRADAS AL PARQUE INTI RAYMI                 '],
['codigo'=>'1220007','nombre'=>'VENTA DE REPOSICION DE FORMULARIOS Y COMPROBANTES      '],//10
['codigo'=>'1339001','nombre'=>'IMPUESTO A LA ELABORACION DE CHICHA                    '],
['codigo'=>'1510005','nombre'=>'CONEXION DE CABLES, TERRESTRES: FIBRA OPTICA Y OTROS   '],
['codigo'=>'1510006','nombre'=>'APROBACION DE PLANOS                                   '],
['codigo'=>'1510008','nombre'=>'APROBACION DE URBANIZACIONES                           '],
['codigo'=>'1510009','nombre'=>'APROBACION LINEA NIVEL                                 '],
['codigo'=>'1510010','nombre'=>'POR CONEXION DE ALCANTARILLADO, CHICOLLOS, ACOMETIDAS  '],
['codigo'=>'1510011','nombre'=>'DERECHO CONCESION DE PUESTOS EVENTUALES                '],
['codigo'=>'1510012','nombre'=>'DERECHO INSTALACION CASETAS                            '],
['codigo'=>'1510013','nombre'=>'CAMBIO DE NOMBRE DE PUESTOS                            '],
['codigo'=>'1510014','nombre'=>'CERTIFICACION DE TRAMITES                              '],//20
['codigo'=>'1510015','nombre'=>'DERECHOS VARIOS                                        '],
['codigo'=>'1510017','nombre'=>'REGISTRO DE INMUEBLES                                  '],
['codigo'=>'1510018','nombre'=>'REGISTRO ACTIVIDAD ECONOMICA                           '],
['codigo'=>'1510019','nombre'=>'VENTA DE VALORES (FICHA INSPECCION, DEFENSA CONSUMIDOR)'],
['codigo'=>'1510020','nombre'=>'TRAFICO Y ESTACIONAMIENTO DE VEHICULOS                 '],
['codigo'=>'1510021','nombre'=>'SANCIONES E INFRACCIONES VARIOS                        '],
['codigo'=>'1510022','nombre'=>'REPOSICION DE PAVIMENTO                                '],
['codigo'=>'1510023','nombre'=>'OTROS NO ESPECIFICADOS                                 '],
['codigo'=>'1534006','nombre'=>'PATENTE A LOS SERVICIOS EN GENERAL                     '],
['codigo'=>'1534007','nombre'=>'PATENTE AL COMERCIO EN GENERAL                         '],//30
['codigo'=>'1534008','nombre'=>'PATENTE AL COMERCIO MINORISTA (SENTAJE-SITIAJES)       '],
['codigo'=>'1534009','nombre'=>'PATENTE A LOS ESPECTACULOS Y RECREACIONES              '],
['codigo'=>'1534010','nombre'=>'PATENTE NO CONTEMPLADOS                                '],
['codigo'=>'1534011','nombre'=>'PATENTE POR TEMPORADAS A61                             '],
['codigo'=>'1591001','nombre'=>'SERVICIOS TECNICOS (CONSTRUCCIONES CLANDESTINAS)       '],
['codigo'=>'1591002','nombre'=>'INFRACCIONES MERCADOS                                  '],
['codigo'=>'1591003','nombre'=>'OTROS                                                  '],
['codigo'=>'1592001','nombre'=>'INTERESES PENALES VARIOS                               '],
['codigo'=>'1630001','nombre'=>'ALQUILER DE NICHOS                                     '],
['codigo'=>'1630002','nombre'=>'VENTA DE HORNACINAS                                    '],
['codigo'=>'1630003','nombre'=>'RENOVACION DE NICHOS                                   '],
['codigo'=>'1630004','nombre'=>'CONSERVACION HORNACINAS Y MAUSOLEOS                    '],
['codigo'=>'1630005','nombre'=>'ALQUILER DE MINGITORIOS                                '],
['codigo'=>'1630006','nombre'=>'ALQUILER DE TIENDAS Y KIOSCOS                          '],
['codigo'=>'1630007','nombre'=>'ALQUILER BALNEARIO CAPACHOS                            '],
['codigo'=>'1630008','nombre'=>'ALQUILER TEATROS AL AIRE LIBRE                         '],
['codigo'=>'1630009','nombre'=>'OTROS ALQUILERES (DEVENGADOS, MATADERO)                '],
['codigo'=>'1510007','nombre'=>'LEGALIZACION DE PLANOS                                 '],
['codigo'=>'1210001','nombre'=>'VENTA DE TERRENOS BALDIOS                              '],
['codigo'=>'1220008','nombre'=>'VENTA DE ENTRADAS BALNEARIO CAPACHOS                   '],//50
['codigo'=>'1220009','nombre'=>'VENTA DE ENTRADAS MON. ESC. VIRGEN DEL SOCAVON         '],
['codigo'=>'1510024','nombre'=>'TASAS POR RESONANCIA MAGNÉTICA                         '],
['codigo'=>'1510025','nombre'=>'TASAS POR TOMOGRAFÍA AXIAL COMPUTARIZADA (TAC)         '],
['codigo'=>'1510026','nombre'=>'TASAS POR RAYOZ X                                      '],
['codigo'=>'1510027','nombre'=>'TASAS POR ECOGRAFÍA                                    '],
['codigo'=>'1510028','nombre'=>'TASAS POR SERVICIO DE ESTACIONAMIENTO VEHICULAR        '],
['codigo'=>'1630010','nombre'=>'ALQUILER DE CAMPOS DEPORTIVOS                          '],
['codigo'=>'1630011','nombre'=>'ALQUILER SALON LUIS RAMIRO BELTRAN                     '],
['codigo'=>'1630012','nombre'=>'ALQUILER MAQUINARIA PESADA                             '],

        ]);
    }
}
