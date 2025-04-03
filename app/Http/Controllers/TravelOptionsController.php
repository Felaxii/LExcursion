<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AmadeusService;

class TravelOptionsController extends Controller
{
    /**
     * Display the travel options page.
     *
     * @param  Request  $request
     * @param  AmadeusService  $amadeus
     * @return \Illuminate\View\View
     */
    public function show(Request $request, AmadeusService $amadeus)
    {
        $city = $request->query('city', 'Unknown');
        $departureDate = $request->query('date', date('Y-m-d'));
        $passengers = $request->query('travelers', 1);
        $returnFlag = $request->query('return', 0); // 1 if return flight is requested
        $returnDate = $request->query('returnDate', null);
        $origin = 'VNO'; // Vilnius airport code

        $destination = $this->mapCityToIATA($city);

        try {
            if ($returnFlag && $returnDate) {
                $flightData = $amadeus->getFlightOffers($origin, $destination, $departureDate, $returnDate, $passengers);
            } else {
                $flightData = $amadeus->getFlightOffers($origin, $destination, $departureDate, null, $passengers);
            }
        } catch (\Exception $e) {
            \Log::error('Error in TravelOptionsController: ' . $e->getMessage());
            $flightData = null;
        }

        return view('travel-options', [
            'city'          => $city,
            'flightData'    => $flightData,
            'departureDate' => $departureDate,
            'returnDate'    => $returnDate,
            'returnFlag'    => $returnFlag,
            'passengers'    => $passengers,
        ]);
    }

    /**
     * Map city names to their primary airport IATA codes.
     *
     * @param string $city
     * @return string
     */
    private function mapCityToIATA($city)
{
    $mapping = [
        'Riga'         => 'RIX',
        'Tallinn'      => 'TLL',
        'Rome'         => 'FCO',
        'Munich'       => 'MUC',
        'Nuremberg'    => 'NUE',
        'Paris'        => 'CDG',
        'Barcelona'    => 'BCN',
        'Madrid'       => 'MAD',
        'Oslo'         => 'OSL',
        'Stockholm'    => 'ARN',
        'Copenhagen'   => 'CPH',
        'Bucharest'    => 'OTP',
        'Milan'        => 'MXP',
        'Nice'         => 'NCE',
        'London'       => 'LHR',
        'Dublin'       => 'DUB',
        'Athens'       => 'ATH',
        'Praha'        => 'PRG',
        'Warsaw'       => 'WAW',
        'Helsinki'     => 'HEL',
        'Zagreb'       => 'ZAG',
        'Vienna'       => 'VIE',
        'Istanbul'     => 'IST',
        'Sofia'        => 'SOF',
        'Budapest'     => 'BUD',
        'Bratislava'   => 'BTS',
        'Timisoara'    => 'TSR',
        'Cluj'         => 'CLJ',
        'Hamburg'      => 'HAM',
        'Berlin'       => 'BER',
        'Krakow'       => 'KRK',
        'Lisbon'       => 'LIS',
        'Amsterdam'    => 'AMS',
        'Brussels'     => 'BRU',
        'Varna'        => 'VAR',
        'Edinburgh'    => 'EDI',
        'Palermo'      => 'PMO',
        'Reykjavík'    => 'KEF',
        'Malta'        => 'MLA',
        'Thessaloniki' => 'SKG'
    ];

    return $mapping[$city] ?? 'LHR';
}
}
