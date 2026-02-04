@extends('admin.layout')

@section('title', 'Edit Role User')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h1 class="text-xl font-bold mb-6">Edit Role User</h1>
    <form method="POST" action="{{ route('admin.roles.update', $user->id) }}" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <label for="role" class="block font-semibold mb-2">Role</label>
            <select name="role" id="role" class="border rounded px-3 py-2 w-full">
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        <a href="{{ route('admin.users.show', $user->id) }}" class="ml-4 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection
