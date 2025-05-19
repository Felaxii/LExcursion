@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6">
  <h1 class="text-2xl font-bold mb-4">AI Test</h1>
  <pre class="bg-gray-100 p-4 rounded">{{ $answer }}</pre>
</div>
@endsection
