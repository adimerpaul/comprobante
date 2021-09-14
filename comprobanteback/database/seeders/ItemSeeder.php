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
["id"=>1,'codigo'=>'1210000','nombre'=>'VENTA Y REPOSICIÓN                              '],
["id"=>2,'codigo'=>'1210001','nombre'=>'VENTA DE TERRENOS BALDIOS                              '],
["id"=>3,'codigo'=>'1210002','nombre'=>'VENTA DE TERRENOS CEMENTERIO                           '],
["id"=>4,'codigo'=>'1210003','nombre'=>'VENTA DE OTROS BIENES                                  '],
["id"=>5,'codigo'=>'1220001','nombre'=>'VENTA DE ENTRADAS AL MUSEO                             '],
["id"=>6,'codigo'=>'1220002','nombre'=>'VENTA DE ENTRADAS AL ZOOLOGICO                         '],
["id"=>7,'codigo'=>'1220003','nombre'=>'VENTA DE METROS LINEALES, ASIENTOS CARNAVAL            '],
["id"=>8,'codigo'=>'1220004','nombre'=>'VENTA DE ENTRADAS AL PARQUE ECOLOGICO                  '],
["id"=>9,'codigo'=>'1220005','nombre'=>'VENTA DE OTROS SERVICIOS                               '],
["id"=>10,'codigo'=>'1220006','nombre'=>'VENTA DE ENTRADAS AL PARQUE INTI RAYMI                 '],
["id"=>11,'codigo'=>'1220007','nombre'=>'VENTA DE REPOSICION DE FORMULARIOS Y COMPROBANTES      '],//10
["id"=>12,'codigo'=>'1339001','nombre'=>'IMPUESTO A LA ELABORACION DE CHICHA                    '],
["id"=>13,'codigo'=>'1510005','nombre'=>'CONEXION DE CABLES, TERRESTRES: FIBRA OPTICA Y OTROS   '],
["id"=>14,'codigo'=>'1510006','nombre'=>'APROBACION DE PLANOS                                   '],
["id"=>15,'codigo'=>'1510008','nombre'=>'APROBACION DE URBANIZACIONES                           '],
["id"=>16,'codigo'=>'1510009','nombre'=>'APROBACION LINEA NIVEL                                 '],
["id"=>17,'codigo'=>'1510010','nombre'=>'POR CONEXION DE ALCANTARILLADO, CHICOLLOS, ACOMETIDAS  '],
["id"=>18,'codigo'=>'1510011','nombre'=>'DERECHO CONCESION DE PUESTOS EVENTUALES                '],
["id"=>19,'codigo'=>'1510012','nombre'=>'DERECHO INSTALACION CASETAS                            '],
["id"=>20,'codigo'=>'1510013','nombre'=>'CAMBIO DE NOMBRE DE PUESTOS                            '],
["id"=>21,'codigo'=>'1510014','nombre'=>'CERTIFICACION DE TRAMITES                              '],//20
["id"=>22,'codigo'=>'1510015','nombre'=>'DERECHOS VARIOS                                        '],
["id"=>23,'codigo'=>'1510017','nombre'=>'REGISTRO DE INMUEBLES                                  '],
["id"=>24,'codigo'=>'1510018','nombre'=>'REGISTRO ACTIVIDAD ECONOMICA                           '],
["id"=>25,'codigo'=>'1510019','nombre'=>'VENTA DE VALORES (FICHA INSPECCION, DEFENSA CONSUMIDOR)'],
["id"=>26,'codigo'=>'1510020','nmbre'=>'TRAFICO Y ESTACIONAMIENTO DE VEHICULOS                 '],
["id"=>27,'codigo'=>'1510021','nombre'=>'SANCIONES E INFRACCIONES VARIOS                        '],
["id"=>28,'codigo'=>'1510022','nombre'=>'REPOSICION DE PAVIMENTO                                '],
["id"=>29,'codigo'=>'1510023','nombre'=>'OTROS NO ESPECIFICADOS                                 '],
["id"=>30,'codigo'=>'1534006','nombre'=>'PATENTE A LOS SERVICIOS EN GENERAL                     '],
["id"=>31,'codigo'=>'1534007','nombre'=>'PATENTE AL COMERCIO EN GENERAL                         '],//30
["id"=>32,'codigo'=>'1534008','nombre'=>'PATENTE AL COMERCIO MINORISTA (SENTAJE-SITIAJES)       '],
["id"=>33,'codigo'=>'1534009','nombre'=>'PATENTE A LOS ESPECTACULOS Y RECREACIONES              '],
["id"=>34,'codigo'=>'1534010','nombre'=>'PATENTE NO CONTEMPLADOS                                '],
["id"=>35,'codigo'=>'1534011','nombre'=>'PATENTE POR TEMPORADAS A61                             '],
["id"=>36,'codigo'=>'1591001','nombre'=>'SERVICIOS TECNICOS (CONSTRUCCIONES CLANDESTINAS)       '],
["id"=>37,'codigo'=>'1591002','nombre'=>'INFRACCIONES MERCADOS                                  '],
["id"=>38,'codigo'=>'1591003','nombre'=>'OTROS                                                  '],
["id"=>39,'codigo'=>'1592001','nombre'=>'INTERESES PENALES VARIOS                               '],
["id"=>40,'codigo'=>'1630001','nombre'=>'ALQUILER DE NICHOS                                     '],
["id"=>41,'codigo'=>'1630002','nombre'=>'VENTA DE HORNACINAS                                    '],
["id"=>42,'codigo'=>'1630003','nombre'=>'RENOVACION DE NICHOS                                   '],
["id"=>43,'codigo'=>'1630004','nombre'=>'CONSERVACION HORNACINAS Y MAUSOLEOS                    '],
["id"=>44,'codigo'=>'1630005','nombre'=>'ALQUILER DE MINGITORIOS                                '],
["id"=>45,'codigo'=>'1630006','nombre'=>'ALQUILER DE TIENDAS Y KIOSCOS                          '],
["id"=>46,'codigo'=>'1630007','nombre'=>'ALQUILER BALNEARIO CAPACHOS                            '],
["id"=>47,'codigo'=>'1630008','nombre'=>'ALQUILER TEATROS AL AIRE LIBRE                         '],
["id"=>48,'codigo'=>'1630009','nombre'=>'OTROS ALQUILERES (DEVENGADOS, MATADERO)                '],
["id"=>49,'codigo'=>'1510007','nombre'=>'LEGALIZACION DE PLANOS                                 '],
["id"=>51,'codigo'=>'1220008','nombre'=>'VENTA DE ENTRADAS BALNEARIO CAPACHOS                   '],//50
["id"=>52,'codigo'=>'1220009','nombre'=>'VENTA DE ENTRADAS MON. ESC. VIRGEN DEL SOCAVON         '],
["id"=>53,'codigo'=>'1510024','nombre'=>'TASAS POR RESONANCIA MAGNÉTICA                         '],
["id"=>54,'codigo'=>'1510025','nombre'=>'TASAS POR TOMOGRAFÍA AXIAL COMPUTARIZADA (TAC)         '],
["id"=>55,'codigo'=>'1510026','nombre'=>'TASAS POR RAYOZ X                                      '],
["id"=>56,'codigo'=>'1510027','nombre'=>'TASAS POR ECOGRAFÍA                                    '],
["id"=>57,'codigo'=>'1510028','nombre'=>'TASAS POR SERVICIO DE ESTACIONAMIENTO VEHICULAR        '],
["id"=>58,'codigo'=>'1630010','nombre'=>'ALQUILER DE CAMPOS DEPORTIVOS                          '],
["id"=>59,'codigo'=>'1630011','nombre'=>'ALQUILER SALON LUIS RAMIRO BELTRAN                     '],
["id"=>60,'codigo'=>'1630012','nombre'=>'ALQUILER MAQUINARIA PESADA                             '],
["id"=>61,'codigo'=>'1339000','nombre'=>'OTROS (USO DE SUELO COTEOR SELA ELFEO)'],
["id"=>62,'codigo'=>'1510001','nombre'=>'TASA ALCANTARILLADO SANITARIO   '],
["id"=>63,'codigo'=>'1510002','nombre'=>'ALUMBRADO PUBLICO (TASA ADICIONAL ELFEO)'],
["id"=>64,'codigo'=>'1510003','nombre'=>'ALUMBRADO PUBLICO (GESTIONES ANTERIORES)'],
["id"=>65,'codigo'=>'1510004','nombre'=>'RECOLECCION DE BASURA (GESTIONES ANTERIORES)'],
["id"=>66,'codigo'=>'1510016','nombre'=>'REGISTRO DE VEHICULOS'],
["id"=>67,'codigo'=>'1533001','nombre'=>'CONCESIONES MINERAS'],
["id"=>68,'codigo'=>'1534001','nombre'=>'PATENTE A LA INDUSTRIA EN GENERAL'],
["id"=>69,'codigo'=>'1534002','nombre'=>'PATENTE A LOS SERVICIOS FINACIEROS BANCARIOS'],
["id"=>70,'codigo'=>'1534003','nombre'=>'PATENTE A LOS SERVICIOS FINACIEROS DE SEGUROS Y REASEGUROS'],
["id"=>71,'codigo'=>'1534004','nombre'=>'PATENTE A LOS SERVICIOS ESPECIFICOS'],
["id"=>72,'codigo'=>'1534005','nombre'=>'PATENTE A LA ACTIVIDAD HOTELES EN GENERAL'],
["id"=>73,'codigo'=>'1599001','nombre'=>'VENTA DE ARTESANIAS EN EL MUSEO'],
["id"=>74,'codigo'=>'1650001','nombre'=>'ALQUILER CASA MUNICIPAL DE CULTURA'],


        ]);
    }
}
