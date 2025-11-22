@extends('layouts.app')

@section('content')
<h1>{{ $handyman->user->name }}</h1>
<p>{{ ucfirst($handyman->skill_category) }} — Rating: {{ $handyman->average_rating }}</p>
<p>{{ $handyman->bio }}</p>
<!-- Add booking button (link to booking/create page) -->
<a href="{{ route('bookings.create', ['handyman' => $handyman->id]) }}" class="btn btn-primary">Book Now</a>
@endsection
