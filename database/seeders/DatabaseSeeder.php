<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Reserve;
use App\Models\Type;
use App\Models\User;
use App\Models\Vacation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ──────────────────────────────────────────────
        // Tipos
        // ──────────────────────────────────────────────
        $types = [
            'Playa',        // 1
            'Crucero',      // 2
            'Montaña',      // 3
            'Ciudad',       // 4
            'Safari',       // 5
            'Aventura',     // 6
            'Relax & Spa',  // 7
            'Cultural',     // 8
            'Gastronómico', // 9
            'Familiar',     // 10
        ];

        foreach ($types as $name) {
            Type::create(['name' => $name]);
        }

        // ──────────────────────────────────────────────
        // Usuarios
        // ──────────────────────────────────────────────
        $admin = User::updateOrCreate(
            ['email' => 'admin@vacaciones.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'rol' => 'admin',
            ]
        );

        $advanced = User::updateOrCreate(
            ['email' => 'advanced@vacaciones.com'],
            [
                'name' => 'Gestor Avanzado',
                'password' => Hash::make('password'),
                'rol' => 'advanced',
            ]
        );

        $advanced2 = User::updateOrCreate(
            ['email' => 'advanced2@vacaciones.com'],
            [
                'name' => 'Gestora Premium',
                'password' => Hash::make('password'),
                'rol' => 'advanced',
            ]
        );

        $normal = User::updateOrCreate(
            ['email' => 'cliente@vacaciones.com'],
            [
                'name' => 'Cliente Normal',
                'password' => Hash::make('password'),
                'rol' => 'normal',
            ]
        );

        $normal2 = User::updateOrCreate(
            ['email' => 'maria@vacaciones.com'],
            [
                'name' => 'María García',
                'password' => Hash::make('password'),
                'rol' => 'normal',
            ]
        );

        $normal3 = User::updateOrCreate(
            ['email' => 'carlos@vacaciones.com'],
            [
                'name' => 'Carlos López',
                'password' => Hash::make('password'),
                'rol' => 'normal',
            ]
        );

        // ──────────────────────────────────────────────
        // Paquetes vacacionales
        // ──────────────────────────────────────────────
        $vacations = [

            // PLAYA (1)
            [
                'title'       => 'Playas del Caribe',
                'description' => 'Descubre las paradisíacas playas del Caribe con arena blanca y aguas cristalinas. Régimen todo incluido con actividades acuáticas, shows nocturnos y gastronomía local.',
                'price'       => 1499.99,
                'id_type'     => 1,
                'country'     => 'República Dominicana',
            ],
            [
                'title'       => 'Maldivas de Ensueño',
                'description' => 'Alójate en un bungalow sobre el agua en las Maldivas. Snorkel, buceo y puestas de sol inolvidables en el océano Índico. Vuelo directo incluido.',
                'price'       => 3999.00,
                'id_type'     => 1,
                'country'     => 'Maldivas',
            ],
            [
                'title'       => 'Costa Tropical de Tailandia',
                'description' => 'Las playas de Krabi y Ko Phi Phi te esperan con sus aguas turquesa y acantilados de piedra caliza. Incluye excursiones en lancha y clases de cocina thai.',
                'price'       => 1899.00,
                'id_type'     => 1,
                'country'     => 'Tailandia',
            ],
            [
                'title'       => 'Cancún Todo Incluido',
                'description' => 'Resort 5 estrellas frente al mar en la Zona Hotelera de Cancún. Piscinas infinity, buffet internacional, deportes acuáticos y excursión a Chichén Itzá.',
                'price'       => 1699.00,
                'id_type'     => 1,
                'country'     => 'México',
            ],
            [
                'title'       => 'Playas Vírgenes de Mozambique',
                'description' => 'Escápate a las playas más vírgenes del Índico. Arrecifes de coral, tortugas marinas y una cultura local única. Perfecto para los amantes del buceo.',
                'price'       => 2199.00,
                'id_type'     => 1,
                'country'     => 'Mozambique',
            ],

            // CRUCERO (2)
            [
                'title'       => 'Crucero por el Mediterráneo',
                'description' => 'Navega por los puertos más emblemáticos del Mediterráneo a bordo de un lujoso crucero. Roma, Atenas, Santorini y Barcelona en un solo viaje.',
                'price'       => 2299.00,
                'id_type'     => 2,
                'country'     => 'Italia',
            ],
            [
                'title'       => 'Crucero por los Fiordos Noruegos',
                'description' => 'Contempla la majestuosidad de los fiordos noruegos desde cubierta. Auroras boreales, cascadas y pueblos de colores. Una experiencia única en el norte de Europa.',
                'price'       => 2799.00,
                'id_type'     => 2,
                'country'     => 'Noruega',
            ],
            [
                'title'       => 'Crucero por el Caribe',
                'description' => 'Visita Jamaica, Bahamas, Cozumel y las Islas Vírgenes a bordo de un crucero todo incluido. Piscinas, casino, espectáculos y restaurantes de alta cocina.',
                'price'       => 1999.00,
                'id_type'     => 2,
                'country'     => 'Bahamas',
            ],
            [
                'title'       => 'Crucero por Alaska',
                'description' => 'Glaciares, orcas y paisajes salvajes desde la comodidad de un crucero de lujo. Excursiones a tierra en Juneau, Ketchikan y Skagway incluidas.',
                'price'       => 3299.00,
                'id_type'     => 2,
                'country'     => 'Estados Unidos',
            ],

            // MONTAÑA (3)
            [
                'title'       => 'Los Alpes Suizos en Invierno',
                'description' => 'Esquí, snowboard y gastronomía de altura en los Alpes suizos. Forfait de 7 días, alojamiento en cabaña de madera y clases de esquí para todos los niveles.',
                'price'       => 2599.00,
                'id_type'     => 3,
                'country'     => 'Suiza',
            ],
            [
                'title'       => 'Trekking en el Himalaya',
                'description' => 'Ruta al campo base del Everest de 14 días. Guías expertos, equipo de alta montaña, aclimatación progresiva y vistas incomparables del techo del mundo.',
                'price'       => 4200.00,
                'id_type'     => 3,
                'country'     => 'Nepal',
            ],
            [
                'title'       => 'Pirineos en Otoño',
                'description' => 'Senderismo entre valles y cumbres pirenaicas con colores otoñales. Alojamiento en refugios de montaña, gastronomía aragonesa y rutas para todos los niveles.',
                'price'       => 699.00,
                'id_type'     => 3,
                'country'     => 'España',
            ],
            [
                'title'       => 'Patagonia Salvaje',
                'description' => 'Trekking por el Parque Nacional Torres del Paine. Glaciares azules, cóndores y paisajes al fin del mundo. Incluye equipo técnico y guía certificado.',
                'price'       => 3100.00,
                'id_type'     => 3,
                'country'     => 'Chile',
            ],

            // CIUDAD (4)
            [
                'title'       => 'Nueva York en 7 días',
                'description' => 'La Gran Manzana te espera: Times Square, Central Park, los museos, Broadway y la gastronomía más diversa del mundo. Hotel en Manhattan incluido.',
                'price'       => 2100.00,
                'id_type'     => 4,
                'country'     => 'Estados Unidos',
            ],
            [
                'title'       => 'Tokio y Kioto Express',
                'description' => 'Sumérgete en el contraste entre la Tokio ultramoderna y la Kioto tradicional. Templos, mercados, sushi auténtico y la experiencia del tren bala.',
                'price'       => 2800.00,
                'id_type'     => 4,
                'country'     => 'Japón',
            ],
            [
                'title'       => 'París Romántico',
                'description' => 'La ciudad del amor en todo su esplendor: Torre Eiffel, Louvre, Montmartre y crucero por el Sena. Hotel boutique en el Barrio Latino incluido.',
                'price'       => 1350.00,
                'id_type'     => 4,
                'country'     => 'Francia',
            ],
            [
                'title'       => 'Dubái Futurista',
                'description' => 'El lujo sin límites en Dubái: Burj Khalifa, desierto en 4x4, souks tradicionales y las mejores playas artificiales del mundo. Hotel 5 estrellas incluido.',
                'price'       => 2450.00,
                'id_type'     => 4,
                'country'     => 'Emiratos Árabes',
            ],

            // SAFARI (5)
            [
                'title'       => 'Safari en Kenya',
                'description' => 'Vive la experiencia de observar los Big Five en el Masái Mara. Incluye guía experto, vehículo 4x4, alojamiento en lodge y vuelos internos.',
                'price'       => 3500.00,
                'id_type'     => 5,
                'country'     => 'Kenya',
            ],
            [
                'title'       => 'Safari en Tanzania y Zanzíbar',
                'description' => 'El Serengeti y el Ngorongoro combinados con una semana de relax en las playas de Zanzíbar. La combinación perfecta de aventura y descanso.',
                'price'       => 4100.00,
                'id_type'     => 5,
                'country'     => 'Tanzania',
            ],
            [
                'title'       => 'Safari Fotográfico en Botswana',
                'description' => 'El delta del Okavango desde una lancha y a pie. Safari nocturno, guías especializados en fotografía de naturaleza y alojamiento en tiendas de lujo.',
                'price'       => 4800.00,
                'id_type'     => 5,
                'country'     => 'Botswana',
            ],

            // AVENTURA (6)
            [
                'title'       => 'Ruta por la Amazonía',
                'description' => 'Expedición de 10 días por la selva amazónica brasileña. Canoa, senderismo nocturno, avistamiento de delfines rosados y convivencia con comunidades indígenas.',
                'price'       => 2600.00,
                'id_type'     => 6,
                'country'     => 'Brasil',
            ],
            [
                'title'       => 'Aventura en Nueva Zelanda',
                'description' => 'Bungee jumping, rafting, parapente y senderismo en el país de los kiwis. Queenstown como base de operaciones para los deportes de aventura más extremos.',
                'price'       => 3200.00,
                'id_type'     => 6,
                'country'     => 'Nueva Zelanda',
            ],
            [
                'title'       => 'Islandia: Tierra de Fuego y Hielo',
                'description' => 'Auroras boreales, géiseres, volcanes y cascadas. Ruta en 4x4 por el interior de Islandia con guía experto y alojamiento en cabañas con vistas al cielo nocturno.',
                'price'       => 2900.00,
                'id_type'     => 6,
                'country'     => 'Islandia',
            ],

            // RELAX & SPA (7)
            [
                'title'       => 'Retiro de Bienestar en Bali',
                'description' => 'Yoga al amanecer, masajes balineses, meditación y alimentación saludable en un resort de lujo rodeado de arrozales. Desconexión total garantizada.',
                'price'       => 1800.00,
                'id_type'     => 7,
                'country'     => 'Indonesia',
            ],
            [
                'title'       => 'Termas y Spa en Islandia',
                'description' => 'La Laguna Azul y los baños geotérmicos más famosos del mundo. Tratamientos de lodo volcánico, masajes y cenas gourmet con vistas a las auroras.',
                'price'       => 1950.00,
                'id_type'     => 7,
                'country'     => 'Islandia',
            ],
            [
                'title'       => 'Wellness en Toscana',
                'description' => 'Masajes con aceite de oliva, vinoterapia y aguas termales en la campiña toscana. Alojamiento en villa histórica, cocina italiana y degustación de vinos locales.',
                'price'       => 2200.00,
                'id_type'     => 7,
                'country'     => 'Italia',
            ],

            // CULTURAL (8)
            [
                'title'       => 'Marruecos Imperial',
                'description' => 'Las cuatro ciudades imperiales: Fez, Meknes, Marrakech y Rabat. Zocos, mezquitas, palacios y el desierto del Sahara. Un viaje al corazón de la cultura bereber.',
                'price'       => 1100.00,
                'id_type'     => 8,
                'country'     => 'Marruecos',
            ],
            [
                'title'       => 'Perú: Machu Picchu y el Camino Inca',
                'description' => 'La ciudadela inca más famosa del mundo precedida por 4 días de trekking por el Camino Inca. Cusco, el Valle Sagrado y el lago Titicaca completan la ruta.',
                'price'       => 2750.00,
                'id_type'     => 8,
                'country'     => 'Perú',
            ],
            [
                'title'       => 'Grecia Clásica',
                'description' => 'Atenas, Delfos, Olimpia, Micenas y Epidauro. Un recorrido por los orígenes de la civilización occidental con guía arqueólogo y alojamiento en hoteles históricos.',
                'price'       => 1650.00,
                'id_type'     => 8,
                'country'     => 'Grecia',
            ],
            [
                'title'       => 'India Sagrada',
                'description' => 'Delhi, Agra, Jaipur y Varanasi en el triángulo dorado indio. El Taj Mahal al amanecer, cremaciones en el Ganges y el caos sagrado de los bazares.',
                'price'       => 1950.00,
                'id_type'     => 8,
                'country'     => 'India',
            ],

            // GASTRONÓMICO (9)
            [
                'title'       => 'Ruta Gastronómica por Italia',
                'description' => 'Pasta en Bolonia, pizza en Nápoles, trufas en Umbría y gelato en Florencia. Clases de cocina, visitas a productores y cenas en restaurantes con estrella Michelin.',
                'price'       => 1750.00,
                'id_type'     => 9,
                'country'     => 'Italia',
            ],
            [
                'title'       => 'San Sebastián y el País Vasco Gastronómico',
                'description' => 'La capital mundial de los pintxos. Visitas a sidrerías, bodegas de txakoli, mercados de San Telmo y cena en uno de los mejores restaurantes del mundo.',
                'price'       => 950.00,
                'id_type'     => 9,
                'country'     => 'España',
            ],
            [
                'title'       => 'Ruta de los Vinos en Burdeos',
                'description' => 'Châteaux históricos, bodegas centenarias y catas de los mejores vinos del mundo en la región vinícola más prestigiosa de Francia. Alojamiento en château incluido.',
                'price'       => 1450.00,
                'id_type'     => 9,
                'country'     => 'Francia',
            ],

            // FAMILIAR (10)
            [
                'title'       => 'Orlando: Disney y Mucho Más',
                'description' => 'Walt Disney World, Universal Studios y SeaWorld en un paquete familiar completo. Hotel en el resort, bonos de acceso ilimitado y traslados incluidos.',
                'price'       => 3200.00,
                'id_type'     => 10,
                'country'     => 'Estados Unidos',
            ],
            [
                'title'       => 'Costa Rica en Familia',
                'description' => 'Volcanes, tortugas, tirolinas y playas en el paraíso centroamericano. Perfecto para familias aventureras: canopy, avistamiento de aves y baños en aguas termales.',
                'price'       => 2400.00,
                'id_type'     => 10,
                'country'     => 'Costa Rica',
            ],
            [
                'title'       => 'Laponia Mágica en Navidad',
                'description' => 'Conoce a Papá Noel en Rovaniemi, monta en trineo de renos, duerme en un iglú y busca auroras boreales con los niños. Un sueño navideño hecho realidad.',
                'price'       => 2850.00,
                'id_type'     => 10,
                'country'     => 'Finlandia',
            ],
            [
                'title'       => 'Parques Naturales de Kenia en Familia',
                'description' => 'Safari adaptado para familias con niños: vehículos especiales, guías con experiencia con menores y lodge con piscina. Ver leones con tus hijos, una experiencia para toda la vida.',
                'price'       => 3600.00,
                'id_type'     => 10,
                'country'     => 'Kenya',
            ],
        ];

        $createdVacations = [];

        foreach ($vacations as $data) {
						$createdVacations[] = Vacation::updateOrCreate(
								['title' => $data['title']],
								$data
						);
				}

        // ──────────────────────────────────────────────
        // Reservas de ejemplo
        // ──────────────────────────────────────────────
        $reserves = [
            ['id_user' => $normal->id,  'id_vacation' => $createdVacations[0]->id],
            ['id_user' => $normal->id,  'id_vacation' => $createdVacations[5]->id],
            ['id_user' => $normal->id,  'id_vacation' => $createdVacations[17]->id],
            ['id_user' => $normal2->id, 'id_vacation' => $createdVacations[1]->id],
            ['id_user' => $normal2->id, 'id_vacation' => $createdVacations[13]->id],
            ['id_user' => $normal2->id, 'id_vacation' => $createdVacations[24]->id],
            ['id_user' => $normal3->id, 'id_vacation' => $createdVacations[8]->id],
            ['id_user' => $normal3->id, 'id_vacation' => $createdVacations[20]->id],
        ];

        foreach ($reserves as $data) {
            Reserve::create($data);
        }

        // ──────────────────────────────────────────────
        // Comentarios de ejemplo (solo usuarios con reserva)
        // ──────────────────────────────────────────────
        $comments = [
            [
                'id_user'     => $normal->id,
                'id_vacation' => $createdVacations[0]->id,
                'text'        => 'Una experiencia increíble. Las playas son exactamente como en las fotos, el personal del resort muy amable y la comida excelente. Repetiré sin duda.',
            ],
            [
                'id_user'     => $normal->id,
                'id_vacation' => $createdVacations[5]->id,
                'text'        => 'El crucero superó todas mis expectativas. Las paradas en Santorini y Roma fueron espectaculares. El camarote era cómodo y la comida a bordo muy variada.',
            ],
            [
                'id_user'     => $normal->id,
                'id_vacation' => $createdVacations[17]->id,
                'text'        => 'Ver los Big Five en libertad es algo que no olvidaré jamás. El guía era un experto y el lodge tenía unas vistas al atardecer impresionantes.',
            ],
            [
                'id_user'     => $normal2->id,
                'id_vacation' => $createdVacations[1]->id,
                'text'        => 'Maldivas es un paraíso terrenal. El bungalow sobre el agua era de ensueño y el snorkel entre los arrecifes de coral fue lo mejor del viaje.',
            ],
            [
                'id_user'     => $normal2->id,
                'id_vacation' => $createdVacations[13]->id,
                'text'        => 'Nueva York me dejó sin palabras. Siete días se quedan cortos para ver todo. El hotel en Manhattan era perfecto, bien ubicado y muy cómodo.',
            ],
            [
                'id_user'     => $normal3->id,
                'id_vacation' => $createdVacations[8]->id,
                'text'        => 'Los Alpes en invierno son una maravilla. Las pistas de esquí estaban en perfectas condiciones y la cabaña era acogedora y calentita. Muy recomendable.',
            ],
            [
                'id_user'     => $normal3->id,
                'id_vacation' => $createdVacations[20]->id,
                'text'        => 'Bali es magia pura. El retiro de yoga me cambió la perspectiva. Los masajes balineses son los mejores que he probado y la comida saludable estaba deliciosa.',
            ],
        ];

        foreach ($comments as $data) {
            Comment::updateOrCreate(
                [
                    'id_user' => $data['id_user'],
                    'id_vacation' => $data['id_vacation'],
                ],
                [
                    'text' => $data['text'],
                ]
            );
        }
    }
}