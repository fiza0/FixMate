{{--
    FRONTEND: This is a basic, unstyled user list.
    Please wrap this in the admin layout and apply styling
    to the table, buttons, and notification messages.
--}}

<h1>User Management</h1>

{{-- Session Messages for Success/Error --}}
@if(session('success'))
    <div style="color: green; border: 1px solid green; padding: 10px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 20px;">
        {{ session('error') }}
    </div>
@endif

<table border="1" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th style="padding: 8px;">ID</th>
            <th style="padding: 8px;">Name</th>
            <th style="padding: 8px;">Email</th>
            <th style="padding: 8px;">Role</th>
            <th style="padding: 8px;">Verified Handyman</th>
            <th style="padding: 8px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td style="padding: 8px;">{{ $user->id }}</td>
                <td style="padding: 8px;">{{ $user->name }}</td>
                <td style="padding: 8px;">{{ $user->email }}</td>
                <td style="padding: 8px;">{{ $user->role }}</td>
                <td style="padding: 8px;">
                    @if($user->role == 'handyman')
                        {{ $user->verified ? 'Yes' : 'No' }}
                    @else
                        N/A
                    @endif
                </td>
                <td style="padding: 8px;">
                    {{-- Edit Link --}}
                    <a href="{{ route('admin.users.edit', $user) }}" style="margin-right: 5px;">Edit</a>

                    {{-- Delete Form --}}
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="margin-right: 5px; color: red; background: none; border: none; cursor: pointer;">Delete</button>
                    </form>

                    {{-- Verify/Un-verify Forms --}}
                    @if($user->role == 'handyman')
                        @if($user->verified)
                            <form method="POST" action="{{ route('admin.users.unverify', $user) }}" style="display:inline;">
                                @csrf
                                <button type="submit" style="color: orange; background: none; border: none; cursor: pointer;">Un-verify</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.users.verify', $user) }}" style="display:inline;">
                                @csrf
                                <button type="submit" style="color: green; background: none; border: none; cursor: pointer;">Verify</button>
                            </form>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>