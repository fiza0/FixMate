@extends('layouts.app')

@section('content')
<h1>Available Handymen</h1>
@foreach($handymen as $h)
  <div class="card p-3 mb-2">
    <h3>{{ $h->user->name }} — {{ ucfirst($h->skill_category) }}</h3>
    <p>Rating: {{ $h->average_rating }}</p>
    <p>{{ $h->bio }}</p>
    <a href="{{ route('handymen.show', $h->id) }}">View Profile</a>
  </div>
@endforeach
@endsection
