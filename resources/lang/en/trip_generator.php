<?php

return [
    'title' => 'Trip Generator',

    'fields' => [
        'type'        => 'Trip Type',
        'price_level' => 'Price Level',
        'geography'   => 'Geography',
        'interests'   => 'Interests & Activities',
        'extra'       => 'Additional Preferences',
    ],

    'types' => [
        'leisure'     => 'Leisure',
        'exploration' => 'Exploration',
    ],

    'price' => [
        'any'    => 'Any',
        'low'    => 'Low',
        'medium' => 'Medium',
        'high'   => 'High',
    ],

    'geography' => [
        'beach'       => 'Beach',
        'mountain'    => 'Mountain',
        'lake'        => 'Lake',
        'city'        => 'City',
        'countryside' => 'Countryside',
    ],

    'interests' => [
        'food'         => 'Food',
        'architecture' => 'Architecture',
        'events'       => 'Events',
        'shopping'     => 'Shopping',
        'nightlife'    => 'Nightlife',
    ],

    'multiselect' => 'You can select multiple',

    'placeholders' => [
        'extra' => 'Describe any special requirements…',
    ],

    'buttons' => [
        'generate'  => 'Generate Suggestions',
        'book_stay' => 'Book a Place to Stay',
        'travel_to' => 'Travel To',
    ],

    'actions' => [
        'book_stay' => 'Book a Place to Stay',
        'travel_to' => 'Travel To',
    ],

    'error' => [
        'parse' => 'Could not understand AI response. Please try again.',
    ],

    'results' => [
        'title' => 'Your Trip Suggestions',
        'none'  => 'No suggestions matched your filters.',
        'back'  => '← Back to Generator',
    ],
];
