<?php

return [
    'title' => 'Kelionių generatorius',

    'fields' => [
        'type'        => 'Kelionės tipas',
        'price_level' => 'Kainų lygis',
        'geography'   => 'Geografija',
        'interests'   => 'Veikla ir pomėgiai',
        'extra'       => 'Papildomi pageidavimai',
    ],

    'types' => [
        'leisure'     => 'Poilsis',
        'exploration' => 'Pažintinė',
    ],

    'price' => [
        'any'    => 'Bet koks',
        'low'    => 'Žemas',
        'medium' => 'Vidutinis',
        'high'   => 'Aukštas',
    ],

    'geography' => [
        'beach'       => 'Paplūdimys',
        'mountain'    => 'Kalnai',
        'lake'        => 'Ežerai',
        'city'        => 'Miestas',
        'countryside' => 'Užmiestis',
    ],

    'interests' => [
        'food'         => 'Maistas',
        'architecture' => 'Architektūra',
        'events'       => 'Renginiai',
        'shopping'     => 'Apsipirkimas',
        'nightlife'    => 'Naktinis gyvenimas',
    ],

    'multiselect' => 'Galite pasirinkti kelis',

    'placeholders' => [
        'extra' => 'Aprašykite specialius reikalavimus…',
    ],

    'buttons' => [
        'generate'  => 'Generuoti pasiūlymus',
        'book_stay' => 'Rezervuoti apgyvendinimą',
        'travel_to' => 'Kelionė į',
    ],

    'actions' => [
        'book_stay' => 'Rezervuoti apgyvendinimą',
        'travel_to' => 'Kelionė į',
    ],

    'error' => [
        'parse' => 'Nepavyko suprasti atsakymo. Bandykite dar kartą.',
    ],

    'results' => [
        'title' => 'Kelionių pasiūlymai',
        'none'  => 'Nerasta atitinkančių filtrų pasiūlymų.',
        'back'  => '← Atgal į generatorių',
    ],
];
