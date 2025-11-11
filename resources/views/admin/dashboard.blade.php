<x-app-layout>
    <h1 class="text-2xl">Admin Dashboard</h1>
    <p>Welcome, {{ $user->name }} ({{ $user->role }})</p>
    <div class="mt-4">
        <ul>
            <li>Total users: {{ $stats['total_users'] }}</li>
            <li>Total handymen: {{ $stats['total_handymen'] }}</li>
            <li>Total bookings: {{ $stats['total_bookings'] }}</li>
            <li>Total reviews: {{ $stats['total_reviews'] }}</li>
        </ul>
    </div>
</x-app-layout>
