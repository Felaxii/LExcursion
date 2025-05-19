<?php

return [
    'title' => 'Hotels in :city',
    'fields' => [
        'city'             => 'City',
        'city_placeholder' => 'Enter a city name',
        'check_in'         => 'Check-In Date',
        'check_out'        => 'Check-Out Date',
        'adults'           => 'Adults',
        'sort_by'          => 'Sort By',
        'review_score'     => 'Review Score',
        'price'            => 'Price',
    ],
    'sort' => [
        'price_asc'             => 'Price (Lowest to Highest)',
        'price_desc'            => 'Price (Highest to Lowest)',
        'rating'                => 'Rating',
        'best_rating_for_price' => 'Best Rating for the Price',
    ],
    'buttons' => [
        'search'    => 'Search Hotels',
        'purchase'  => 'Purchase Room',
        'view_map'  => 'View on Map',
    ],
    'available'   => 'Available Hotels in :city',
    'unavailable' => 'Hotel Unavailable',
    'unknown'     => 'Unknown',
    'none'        => 'No hotels found for the selected city and dates.',
    'alert' => [
        'choose' => 'You have chosen to purchase a room at',
        'for'    => 'for',
    ],
    'lang' => [
        'en' => 'English',
        'lt' => 'Lietuvių',
    ],
];
