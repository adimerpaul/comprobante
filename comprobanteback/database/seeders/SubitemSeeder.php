<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubitemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subitems')->insert([
//           [
//               'codigo'=>"",
//                'nombre'=>"",
//                'detalle'=>"",
//                'monto'=>"",
//                'item_id'=>"",
//                'unid_id'=>"",
//           ]
['unid_id'=>'16','item_id'=>'1','codigo'=>'122000001','nombre'=>'Venta y reposicion de formulario                                             ','monto'=>'2.00   '],
['unid_id'=>'16','item_id'=>'5','codigo'=>'122000101','nombre'=>'Mayores                                                                      ','monto'=>'2.00   '],
['unid_id'=>'16','item_id'=>'5','codigo'=>'122000102','nombre'=>'Menores                                                                      ','monto'=>'1.00   '],
['unid_id'=>'16','item_id'=>'5','codigo'=>'122000103','nombre'=>'Extrangeros                                                                  ','monto'=>'5.00   '],
['unid_id'=>'16','item_id'=>'5','codigo'=>'122000104','nombre'=>'Postales                                                                  ','monto'=>'5.00   '],
['unid_id'=>'16','item_id'=>'6','codigo'=>'122000201','nombre'=>'Mayores                                                                      ','monto'=>'2.00   '],
['unid_id'=>'16','item_id'=>'6','codigo'=>'122000202','nombre'=>'Menores                                                                      ','monto'=>'1.00   '],
['unid_id'=>'16','item_id'=>'6','codigo'=>'122000203','nombre'=>'Entrada Miungitorio                                                           ','monto'=>'0.50   '],
['unid_id'=>'16','item_id'=>'8','codigo'=>'122000401','nombre'=>'Mayores                                                                      ','monto'=>'2.00   '],
['unid_id'=>'16','item_id'=>'8','codigo'=>'122000402','nombre'=>'Menores                                                                      ','monto'=>'1.00   '],
['unid_id'=>'16','item_id'=>'9','codigo'=>'122000501','nombre'=>'Servicio Internet x 1hr.                                                     ','monto'=>'1.00   '],
['unid_id'=>'16','item_id'=>'9','codigo'=>'122000502','nombre'=>'Servicio de Impresión                                                        ','monto'=>'1.00   '],
['unid_id'=>'16','item_id'=>'10','codigo'=>'122000601','nombre'=>'Entrada Genral                                                               ','monto'=>'3.00   '],
['unid_id'=>'16','item_id'=>'10','codigo'=>'122000602','nombre'=>'Entrada Carrusel eléctrico                                                   ','monto'=>'3.00   '],
['unid_id'=>'16','item_id'=>'10','codigo'=>'122000603','nombre'=>'Entrada Castillo                                                             ','monto'=>'2.00   '],
['unid_id'=>'16','item_id'=>'10','codigo'=>'122000604','nombre'=>'Entrada Tren locomotora                                                      ','monto'=>'2.00   '],
['unid_id'=>'16','item_id'=>'10','codigo'=>'122000605','nombre'=>'Entrada Mingitorio                                                      ','monto'=>'0.50   '],
['unid_id'=>'16','item_id'=>'51','codigo'=>'122000801','nombre'=>'Ingreso a Reservado                                                          ','monto'=>'35.00  '],
['unid_id'=>'16','item_id'=>'51','codigo'=>'122000802','nombre'=>'Ingreso a Piscina                                                            ','monto'=>'3.00   '],
['unid_id'=>'16','item_id'=>'51','codigo'=>'122000803','nombre'=>'Piscina Olimpica dia                                                         ','monto'=>'3.00   '],
['unid_id'=>'16','item_id'=>'51','codigo'=>'122000804','nombre'=>'Piscina Olimpica noche                                                        ','monto'=>'7.00   '],
['unid_id'=>'16','item_id'=>'52','codigo'=>'122000901','nombre'=>'Entrada Mayores                                                        ','monto'=>'3.00   '],
['unid_id'=>'16','item_id'=>'52','codigo'=>'122000902','nombre'=>'Entrada Menores de 8 años                                                    ','monto'=>'1.00   '],
['unid_id'=>'16','item_id'=>'52','codigo'=>'122000903','nombre'=>'Entrada Extranjeros                                                ','monto'=>'10.00   '],
['unid_id'=>'16','item_id'=>'52','codigo'=>'122000904','nombre'=>'Entrada Mingitorio                                                       ','monto'=>'1.00   '],
['unid_id'=>'16','item_id'=>'52','codigo'=>'122000905','nombre'=>'Entrada General                                                      ','monto'=>'2.00   '],
['unid_id'=>'16','item_id'=>'24','codigo'=>'151001801','nombre'=>'Registro de Actividad Económica                                              ','monto'=>'241.00 '],
['unid_id'=>'16','item_id'=>'24','codigo'=>'151001802','nombre'=>'Cambio de Nombre                                                             ','monto'=>'32.00  '],
['unid_id'=>'16','item_id'=>'24','codigo'=>'151001803','nombre'=>'Cambio de dirección                                                          ','monto'=>'32.00  '],
['unid_id'=>'16','item_id'=>'24','codigo'=>'151001804','nombre'=>'Cierre Temporal                                                              ','monto'=>'32.00  '],
['unid_id'=>'16','item_id'=>'24','codigo'=>'151001805','nombre'=>'Cierre definitivo                                                            ','monto'=>'32.00  '],
['unid_id'=>'16','item_id'=>'26','codigo'=>'151002001','nombre'=>'Plaza 10 de Febrero infraccion por parqueo indebido   ','monto'=>'1.00  '],
['unid_id'=>'16','item_id'=>'26','codigo'=>'151002002','nombre'=>'Distribuidor Av. Villarroel y 6 de Agosto infraccion por parqueo indebido   ','monto'=>'1.00  '],
['unid_id'=>'16','item_id'=>'26','codigo'=>'151002003','nombre'=>'Plataforma de la Av. Civica infraccion por parqueo indebido','monto'=>'1.00  '],
['unid_id'=>'16','item_id'=>'26','codigo'=>'151002004','nombre'=>'Plataforma Atrio Socavon infraccion por parqueo indebido','monto'=>'1.00  '],
['unid_id'=>'16','item_id'=>'26','codigo'=>'151002005','nombre'=>'Playa de Estacionamiento Abel Azcarrunz infraccion por parqueo indebido','monto'=>'1.00  '],
['unid_id'=>'16','item_id'=>'26','codigo'=>'151002006','nombre'=>'Calle Vco. Galvarro entre Caro y Montesinos infraccion por parqueo indebido','monto'=>'1.00  '],
['unid_id'=>'16','item_id'=>'26','codigo'=>'151002007','nombre'=>'Parqueo temporal Plataforma Av. Cívica','monto'=>'1.00  '],
['unid_id'=>'16','item_id'=>'26','codigo'=>'151002008','nombre'=>'Parqueo temporal Atrio del Socavón','monto'=>'1.00  '],
['unid_id'=>'16','item_id'=>'26','codigo'=>'151002009','nombre'=>'Parqueo temporal Playa de Estacionamiento','monto'=>'1.00  '],
['unid_id'=>'16','item_id'=>'26','codigo'=>'151002010','nombre'=>'Parqueo temporal Paso Desnivel 6 de Agosto y Villarroel','monto'=>'1.00  '],
['unid_id'=>'16','item_id'=>'26','codigo'=>'151002011','nombre'=>'Parqueo temporal Montesinos Velasco','monto'=>'1.00  '],
['unid_id'=>'16','item_id'=>'26','codigo'=>'151002012','nombre'=>'Otros','monto'=>'1.00  '],
['unid_id'=>'16','item_id'=>'26','codigo'=>'151002013','nombre'=>'Parqueo Temporal Balneario Capachos','monto'=>'0.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400901','nombre'=>'Baile con conjuntos Internacionales (carnaval)                               ','monto'=>'1142.00'],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400902','nombre'=>'Baile con conjuntos nacionales (carnaval)                                    ','monto'=>'927.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400903','nombre'=>'Peñas folklóricas en general (carnaval)                                      ','monto'=>'518.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400904','nombre'=>'Bailes continuados diurno-nocturno (carnaval)                                ','monto'=>'379.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400905','nombre'=>'Bailes nocturnos (carnaval)                                                  ','monto'=>'326.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400906','nombre'=>'Bailes Diurnos (carnaval)                                                    ','monto'=>'262.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400907','nombre'=>'Baile en sábado y domingo de tentaciones (carnaval)                          ','monto'=>'1567.00'],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400908','nombre'=>'Pasacalle en Plaza 10 de Febrero y Av. Cívica (carnaval)                     ','monto'=>'1711.00'],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400909','nombre'=>'Pasacalle en otras vías del recorrido de carnaval (carnaval)                 ','monto'=>'1241.00'],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400910','nombre'=>'Gigantografías publicitarias en sector recorrido (carnaval)                  ','monto'=>'1437.00'],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400911','nombre'=>'Globos publicitarios fijos o flotantes en recorrido (carnaval)               ','monto'=>'1437.00'],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400912','nombre'=>'Pasacalle en otras vias de la capital (carnaval)                             ','monto'=>'923.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400913','nombre'=>'Equipos de filmación televisivo (carnaval)                                   ','monto'=>'1711.00'],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400914','nombre'=>'Filmadores semiprofesionales individuales comerciales (carnaval)             ','monto'=>'880.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400915','nombre'=>'Equipos fotográficos profesionales (carnaval)                                ','monto'=>'201.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400916','nombre'=>'Equipos fotográficos semiprofesionales (carnaval)                            ','monto'=>'91.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400917','nombre'=>'Empresas televisivas comerciales de alcance Nacional e Int. (carnaval)       ','monto'=>'2090.00'],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400918','nombre'=>'Empresas televisivas comerciales de alcance local (carnaval)                 ','monto'=>'522.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400919','nombre'=>'Organizaciones televisivas institucionales y comunitarias (carnaval)         ','monto'=>'216.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400920','nombre'=>'Bailes en fechas especiales con conjuntos nacionales                         ','monto'=>'314.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400921','nombre'=>'Bailes en fechas especiales con conjuntos internacionales                    ','monto'=>'523.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400922','nombre'=>'Bailes en fechas especiales amplificación                                    ','monto'=>'287.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400923','nombre'=>'Bailes en fechas ordinarias con conjuntos nacionales                         ','monto'=>'287.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400924','nombre'=>'Bailes en fechas ordinarias con conjuntos internacionales                    ','monto'=>'314.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400925','nombre'=>'Balie en fechas ordinarias (nocturno) amplif. coleg (19:30 a 22:30)          ','monto'=>'157.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400926','nombre'=>'Baile en fechas ordinaraias matine amplif. coleg(14:30 a 19:00)              ','monto'=>'105.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400927','nombre'=>'Baile en fechas ordinarias con amplif. p. univ. y particulares               ','monto'=>'217.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400928','nombre'=>'Espectáculos teatrales internacionales por función                           ','monto'=>'105.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400929','nombre'=>'Espectáculos teatrales nacionales por función                                ','monto'=>'63.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400930','nombre'=>'Peña con grupo folklorico musicales                                          ','monto'=>'157.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400931','nombre'=>'conciertos                                                                   ','monto'=>'157.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400932','nombre'=>'Kermésse                                                                     ','monto'=>'157.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400933','nombre'=>'Patente por cada función circo internacional (grande)                        ','monto'=>'78.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400934','nombre'=>'Patente por cada función circo pequeño                                       ','monto'=>'55.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400935','nombre'=>'Parque de diversión por aparato grande                                       ','monto'=>'78.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400936','nombre'=>'Parque de diversión por aparato pequeño                                      ','monto'=>'38.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400937','nombre'=>'Electrónicos por aparato                                                     ','monto'=>'19.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400938','nombre'=>'Ataris por aparato                                                           ','monto'=>'11.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400939','nombre'=>'Play Station II por aparato                                                  ','monto'=>'19.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400940','nombre'=>'Play Station por aparato                                                     ','monto'=>'11.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400941','nombre'=>'Juegos en red por computadora                                                ','monto'=>'11.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400942','nombre'=>'Salon de billar por mesa                                                     ','monto'=>'11.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400943','nombre'=>'Futbolines por aparato                                                       ','monto'=>'6.00   '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400944','nombre'=>'Carrusel grande a motor                                                      ','monto'=>'55.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400945','nombre'=>'Carrusel manual pequeño                                                      ','monto'=>'38.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400946','nombre'=>'Ataris con bailadora y rockola                                               ','monto'=>'21.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400947','nombre'=>'Letrero luminoso de dos caras x 2 m² anual                                   ','monto'=>'40.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400948','nombre'=>'Letrero luminoso de una cara x 2 m² anual                                    ','monto'=>'21.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400949','nombre'=>'Letrero plancha y banner de dos caras x 2 m² anual                           ','monto'=>'23.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400950','nombre'=>'Letrero plancha y banner de una cara x 2 m² anual                            ','monto'=>'12.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400951','nombre'=>'Letrero de una cara banner                                                   ','monto'=>'12.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400952','nombre'=>'Murales x 2 m² una cara                                                      ','monto'=>'12.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400953','nombre'=>'Gigantografía x 2 m² una cara                                                ','monto'=>'12.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400954','nombre'=>'Gigantografía x 2 m² dos cara                                                ','monto'=>'23.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400955','nombre'=>'Pasacalles                                                                   ','monto'=>'21.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400956','nombre'=>'Pancartas transversal por dia el m²                                          ','monto'=>'6.00   '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400957','nombre'=>'Publicidad movil con patente por hora                                        ','monto'=>'6.00   '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400958','nombre'=>'Afiches x m²                                                                 ','monto'=>'6.00   '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400959','nombre'=>'Juegos inflables                                                             ','monto'=>'36.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400960','nombre'=>'Cochecitos a bateria                                                         ','monto'=>'12.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400961','nombre'=>'Cochecitos a pedal                                                           ','monto'=>'11.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400962','nombre'=>'Juego tiro al banco, lota, otros 4x4 feria norte                             ','monto'=>'24.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400963','nombre'=>'Juegos al azar con espacio de 1x1 feria norte                                ','monto'=>'5.00   '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400964','nombre'=>'Otros juegos recreativos con espacio de 1.5x1.5 feria norte                  ','monto'=>'19.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400965','nombre'=>'Futbolines por cada mesa feria norte                                         ','monto'=>'6.00   '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400966','nombre'=>'Carruseles por espacio ocupado de 4x4 feria norte                            ','monto'=>'270.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400967','nombre'=>'Carruseles por cada aparato con espacio menor de 3x3 feria norte             ','monto'=>'70.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400968','nombre'=>'Por cada carrito feria norte                                                 ','monto'=>'6.00   '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400969','nombre'=>'Juegos inflables, camas elasticas feria norte                                ','monto'=>'38.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400970','nombre'=>'Por cada carrito a motor y motos feria norte                                 ','monto'=>'10.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400971','nombre'=>'Carrusel por aparato manual feria norte                                      ','monto'=>'36.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400972','nombre'=>'Juego tiro al banco, lota, otros 4x4 feria sud                               ','monto'=>'12.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400973','nombre'=>'Otros juegos recreativos con espacio de 1.5x1.5 feria sud                    ','monto'=>'12.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400974','nombre'=>'Futbolines por mesa feria sud                                                ','monto'=>'6.00   '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400975','nombre'=>'Carruseles por espacio ocupado de 4x4 feria sud                              ','monto'=>'150.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400976','nombre'=>'Carruseles por cada aparato con espacio menor de 3x3 feria sud               ','monto'=>'31.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400977','nombre'=>'Por cada carrito feria sud                                                   ','monto'=>'6.00   '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400978','nombre'=>'Juegos inflables por juego feria sud                                         ','monto'=>'38.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400979','nombre'=>'Carritos a motor y motos                                                     ','monto'=>'10.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400980','nombre'=>'Gigantografía Publicitaria plaza,principal y Av. Civica (Carnaval)           ','monto'=>'1920.00'],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400981','nombre'=>'Globos publicitario fijos o flotantes plaza principal y Av. civica (carnaval)','monto'=>'1920.00'],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400982','nombre'=>'Publicidad Televisiva mediante pantalla LED (Carnaval)                       ','monto'=>'1920.00'],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400983','nombre'=>'Lota, bingo, tiro al blanco y otros sup hasta 4 x 4 mts (calvario)           ','monto'=>'158.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400984','nombre'=>'Carruseles grandes (calvario)                                                ','monto'=>'421.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400985','nombre'=>'Carruseles pequeños (calvario)                                               ','monto'=>'153.00 '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400986','nombre'=>'Futbolines por mesa (calvario)                                               ','monto'=>'20.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400987','nombre'=>'Cochecitos a motor y bateria c/u Bs. 52 (calvario)                           ','monto'=>'52.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400988','nombre'=>'Cochecitos a pedal c/u Bs. 28 (Calvario)                                     ','monto'=>'28.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400989','nombre'=>'Juegos Menores por puesto hasta 2 x 3 mts (calvario)                                     ','monto'=>'106.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400990','nombre'=>'Kermesse feria norte                                     ','monto'=>'281.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400991','nombre'=>'','monto'=>'0.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400992','nombre'=>'Kermesse feria sud','monto'=>'258.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400993','nombre'=>'Cuadratrack y buggi feria norte','monto'=>'25.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400994','nombre'=>'Juegos de tiro al blanco y otros 4x4 feria vinto','monto'=>'14.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400995','nombre'=>'Barco Vikingo','monto'=>'200.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400996','nombre'=>'Futbolines por cada mesa feria vinto','monto'=>'5.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400997','nombre'=>'Carruseles por aparato de 3 x 3 feria vinto','monto'=>'5.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400998','nombre'=>'Carritos a pedal feria vinto','monto'=>'5.00  '],
['unid_id'=>'16','item_id'=>'33','codigo'=>'153400999','nombre'=>'Juegos inflables , camas elasticas y similares feria vinto','monto'=>'43.00  '],

