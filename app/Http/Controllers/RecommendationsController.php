<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RecommendationsController extends Controller
{
    protected $cities = [
        // --- Exploration destinations ---
        [
            'name'        => 'Riga',
            'county'      => 'Latvia',
            'image'       => '/images/riga.jpg',
            'description' => 'Riga offers a mix of historical architecture and modern culture. It is ideal for those who love exploring urban history and art. This vibrant city is known for its Art Nouveau architecture and lively cultural scene.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Tallinn',
            'county'      => 'Estonia',
            'image'       => '/images/tallinn.jpg',
            'description' => 'Tallinn features a charming medieval old town that invites you to explore cobbled streets and centuries-old architecture. The city is steeped in history and offers plenty of museums and galleries.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Rome',
            'county'      => 'Italy',
            'image'       => '/images/rome.jpg',
            'description' => 'Rome is a treasure trove of history, art, and culture – a must for explorers. Ancient ruins, magnificent churches, and world-class museums are scattered throughout the city.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Munich',
            'county'      => 'Germany',
            'image'       => '/images/munich.jpg',
            'description' => 'Munich blends modernity with traditional Bavarian culture. Great for exploring city life and nearby nature, and known for its beer gardens and historic buildings.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Nuremberg',
            'county'      => 'Germany',
            'image'       => '/images/nuremberg.jpg',
            'description' => 'Nuremberg boasts medieval architecture and museums, perfect for history buffs looking to dive into the past.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Paris',
            'county'      => 'France',
            'image'       => '/images/paris.jpg',
            'description' => 'Paris is renowned for its art, museums, and historical landmarks – a top exploration destination. Experience the charm of its boulevards and iconic monuments.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Madrid',
            'county'      => 'Spain',
            'image'       => '/images/madrid.jpg',
            'description' => 'Madrid is rich in art and culture with world-class museums and vibrant streets, making it ideal for exploration.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'London',
            'county'      => 'United Kingdom',
            'image'       => '/images/london.jpg',
            'description' => 'London offers iconic landmarks, historical sites, and an eclectic mix of culture. Explore its museums, markets, and historic neighborhoods.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Dublin',
            'county'      => 'Ireland',
            'image'       => '/images/dublin.jpg',
            'description' => 'Dublin features lively culture and historic sites. Enjoy the friendly atmosphere and rich literary history of the city.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Athens',
            'county'      => 'Greece',
            'image'       => '/images/athens.jpg',
            'description' => 'Athens is steeped in ancient history and offers breathtaking archaeological sites. Visit the Acropolis and other ancient landmarks.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Praha',
            'county'      => 'Czech Republic',
            'image'       => '/images/praha.jpg',
            'description' => 'Prague charms with its enchanting architecture and historic ambiance, perfect for immersive exploration. Its fairytale streets and bridges create a magical atmosphere.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Warsaw',
            'county'      => 'Poland',
            'image'       => '/images/warsaw.jpg',
            'description' => 'Warsaw blends modernity with a deep historical past, offering cultural depth and engaging urban exploration.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Zagreb',
            'county'      => 'Croatia',
            'image'       => '/images/zagreb.jpg',
            'description' => 'Zagreb is a vibrant cultural hub with a rich history that appeals to curious travelers and those looking to explore local traditions.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Vienna',
            'county'      => 'Austria',
            'image'       => '/images/vienna.jpg',
            'description' => 'Vienna is known for its imperial history, music, and art. Experience its majestic palaces, museums, and historic cafes.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Istanbul',
            'county'      => 'Turkey',
            'image'       => '/images/istanbul.jpg',
            'description' => 'Istanbul straddles two continents and offers a rich tapestry of history and culture. Explore its bazaars, ancient mosques, and vibrant neighborhoods.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Sofia',
            'county'      => 'Bulgaria',
            'image'       => '/images/sofia.jpg',
            'description' => 'Sofia combines historical architecture with modern influences, offering a balanced experience for cultural explorers.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Bratislava',
            'county'      => 'Slovakia',
            'image'       => '/images/bratislava.jpg',
            'description' => 'Bratislava offers quaint charm and historical sites in a compact setting, making it ideal for short exploratory visits.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Timisoara',
            'county'      => 'Romania',
            'image'       => '/images/timisoara.jpg',
            'description' => 'Timisoara is known for its vibrant cultural scene and historical significance, perfect for the curious traveler.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Cluj-Napoca',
            'county'      => 'Romania',
            'image'       => '/images/cluj.jpg',
            'description' => 'Cluj-Napoca boasts a youthful vibe and rich cultural heritage, making it an attractive destination for those seeking to explore.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Hamburg',
            'county'      => 'Germany',
            'image'       => '/images/hamburg.jpg',
            'description' => 'Hamburg is a major port city that blends modern attractions with historical charm for an engaging exploration experience.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Berlin',
            'county'      => 'Germany',
            'image'       => '/images/berlin.jpg',
            'description' => 'Berlin is famous for its history, art, and vibrant cultural scene, offering endless opportunities for exploration.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Bucharest',
            'county'      => 'Romania',
            'image'       => '/images/bucharest.jpg',
            'description' => 'Bucharest offers a mix of modern urban vibrancy and rich historical heritage, with impressive architecture and a lively cultural scene.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Krakow',
            'county'      => 'Poland',
            'image'       => '/images/krakow.jpg',
            'description' => 'Krakow offers a deep historical experience with its well-preserved old town and cultural heritage, ideal for explorative visits.',
            'category'    => 'exploration'
        ],
        [
            'name'        => 'Thessaloniki',
            'county'      => 'Greece',
            'image'       => '/images/thessaloniki.jpg',
            'description' => 'Thessaloniki offers a blend of ancient history and modern vibrancy, making it a compelling destination for explorers.',
            'category'    => 'exploration'
        ],

        // --- Leisure destinations ---
        [
            'name'        => 'Barcelona',
            'county'      => 'Spain',
            'image'       => '/images/barcelona.jpg',
            'description' => 'Barcelona features beautiful beaches, vibrant culture, and a relaxed atmosphere – perfect for a leisure getaway. Enjoy the Mediterranean vibe, outdoor cafes, and lively arts scene.',
            'category'    => 'leisure'
        ],
        [
            'name'        => 'Oslo',
            'county'      => 'Norway',
            'image'       => '/images/oslo.jpg',
            'description' => 'Oslo is surrounded by stunning fjords and nature, offering a peaceful escape with modern comforts and opportunities for outdoor leisure activities.',
            'category'    => 'leisure'
        ],
        [
            'name'        => 'Stockholm',
            'county'      => 'Sweden',
            'image'       => '/images/stockholm.jpg',
            'description' => 'Stockholm is built on islands, offering scenic views and a blend of modernity and nature – perfect for a leisurely experience.',
            'category'    => 'leisure'
        ],
        [
            'name'        => 'Budapest',
            'county'      => 'Hungary',
            'image'       => '/images/budapest.jpg',
            'description' => 'Budapest is famed for its thermal baths and stunning architecture – an excellent choice for relaxation and leisure.',
            'category'    => 'leisure'
        ],
        [
            'name'        => 'Nice',
            'county'      => 'France',
            'image'       => '/images/nice.jpg',
            'description' => 'Nice is renowned for its Mediterranean coastline and relaxed resort vibe – ideal for leisure travelers looking to soak up the sun.',
            'category'    => 'leisure'
        ],
        [
            'name'        => 'Lisbon',
            'county'      => 'Portugal',
            'image'       => '/images/lisbon.jpg',
            'description' => 'Lisbon offers scenic coastlines, vibrant neighborhoods, and a laid-back lifestyle – a top destination for leisure seekers.',
            'category'    => 'leisure'
        ],
        [
            'name'        => 'Varna',
            'county'      => 'Bulgaria',
            'image'       => '/images/varna.jpg',
            'description' => 'Varna is a coastal city known for its beaches and vibrant seaside culture – perfect for unwinding and enjoying a relaxed holiday.',
            'category'    => 'leisure'
        ],
        [
            'name'        => 'Palermo',
            'county'      => 'Italy',
            'image'       => '/images/palermo.jpg',
            'description' => 'Palermo boasts Mediterranean charm and coastal allure, offering a delightful mix of history, food, and leisure.',
            'category'    => 'leisure'
        ],
        [
            'name'        => 'Reykjavik',
            'county'      => 'Iceland',
            'image'       => '/images/reykjavik.jpg',
            'description' => 'Reykjavik is known for its dramatic landscapes and unique Nordic charm, providing a refreshing and serene leisure experience.',
            'category'    => 'leisure'
        ],
        [
            'name'        => 'Malta',
            'county'      => 'Malta',
            'image'       => '/images/malta.jpg',
            'description' => 'Malta offers a blend of history and stunning beaches – an ideal destination for those looking to relax and enjoy leisure time.',
            'category'    => 'leisure'
        ],
    ];

    public function index(Request $request)
    {
        // Get the trip type from the query parameters (default to 'leisure')
        $tripType = $request->input('trip_type', 'leisure');

        // Filter cities based on the selected trip type
        $filteredCities = array_filter($this->cities, function ($city) use ($tripType) {
            return strtolower($city['category']) === strtolower($tripType);
        });

        return view('recommendations', [
            'trip_type' => $tripType,
            'cities'    => $filteredCities
        ]);
    }
}
