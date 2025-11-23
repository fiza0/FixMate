{{--
    FRONTEND: This is a basic, unstyled edit form.
    Please wrap this in the admin layout and apply styling
    to the form, labels, inputs, and error messages.
--}}

<h1>Edit User: {{ $user->name }}</h1>

{{-- Validation Errors --}}
@if ($errors->any())
    <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 20px;">
        <strong>Whoops! Something went wrong.</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 15px;">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" style="width: 300px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" style="width: 300px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" style="width: 300px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="role">Role:</label><br>
        <select id="role" name="role" style="width: 300px;">
            <option value="homeowner" @if(old('role', $user->role) == 'homeowner') selected @endif>Homeowner</option>
            <option value="handyman" @if(old('role', $user->role) == 'handyman') selected @endif>Handyman</option>
            <option value="admin" @if(old('role', $user->role) == 'admin') selected @endif>Admin</option>
        </select>
    </div>

    <button type="submit">Update User</button>
    <a href="{{ route('admin.users.index') }}" style="margin-left: 10px;">Cancel</a>
</form>