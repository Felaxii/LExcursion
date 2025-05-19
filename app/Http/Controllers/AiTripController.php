<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI as OpenAIClient;

class AiTripController extends Controller
{
    public function index()
    {
        return view('trip-generator.index');
    }

    public function generate(Request $request)
    {
        $f = $request->validate([
            'type'        => 'required|in:leisure,exploration',
            'price_level' => 'nullable|string',
            'geography'   => 'nullable|array',
            'geography.*' => 'in:beach,mountain,lake,city,countryside',
            'interests'   => 'nullable|array',
            'interests.*' => 'in:food,architecture,events,shopping',
            'extra'       => 'nullable|string|max:200',
        ]);

        $client = OpenAIClient::client(config('services.openai.key'));

        $priceList    = $f['price_level'] ?? 'any';
        $geoList      = $f['geography']   ?? [];
        $interestList = $f['interests']   ?? [];
        $extra        = $f['extra']       ?? 'none';

        $geography = count($geoList)
            ? implode(', ', $geoList)
            : 'none (no restriction)';
        $interests = count($interestList)
            ? implode(', ', $interestList)
            : 'none (no restriction)';

        $locale = app()->getLocale();
        $langInstruction = $locale === 'lt'
            ? 'Atsakykite lietuvių kalba.'
            : 'Please answer in English.';

        $prompt = <<<PROMPT
You are a travel assistant with deep knowledge of European cities.
Filters (empty means no restriction):
- Type: {$f['type']}
- Price level: $priceList
- Geography: $geography
- Interests: $interests
- Extra: $extra

Always return 2–6 suggestions, even if some filters are empty, as pure JSON array of objects:
[
  {
    "name":"CityName",
    "country":"CountryName",
    "description":"Short description…",
    "reason":"Why this fits the filters"
  }
]
$langInstruction
PROMPT;

        $res = $client->chat()->create([
            'model'       => 'gpt-4o-mini',
            'messages'    => [
                ['role' => 'system', 'content' => 'You are a helpful travel planner.'],
                ['role' => 'user',   'content' => $prompt],
            ],
            'temperature' => 0.7,
            'max_tokens'  => 500,
        ]);

        $raw = $res->choices[0]->message->content;

        if (preg_match('/\[(.*)\]/sU', $raw, $m)) {
            $json   = '[' . $m[1] . ']';
            $cities = json_decode($json, true);
        } else {
            $cities = null;
        }

        if (! is_array($cities)) {
            session()->flash('error', __('trip_generator.error.parse'));
            $cities = [];
        }

        return view('trip-generator.results', [
            'cities'  => $cities,
            'filters' => $f,
        ]);
    }
}
