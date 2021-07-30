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
["unid_id"=>16,"id"=>1,'codigo'=>'1210000','nombre'=>'VENTA Y REPOSICIÓN                              '],
["unid_id"=>16,"id"=>2,'codigo'=>'1210001','nombre'=>'VENTA DE TERRENOS BALDIOS                              '],
["unid_id"=>16,"id"=>3,'codigo'=>'1210002','nombre'=>'VENTA DE TERRENOS CEMENTERIO                           '],
["unid_id"=>16,"id"=>4,'codigo'=>'1210003','nombre'=>'VENTA DE OTROS BIENES                                  '],
["unid_id"=>16,"id"=>5,'codigo'=>'1220001','nombre'=>'VENTA DE ENTRADAS AL MUSEO                             '],
["unid_id"=>16,"id"=>6,'codigo'=>'1220002','nombre'=>'VENTA DE ENTRADAS AL ZOOLOGICO                         '],
["unid_id"=>16,"id"=>7,'codigo'=>'1220003','nombre'=>'VENTA DE METROS LINEALES, ASIENTOS CARNAVAL            '],
["unid_id"=>16,"id"=>8,'codigo'=>'1220004','nombre'=>'VENTA DE ENTRADAS AL PARQUE ECOLOGICO                  '],
["unid_id"=>16,"id"=>9,'codigo'=>'1220005','nombre'=>'VENTA DE OTROS SERVICIOS                               '],
["unid_id"=>16,"id"=>10,'codigo'=>'1220006','nombre'=>'VENTA DE ENTRADAS AL PARQUE INTI RAYMI                 '],
["unid_id"=>16,"id"=>11,'codigo'=>'1220007','nombre'=>'VENTA DE REPOSICION DE FORMULARIOS Y COMPROBANTES      '],//10
["unid_id"=>16,"id"=>12,'codigo'=>'1339001','nombre'=>'IMPUESTO A LA ELABORACION DE CHICHA                    '],
["unid_id"=>16,"id"=>13,'codigo'=>'1510005','nombre'=>'CONEXION DE CABLES, TERRESTRES: FIBRA OPTICA Y OTROS   '],
["unid_id"=>16,"id"=>14,'codigo'=>'1510006','nombre'=>'APROBACION DE PLANOS                                   '],
["unid_id"=>16,"id"=>15,'codigo'=>'1510008','nombre'=>'APROBACION DE URBANIZACIONES                           '],
["unid_id"=>16,"id"=>16,'codigo'=>'1510009','nombre'=>'APROBACION LINEA NIVEL                                 '],
["unid_id"=>16,"id"=>17,'codigo'=>'1510010','nombre'=>'POR CONEXION DE ALCANTARILLADO, CHICOLLOS, ACOMETIDAS  '],
["unid_id"=>3,"id"=>18,'codigo'=>'1510011','nombre'=>'DERECHO CONCESION DE PUESTOS EVENTUALES                '],
["unid_id"=>3,"id"=>19,'codigo'=>'1510012','nombre'=>'DERECHO INSTALACION CASETAS                            '],
["unid_id"=>3,"id"=>20,'codigo'=>'1510013','nombre'=>'CAMBIO DE NOMBRE DE PUESTOS                            '],
["unid_id"=>3,"id"=>21,'codigo'=>'1510014','nombre'=>'CERTIFICACION DE TRAMITES                              '],//20
["unid_id"=>3,"id"=>22,'codigo'=>'1510015','nombre'=>'DERECHOS VARIOS                                        '],
["unid_id"=>16,"id"=>23,'codigo'=>'1510017','nombre'=>'REGISTRO DE INMUEBLES                                  '],
["unid_id"=>16,"id"=>24,'codigo'=>'1510018','nombre'=>'REGISTRO ACTIVIDAD ECONOMICA                           '],
["unid_id"=>16,"id"=>25,'codigo'=>'1510019','nombre'=>'VENTA DE VALORES (FICHA INSPECCION, DEFENSA CONSUMIDOR)'],
["unid_id"=>16,"id"=>26,'codigo'=>'1510020','nmbre'=>'TRAFICO Y ESTACIONAMIENTO DE VEHICULOS                 '],
["unid_id"=>3,"id"=>27,'codigo'=>'1510021','nombre'=>'SANCIONES E INFRACCIONES VARIOS                        '],
["unid_id"=>16,"id"=>28,'codigo'=>'1510022','nombre'=>'REPOSICION DE PAVIMENTO                                '],
["unid_id"=>3,"id"=>29,'codigo'=>'1510023','nombre'=>'OTROS NO ESPECIFICADOS                                 '],
["unid_id"=>16,"id"=>30,'codigo'=>'1534006','nombre'=>'PATENTE A LOS SERVICIOS EN GENERAL                     '],
["unid_id"=>16,"id"=>31,'codigo'=>'1534007','nombre'=>'PATENTE AL COMERCIO EN GENERAL                         '],//30
["unid_id"=>3,"id"=>32,'codigo'=>'1534008','nombre'=>'PATENTE AL COMERCIO MINORISTA (SENTAJE-SITIAJES)       '],
["unid_id"=>16,"id"=>33,'codigo'=>'1534009','nombre'=>'PATENTE A LOS ESPECTACULOS Y RECREACIONES              '],
["unid_id"=>16,"id"=>34,'codigo'=>'1534010','nombre'=>'PATENTE NO CONTEMPLADOS                                '],
["unid_id"=>3,"id"=>35,'codigo'=>'1534011','nombre'=>'PATENTE POR TEMPORADAS A61                             '],
["unid_id"=>16,"id"=>36,'codigo'=>'1591001','nombre'=>'SERVICIOS TECNICOS (CONSTRUCCIONES CLANDESTINAS)       '],
["unid_id"=>3,"id"=>37,'codigo'=>'1591002','nombre'=>'INFRACCIONES MERCADOS                                  '],
["unid_id"=>3,"id"=>38,'codigo'=>'1591003','nombre'=>'OTROS                                                  '],
["unid_id"=>16,"id"=>39,'codigo'=>'1592001','nombre'=>'INTERESES PENALES VARIOS                               '],
["unid_id"=>16,"id"=>40,'codigo'=>'1630001','nombre'=>'ALQUILER DE NICHOS                                     '],
["unid_id"=>16,"id"=>41,'codigo'=>'1630002','nombre'=>'VENTA DE HORNACINAS                                    '],
["unid_id"=>16,"id"=>42,'codigo'=>'1630003','nombre'=>'RENOVACION DE NICHOS                                   '],
["unid_id"=>16,"id"=>43,'codigo'=>'1630004','nombre'=>'CONSERVACION HORNACINAS Y MAUSOLEOS                    '],
["unid_id"=>16,"id"=>44,'codigo'=>'1630005','nombre'=>'ALQUILER DE MINGITORIOS                                '],
["unid_id"=>16,"id"=>45,'codigo'=>'1630006','nombre'=>'ALQUILER DE TIENDAS Y KIOSCOS                          '],
["unid_id"=>16,"id"=>46,'codigo'=>'1630007','nombre'=>'ALQUILER BALNEARIO CAPACHOS                            '],
["unid_id"=>16,"id"=>47,'codigo'=>'1630008','nombre'=>'ALQUILER TEATROS AL AIRE LIBRE                         '],
["unid_id"=>16,"id"=>48,'codigo'=>'1630009','nombre'=>'OTROS ALQUILERES (DEVENGADOS, MATADERO)                '],
["unid_id"=>16,"id"=>49,'codigo'=>'1510007','nombre'=>'LEGALIZACION DE PLANOS                                 '],
["unid_id"=>16,"id"=>51,'codigo'=>'1220008','nombre'=>'VENTA DE ENTRADAS BALNEARIO CAPACHOS                   '],//50
["unid_id"=>16,"id"=>52,'codigo'=>'1220009','nombre'=>'VENTA DE ENTRADAS MON. ESC. VIRGEN DEL SOCAVON         '],
["unid_id"=>16,"id"=>53,'codigo'=>'1510024','nombre'=>'TASAS POR RESONANCIA MAGNÉTICA                         '],
["unid_id"=>16,"id"=>54,'codigo'=>'1510025','nombre'=>'TASAS POR TOMOGRAFÍA AXIAL COMPUTARIZADA (TAC)         '],
["unid_id"=>16,"id"=>55,'codigo'=>'1510026','nombre'=>'TASAS POR RAYOZ X                                      '],
["unid_id"=>16,"id"=>56,'codigo'=>'1510027','nombre'=>'TASAS POR ECOGRAFÍA                                    '],
["unid_id"=>16,"id"=>57,'codigo'=>'1510028','nombre'=>'TASAS POR SERVICIO DE ESTACIONAMIENTO VEHICULAR        '],
["unid_id"=>16,"id"=>58,'codigo'=>'1630010','nombre'=>'ALQUILER DE CAMPOS DEPORTIVOS                          '],
["unid_id"=>16,"id"=>59,'codigo'=>'1630011','nombre'=>'ALQUILER SALON LUIS RAMIRO BELTRAN                     '],
["unid_id"=>16,"id"=>60,'codigo'=>'1630012','nombre'=>'ALQUILER MAQUINARIA PESADA                             '],
["unid_id"=>16,"id"=>61,'codigo'=>'1339000','nombre'=>'OTROS (USO DE SUELO COTEOR SELA ELFEO)'],
["unid_id"=>16,"id"=>62,'codigo'=>'1510001','nombre'=>'TASA ALCANTARILLADO SANITARIO   '],
["unid_id"=>16,"id"=>63,'codigo'=>'1510002','nombre'=>'ALUMBRADO PUBLICO (TASA ADICIONAL ELFEO)'],
["unid_id"=>16,"id"=>64,'codigo'=>'1510003','nombre'=>'ALUMBRADO PUBLICO (GESTIONES ANTERIORES)'],
["unid_id"=>16,"id"=>65,'codigo'=>'1510004','nombre'=>'RECOLECCION DE BASURA (GESTIONES ANTERIORES)'],
["unid_id"=>16,"id"=>66,'codigo'=>'1510016','nombre'=>'REGISTRO DE VEHICULOS'],
["unid_id"=>16,"id"=>67,'codigo'=>'1533001','nombre'=>'CONCESIONES MINERAS'],
["unid_id"=>16,"id"=>68,'codigo'=>'1534001','nombre'=>'PATENTE A LA INDUSTRIA EN GENERAL'],
["unid_id"=>16,"id"=>69,'codigo'=>'1534002','nombre'=>'PATENTE A LOS SERVICIOS FINACIEROS BANCARIOS'],
["unid_id"=>16,"id"=>70,'codigo'=>'1534003','nombre'=>'PATENTE A LOS SERVICIOS FINACIEROS DE SEGUROS Y REASEGUROS'],
["unid_id"=>16,"id"=>71,'codigo'=>'1534004','nombre'=>'PATENTE A LOS SERVICIOS ESPECIFICOS'],
["unid_id"=>16,"id"=>72,'codigo'=>'1534005','nombre'=>'PATENTE A LA ACTIVIDAD HOTELES EN GENERAL'],
["unid_id"=>16,"id"=>73,'codigo'=>'1599001','nombre'=>'VENTA DE ARTESANIAS EN EL MUSEO'],
["unid_id"=>16,"id"=>74,'codigo'=>'1650001','nombre'=>'ALQUILER CASA MUNICIPAL DE CULTURA'],


        ]);
    }
}
