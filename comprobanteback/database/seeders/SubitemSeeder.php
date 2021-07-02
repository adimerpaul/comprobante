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
['item_id'=>'1','codigo'=>'122000001','nombre'=>'Venta y reposicion de formulario                                             ','monto'=>'2.00   '],
['item_id'=>'5','codigo'=>'122000101','nombre'=>'Mayores                                                                      ','monto'=>'2.00   '],
['item_id'=>'5','codigo'=>'122000102','nombre'=>'Menores                                                                      ','monto'=>'1.00   '],
['item_id'=>'5','codigo'=>'122000103','nombre'=>'Extrangeros                                                                  ','monto'=>'5.00   '],
['item_id'=>'6','codigo'=>'122000201','nombre'=>'Mayores                                                                      ','monto'=>'2.00   '],
['item_id'=>'6','codigo'=>'122000202','nombre'=>'Menores                                                                      ','monto'=>'1.00   '],
['item_id'=>'8','codigo'=>'122000401','nombre'=>'Mayores                                                                      ','monto'=>'2.00   '],
['item_id'=>'8','codigo'=>'122000402','nombre'=>'Menores                                                                      ','monto'=>'1.00   '],
['item_id'=>'9','codigo'=>'122000501','nombre'=>'Servicio Internet x 1hr.                                                     ','monto'=>'1.00   '],
['item_id'=>'9','codigo'=>'122000502','nombre'=>'Servicio de Impresión                                                        ','monto'=>'1.00   '],
['item_id'=>'10','codigo'=>'122000601','nombre'=>'Entrada Genral                                                               ','monto'=>'3.00   '],
['item_id'=>'10','codigo'=>'122000602','nombre'=>'Entrada Carrusel eléctrico                                                   ','monto'=>'3.00   '],
['item_id'=>'10','codigo'=>'122000603','nombre'=>'Entrada Castillo                                                             ','monto'=>'2.00   '],
['item_id'=>'10','codigo'=>'122000604','nombre'=>'Entrada Tren locomotora                                                      ','monto'=>'2.00   '],
['item_id'=>'51','codigo'=>'122000801','nombre'=>'Ingreso a Reservado                                                          ','monto'=>'35.00  '],
['item_id'=>'51','codigo'=>'122000802','nombre'=>'Ingreso a Piscina                                                            ','monto'=>'3.00   '],
['item_id'=>'24','codigo'=>'151001801','nombre'=>'Registro de Actividad Económica                                              ','monto'=>'241.00 '],
['item_id'=>'24','codigo'=>'151001802','nombre'=>'Cambio de Nombre                                                             ','monto'=>'32.00  '],
['item_id'=>'24','codigo'=>'151001803','nombre'=>'Cambio de dirección                                                          ','monto'=>'32.00  '],
['item_id'=>'24','codigo'=>'151001804','nombre'=>'Cierre Temporal                                                              ','monto'=>'32.00  '],
['item_id'=>'24','codigo'=>'151001805','nombre'=>'Cierre definitivo                                                            ','monto'=>'32.00  '],
['item_id'=>'33','codigo'=>'153400901','nombre'=>'Baile con conjuntos Internacionales (carnaval)                               ','monto'=>'1142.00'],
['item_id'=>'33','codigo'=>'153400902','nombre'=>'Baile con conjuntos nacionales (carnaval)                                    ','monto'=>'927.00 '],
['item_id'=>'33','codigo'=>'153400903','nombre'=>'Peñas folklóricas en general (carnaval)                                      ','monto'=>'518.00 '],
['item_id'=>'33','codigo'=>'153400904','nombre'=>'Bailes continuados diurno-nocturno (carnaval)                                ','monto'=>'379.00 '],
['item_id'=>'33','codigo'=>'153400905','nombre'=>'Bailes nocturnos (carnaval)                                                  ','monto'=>'326.00 '],
['item_id'=>'33','codigo'=>'153400906','nombre'=>'Bailes Diurnos (carnaval)                                                    ','monto'=>'262.00 '],
['item_id'=>'33','codigo'=>'153400907','nombre'=>'Baile en sábado y domingo de tentaciones (carnaval)                          ','monto'=>'1567.00'],
['item_id'=>'33','codigo'=>'153400908','nombre'=>'Pasacalle en Plaza 10 de Febrero y Av. Cívica (carnaval)                     ','monto'=>'1711.00'],
['item_id'=>'33','codigo'=>'153400909','nombre'=>'Pasacalle en otras vías del recorrido de carnaval (carnaval)                 ','monto'=>'1241.00'],
['item_id'=>'33','codigo'=>'153400910','nombre'=>'Gigantografías publicitarias en sector recorrido (carnaval)                  ','monto'=>'1437.00'],
['item_id'=>'33','codigo'=>'153400911','nombre'=>'Globos publicitarios fijos o flotantes en recorrido (carnaval)               ','monto'=>'1437.00'],
['item_id'=>'33','codigo'=>'153400912','nombre'=>'Pasacalle en otras vias de la capital (carnaval)                             ','monto'=>'923.00 '],
['item_id'=>'33','codigo'=>'153400913','nombre'=>'Equipos de filmación televisivo (carnaval)                                   ','monto'=>'1711.00'],
['item_id'=>'33','codigo'=>'153400914','nombre'=>'Filmadores semiprofesionales individuales comerciales (carnaval)             ','monto'=>'880.00 '],
['item_id'=>'33','codigo'=>'153400915','nombre'=>'Equipos fotográficos profesionales (carnaval)                                ','monto'=>'201.00 '],
['item_id'=>'33','codigo'=>'153400916','nombre'=>'Equipos fotográficos semiprofesionales (carnaval)                            ','monto'=>'91.00  '],
['item_id'=>'33','codigo'=>'153400917','nombre'=>'Empresas televisivas comerciales de alcance Nacional e Int. (carnaval)       ','monto'=>'2090.00'],
['item_id'=>'33','codigo'=>'153400918','nombre'=>'Empresas televisivas comerciales de alcance local (carnaval)                 ','monto'=>'522.00 '],
['item_id'=>'33','codigo'=>'153400919','nombre'=>'Organizaciones televisivas institucionales y comunitarias (carnaval)         ','monto'=>'216.00 '],
['item_id'=>'33','codigo'=>'153400920','nombre'=>'Bailes en fechas especiales con conjuntos nacionales                         ','monto'=>'314.00 '],
['item_id'=>'33','codigo'=>'153400921','nombre'=>'Bailes en fechas especiales con conjuntos internacionales                    ','monto'=>'523.00 '],
['item_id'=>'33','codigo'=>'153400922','nombre'=>'Bailes en fechas especiales amplificación                                    ','monto'=>'287.00 '],
['item_id'=>'33','codigo'=>'153400923','nombre'=>'Bailes en fechas ordinarias con conjuntos nacionales                         ','monto'=>'287.00 '],
['item_id'=>'33','codigo'=>'153400924','nombre'=>'Bailes en fechas ordinarias con conjuntos internacionales                    ','monto'=>'314.00 '],
['item_id'=>'33','codigo'=>'153400925','nombre'=>'Balie en fechas ordinarias (nocturno) amplif. coleg (19:30 a 22:30)          ','monto'=>'157.00 '],
['item_id'=>'33','codigo'=>'153400926','nombre'=>'Baile en fechas ordinaraias matine amplif. coleg(14:30 a 19:00)              ','monto'=>'105.00 '],
['item_id'=>'33','codigo'=>'153400927','nombre'=>'Baile en fechas ordinarias con amplif. p. univ. y particulares               ','monto'=>'217.00 '],
['item_id'=>'33','codigo'=>'153400928','nombre'=>'Espectáculos teatrales internacionales por función                           ','monto'=>'105.00 '],
['item_id'=>'33','codigo'=>'153400929','nombre'=>'Espectáculos teatrales nacionales por función                                ','monto'=>'63.00  '],
['item_id'=>'33','codigo'=>'153400930','nombre'=>'Peña con grupo folklorico musicales                                          ','monto'=>'157.00 '],
['item_id'=>'33','codigo'=>'153400931','nombre'=>'conciertos                                                                   ','monto'=>'157.00 '],
['item_id'=>'33','codigo'=>'153400932','nombre'=>'Kermésse                                                                     ','monto'=>'157.00 '],
['item_id'=>'33','codigo'=>'153400933','nombre'=>'Patente por cada función circo internacional (grande)                        ','monto'=>'78.00  '],
['item_id'=>'33','codigo'=>'153400934','nombre'=>'Patente por cada función circo pequeño                                       ','monto'=>'55.00  '],
['item_id'=>'33','codigo'=>'153400935','nombre'=>'Parque de diversión por aparato grande                                       ','monto'=>'78.00  '],
['item_id'=>'33','codigo'=>'153400936','nombre'=>'Parque de diversión por aparato pequeño                                      ','monto'=>'38.00  '],
['item_id'=>'33','codigo'=>'153400937','nombre'=>'Electrónicos por aparato                                                     ','monto'=>'19.00  '],
['item_id'=>'33','codigo'=>'153400938','nombre'=>'Ataris por aparato                                                           ','monto'=>'11.00  '],
['item_id'=>'33','codigo'=>'153400939','nombre'=>'Play Station II por aparato                                                  ','monto'=>'19.00  '],
['item_id'=>'33','codigo'=>'153400940','nombre'=>'Play Station por aparato                                                     ','monto'=>'11.00  '],
['item_id'=>'33','codigo'=>'153400941','nombre'=>'Juegos en red por computadora                                                ','monto'=>'11.00  '],
['item_id'=>'33','codigo'=>'153400942','nombre'=>'Salon de billar por mesa                                                     ','monto'=>'11.00  '],
['item_id'=>'33','codigo'=>'153400943','nombre'=>'Futbolines por aparato                                                       ','monto'=>'6.00   '],
['item_id'=>'33','codigo'=>'153400944','nombre'=>'Carrusel grande a motor                                                      ','monto'=>'55.00  '],
['item_id'=>'33','codigo'=>'153400945','nombre'=>'Carrusel manual pequeño                                                      ','monto'=>'38.00  '],
['item_id'=>'33','codigo'=>'153400946','nombre'=>'Ataris con bailadora y rockola                                               ','monto'=>'21.00  '],
['item_id'=>'33','codigo'=>'153400947','nombre'=>'Letrero luminoso de dos caras x 2 m² anual                                   ','monto'=>'40.00  '],
['item_id'=>'33','codigo'=>'153400948','nombre'=>'Letrero luminoso de una cara x 2 m² anual                                    ','monto'=>'21.00  '],
['item_id'=>'33','codigo'=>'153400949','nombre'=>'Letrero plancha y banner de dos caras x 2 m² anual                           ','monto'=>'23.00  '],
['item_id'=>'33','codigo'=>'153400950','nombre'=>'Letrero plancha y banner de una cara x 2 m² anual                            ','monto'=>'12.00  '],
['item_id'=>'33','codigo'=>'153400951','nombre'=>'Letrero de una cara banner                                                   ','monto'=>'12.00  '],
['item_id'=>'33','codigo'=>'153400952','nombre'=>'Murales x 2 m² una cara                                                      ','monto'=>'12.00  '],
['item_id'=>'33','codigo'=>'153400953','nombre'=>'Gigantografía x 2 m² una cara                                                ','monto'=>'12.00  '],
['item_id'=>'33','codigo'=>'153400954','nombre'=>'Gigantografía x 2 m² dos cara                                                ','monto'=>'23.00  '],
['item_id'=>'33','codigo'=>'153400955','nombre'=>'Pasacalles                                                                   ','monto'=>'21.00  '],
['item_id'=>'33','codigo'=>'153400956','nombre'=>'Pancartas transversal por dia el m²                                          ','monto'=>'6.00   '],
['item_id'=>'33','codigo'=>'153400957','nombre'=>'Publicidad movil con patente por hora                                        ','monto'=>'6.00   '],
['item_id'=>'33','codigo'=>'153400958','nombre'=>'Afiches x m²                                                                 ','monto'=>'6.00   '],
['item_id'=>'33','codigo'=>'153400959','nombre'=>'Juegos inflables                                                             ','monto'=>'36.00  '],
['item_id'=>'33','codigo'=>'153400960','nombre'=>'Cochecitos a bateria                                                         ','monto'=>'12.00  '],
['item_id'=>'33','codigo'=>'153400961','nombre'=>'Cochecitos a pedal                                                           ','monto'=>'11.00  '],
['item_id'=>'33','codigo'=>'153400962','nombre'=>'Juego tiro al banco, lota, otros 4x4 feria norte                             ','monto'=>'24.00  '],
['item_id'=>'33','codigo'=>'153400963','nombre'=>'Juegos al azar con espacio de 1x1 feria norte                                ','monto'=>'5.00   '],
['item_id'=>'33','codigo'=>'153400964','nombre'=>'Otros juegos recreativos con espacio de 1.5x1.5 feria norte                  ','monto'=>'19.00  '],
['item_id'=>'33','codigo'=>'153400965','nombre'=>'Futbolines por cada mesa feria norte                                         ','monto'=>'6.00   '],
['item_id'=>'33','codigo'=>'153400966','nombre'=>'Carruseles por espacio ocupado de 4x4 feria norte                            ','monto'=>'270.00 '],
['item_id'=>'33','codigo'=>'153400967','nombre'=>'Carruseles por cada aparato con espacio menor de 3x3 feria norte             ','monto'=>'70.00  '],
['item_id'=>'33','codigo'=>'153400968','nombre'=>'Por cada carrito feria norte                                                 ','monto'=>'6.00   '],
['item_id'=>'33','codigo'=>'153400969','nombre'=>'Juegos inflables, camas elasticas feria norte                                ','monto'=>'38.00  '],
['item_id'=>'33','codigo'=>'153400970','nombre'=>'Por cada carrito a motor y motos feria norte                                 ','monto'=>'10.00  '],
['item_id'=>'33','codigo'=>'153400971','nombre'=>'Carrusel por aparato manual feria norte                                      ','monto'=>'36.00  '],
['item_id'=>'33','codigo'=>'153400972','nombre'=>'Juego tiro al banco, lota, otros 4x4 feria sud                               ','monto'=>'12.00  '],
['item_id'=>'33','codigo'=>'153400973','nombre'=>'Otros juegos recreativos con espacio de 1.5x1.5 feria sud                    ','monto'=>'12.00  '],
['item_id'=>'33','codigo'=>'153400974','nombre'=>'Futbolines por mesa feria sud                                                ','monto'=>'6.00   '],
['item_id'=>'33','codigo'=>'153400975','nombre'=>'Carruseles por espacio ocupado de 4x4 feria sud                              ','monto'=>'150.00 '],
['item_id'=>'33','codigo'=>'153400976','nombre'=>'Carruseles por cada aparato con espacio menor de 3x3 feria sud               ','monto'=>'31.00  '],
['item_id'=>'33','codigo'=>'153400977','nombre'=>'Por cada carrito feria sud                                                   ','monto'=>'6.00   '],
['item_id'=>'33','codigo'=>'153400978','nombre'=>'Juegos inflables por juego feria sud                                         ','monto'=>'38.00  '],
['item_id'=>'33','codigo'=>'153400979','nombre'=>'Carritos a motor y motos                                                     ','monto'=>'10.00  '],
['item_id'=>'33','codigo'=>'153400980','nombre'=>'Gigantografía Publicitaria plaza,principal y Av. Civica (Carnaval)           ','monto'=>'1920.00'],
['item_id'=>'33','codigo'=>'153400981','nombre'=>'Globos publicitario fijos o flotantes plaza principal y Av. civica (carnaval)','monto'=>'1920.00'],
['item_id'=>'33','codigo'=>'153400982','nombre'=>'Publicidad Televisiva mediante pantalla LED (Carnaval)                       ','monto'=>'1920.00'],
['item_id'=>'33','codigo'=>'153400983','nombre'=>'Lota, bingo, tiro al blanco y otros sup hasta 4 x 4 mts (calvario)           ','monto'=>'158.00 '],
['item_id'=>'33','codigo'=>'153400984','nombre'=>'Carruseles grandes (calvario)                                                ','monto'=>'421.00 '],
['item_id'=>'33','codigo'=>'153400985','nombre'=>'Carruseles pequeños (calvario)                                               ','monto'=>'153.00 '],
['item_id'=>'33','codigo'=>'153400986','nombre'=>'Futbolines por mesa (calvario)                                               ','monto'=>'20.00  '],
['item_id'=>'33','codigo'=>'153400987','nombre'=>'Cochecitos a motor y bateria c/u Bs. 52 (calvario)                           ','monto'=>'52.00  '],
['item_id'=>'33','codigo'=>'153400988','nombre'=>'Cochecitos a pedal c/u Bs. 28 (Calvario)                                     ','monto'=>'28.00  '],

        ]);
    }
}
