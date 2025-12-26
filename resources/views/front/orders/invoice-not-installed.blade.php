@extends('layouts.app')

@section('title', 'Invoice - PDF Not Installed')

@section('content')
<div class="py-6">
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
        <p class="font-semibold">PDF package not installed</p>
        <p class="mt-2">To enable PDF invoice downloads please install <code>barryvdh/laravel-dompdf</code>.</p>

        <h4 class="mt-4 font-semibold">Install instructions</h4>
    <pre class="bg-gray-100 p-3 rounded">composer require barryvdh/laravel-dompdf</pre>
        <p class="mt-2">After install, you can publish config if needed and then retry download.</p>
    </div>
</div>
@endsection