['unid_id'=>'3','item_id'=>'18','codigo'=>'151001101','nombre'=>'Registro Comerciante Formal ','monto'=>'379.55 '],
['unid_id'=>'3','item_id'=>'18','codigo'=>'151001102','nombre'=>'Registro Actividad Formal ','monto'=>'76.37 '],
['unid_id'=>'3','item_id'=>'18','codigo'=>'151001103','nombre'=>'Registro Comerciante Eventual ','monto'=>'76.37 '],
['unid_id'=>'3','item_id'=>'18','codigo'=>'151001104','nombre'=>'Registro Actividad Eventual ','monto'=>'76.37 '],
['unid_id'=>'3','item_id'=>'18','codigo'=>'151001105','nombre'=>'Traspaso de Comerciante Eventual a Formal ','monto'=>'379.55 '],
['unid_id'=>'3','item_id'=>'19','codigo'=>'151001201','nombre'=>'Derecho Instalación Caseta Formal y Eventual ','monto'=>'304.32 '],
['unid_id'=>'3','item_id'=>'19','codigo'=>'151001202','nombre'=>'Derecho de Refacción Caseta formal y Eventual ','monto'=>'304.32 '],
['unid_id'=>'3','item_id'=>'20','codigo'=>'151001301','nombre'=>'Cambio de Nombre Formal ','monto'=>'1520.49 '],
['unid_id'=>'3','item_id'=>'20','codigo'=>'151001302','nombre'=>'Cambio de Nombre Formal ','monto'=>'1216.16 '],
['unid_id'=>'3','item_id'=>'20','codigo'=>'151001303','nombre'=>'Cambio de Nombre Eventual ','monto'=>'912.97 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001401','nombre'=>'Certificado de Registro de propiedad para inmuebles y vehiculos ','monto'=>'70 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001402','nombre'=>'Certificado de licencia de funcionamiento ','monto'=>'70 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001403','nombre'=>'Cetificado pago de transferencia para inmuebles y vehiculos ','monto'=>'50 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001404','nombre'=>'Certificado de pago de Impuestos inmuebles y vehiculos','monto'=>'50 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001405','nombre'=>'Certificado de registro de propiedad CRPVA para inmuebles y vehiculos ','monto'=>'130 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001406','nombre'=>'Certificado de pago de impuestos inmuebles y vehiculos (emitidos por sistema) ','monto'=>'70 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001407','nombre'=>'Certificado de trabajo ','monto'=>'70 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001408','nombre'=>'ertificado catastral ','monto'=>'70 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001409','nombre'=>'Certificados emitidos por entidad municipal ','monto'=>'70 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001410','nombre'=>'Certificado de Licencia de Funcionamiento Actividades Económicas ','monto'=>'70 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001411','nombre'=>'Certificados varios ','monto'=>'130 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001412','nombre'=>'Certificado Administracion Tributaria Municipal ','monto'=>'130 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001413','nombre'=>'Certificado de inmuebles patrimoniales','monto'=>'130 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001414','nombre'=>'Certificado de Publicidad Urbana ','monto'=>'130 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001415','nombre'=>'Certificado de Actividades economicas ','monto'=>'130 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001416','nombre'=>'Certificado de Licencia de Funcionamiento Actividades(Expendio de Bebidas Alcoholicas)','monto'=>'130 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001417','nombre'=>'Certificado de Pago de Impuestos a la Propiedad ','monto'=>'130 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001418','nombre'=>'Certificado de Datos técnicos de inmuebles ','monto'=>'130 '],
['unid_id'=>'3','item_id'=>'21','codigo'=>'151001419','nombre'=>'Copia legalizada del certificado de registro de propiedad de vehículo automotor (RUAT -CRPVA)','monto'=>'130 '],
['unid_id'=>'3','item_id'=>'22','codigo'=>'151001501','nombre'=>'Derechos Varios Carritos Ambulantes ','monto'=>'0 '],
['unid_id'=>'3','item_id'=>'22','codigo'=>'151001502','nombre'=>'Carrito Ambulante con Tarjeta Unica Gremial ','monto'=>'88.67 '],
['unid_id'=>'3','item_id'=>'22','codigo'=>'151001503','nombre'=>'Carrito Ambulante sin Tarjeta Unica Gremial ','monto'=>'169.57 '],
['unid_id'=>'3','item_id'=>'22','codigo'=>'151001504','nombre'=>'Carrito Ambulante Deudads Gestiones Anteriores ','monto'=>'0 '],
['unid_id'=>'3','item_id'=>'27','codigo'=>'151002101','nombre'=>'Sanciones e infracciones varios ','monto'=>'1 '],
['unid_id'=>'3','item_id'=>'29','codigo'=>'151002301','nombre'=>'Otros no Especificados (Bajas) Eventual a Formal ','monto'=>'76.37 '],
['unid_id'=>'3','item_id'=>'35','codigo'=>'153401101','nombre'=>'Juego tiro al banco, lota, otros 4x4 feria sud ','monto'=>'18'],
['unid_id'=>'3','item_id'=>'35','codigo'=>'153401102','nombre'=>'Juegos al azar de 1m x 1m: ruletas, mesa, tira moneda s/sup.  feria sud ','monto'=>'8'],
['unid_id'=>'3','item_id'=>'35','codigo'=>'153401103','nombre'=>'Futbolines por mesa feria sud ','monto'=>'10'],
['unid_id'=>'3','item_id'=>'35','codigo'=>'153401104','nombre'=>'Carritos a pedal feria sud ','monto'=>'10'],
['unid_id'=>'3','item_id'=>'35','codigo'=>'153401105','nombre'=>'Carritos a motor feria sud ','monto'=>'18 '],
['unid_id'=>'3','item_id'=>'35','codigo'=>'153401106','nombre'=>'Cuadratrack y Buggi feria sud ','monto'=>'20 '],
['unid_id'=>'3','item_id'=>'35','codigo'=>'153401107','nombre'=>'Juegos inflables por juego feria sud ','monto'=>'57 '],
['unid_id'=>'3','item_id'=>'35','codigo'=>'153401108','nombre'=>'Cama elastica pequeña feria sud ','monto'=>'25'],
['unid_id'=>'3','item_id'=>'35','codigo'=>'153401109','nombre'=>'Cama elastica grande feria sud ','monto'=>'35'],
['unid_id'=>'3','item_id'=>'35','codigo'=>'153401110','nombre'=>'Rueda Pequeña sup. menor de 3x3 feria sud ','monto'=>'50'],
['unid_id'=>'3','item_id'=>'35','codigo'=>'153401111','nombre'=>'Rueda Grande sup. de 4x4 feria sud','monto'=>'226'],
['unid_id'=>'3','item_id'=>'35','codigo'=>'153401112','nombre'=>'Juego de tren feria sud ','monto'=>'70'],
['unid_id'=>'3','item_id'=>'35','codigo'=>'153401113','nombre'=>'Barco Vikingo y otros no especificados feria sud','monto'=>'100 '],
['unid_id'=>'3','item_id'=>'34','codigo'=>'153401001','nombre'=>'Tiro al blanco y similares 1.50 x 1.50 ','monto'=>'47 '],
['unid_id'=>'3','item_id'=>'34','codigo'=>'153401002','nombre'=>'Fotografos temporada navidad ','monto'=>'22 '],
['unid_id'=>'3','item_id'=>'38','codigo'=>'159100301','nombre'=>'Otros: Cambio De Actividad Eventual y Formal ','monto'=>'76.37 '],
['unid_id'=>'3','item_id'=>'38','codigo'=>'159100302','nombre'=>'Otros: Cambio de Dirección Eventual y Formal ','monto'=>'76.37 '],
['unid_id'=>'3','item_id'=>'38','codigo'=>'159100303','nombre'=>'Otros: Rectificación de Superficie ','monto'=>'103.32 '],
['unid_id'=>'3','item_id'=>'38','codigo'=>'159100304','nombre'=>'Ampliación de Dias de Venta Formal y Eventual ','monto'=>'76.37 '],
['unid_id'=>'3','item_id'=>'32','codigo'=>'153400801','nombre'=>'Sentajes y Sitiajes ','monto'=>'1 '],
['unid_id'=>'3','item_id'=>'37','codigo'=>'159100201','nombre'=>'Multas A-61 ','monto'=>'1 '],
['unid_id'=>'3','item_id'=>'18','codigo'=>'151001106','nombre'=>'Autorización venta de SOAT ','monto'=>'65.13 '],
['unid_id'=>'3','item_id'=>'18','codigo'=>'151001107','nombre'=>'Renovacion Patron ','monto'=>'76.19 '],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001001','nombre'=>'Sierra Mier EMAL II Cancha sin tinglado Cat- C','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001002','nombre'=>'Sierra Mier EMAL II Cancha con tinglado Cat- A','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001003','nombre'=>'Sierra Mier EMAL II Cancha cesped sintetico futbol 8 Cat-C','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001004','nombre'=>'Cancha BAMIN Tinglado Urb. ctubre','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001005','nombre'=>'Cancha Ex- Metabol Tinglado Polifuncional','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001006','nombre'=>'Cancha Ex- Metabol Pelota Fronton','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001007','nombre'=>'Cancha Raquet','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001008','nombre'=>'Cancha Polifuncional Abierto Cemento','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001009','nombre'=>'Cancha Ex Boldem Cemento','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001010','nombre'=>'Cancha Coliseo Polifuncional  piso Parket Villa Armonia','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001011','nombre'=>'Cancha Pasto Sintetico Rafael Pabon I','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001012','nombre'=>'Cancha Germania Pasto Sintetico I,II,III','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001013','nombre'=>'Cancha Germania Polfuncional Cemento Tinglado','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001014','nombre'=>'Cancha Tomas Barron Cemento','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001015','nombre'=>'Cancha Dios es Amor Pasto Sintetico','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001016','nombre'=>'Cancha de cesped sintetito Barrio Lindo La Aurora','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001017','nombre'=>'Gimnasio GAMO (ex-bolden)','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001018','nombre'=>'Cancha de Cesped Sintetico Futbol "Capachos"','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001019','nombre'=>'Cancha MADRID coliceo','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001020','nombre'=>'Cancha Coliseo CATCO','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001021','nombre'=>'Cancha pasto sintetico KANTUTA','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001022','nombre'=>'Cancha campamento San Jose Futbol 11','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001023','nombre'=>'Cancha Polifuncional ciudadela minera barrio San Jose','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001024','nombre'=>'Cancha SIERRA MIER I pasto sintetico futbol 8','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001025','nombre'=>'Complejo deportivo Evo Morales','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001026','nombre'=>'Coliseo Evo Morales','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001027','nombre'=>'ancha de cesped sintetico Villa Dorina','monto'=>'1'],
['unid_id'=>'3','item_id'=>'58','codigo'=>'163001028','nombre'=>'COLISEO QUIRQUINCHO','monto'=>'1'],
['unid_id'=>'3','item_id'=>'59','codigo'=>'163001101','nombre'=>'Inst. Fiscales por acto (1/2 dia cuatro horas) sin amplificación','monto'=>'590'],
['unid_id'=>'3','item_id'=>'59','codigo'=>'163001102','nombre'=>'Inst. Fiscales por acto (1/2 dia cuatro horas) con amplificación','monto'=>'690'],
['unid_id'=>'3','item_id'=>'59','codigo'=>'163001103','nombre'=>'Inst. Privadas por acto (1/2 dia cuatro horas) sin aplificacion','monto'=>'987'],
['unid_id'=>'3','item_id'=>'59','codigo'=>'163001104','nombre'=>'Inst. Privadas por acto (1/2 dia cuatro horas) con aplificacion','monto'=>'1137'],
['unid_id'=>'3','item_id'=>'59','codigo'=>'163001105','nombre'=>'Inst. Fiscales y Privadas por acto todo el dia (8 horas) sin aplificacion','monto'=>'1184'],
['unid_id'=>'3','item_id'=>'59','codigo'=>'163001106','nombre'=>'Inst. Fiscales y Privadas por acto todo el dia (8 horas) con aplificacion','monto'=>'1384'],
['unid_id'=>'3','item_id'=>'59','codigo'=>'163001107','nombre'=>'Conciertos Musicales y de teatro (siete horas desde 15:00 a 22:00)','monto'=>'1043'],
['unid_id'=>'3','item_id'=>'60','codigo'=>'163001201','nombre'=>'Tractor Agricola','monto'=>'1'],

        ]);
    }
}
