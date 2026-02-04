@extends('admin.layout')

@section('title', 'Manajemen Role')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h1 class="text-xl font-bold mb-6">Manajemen Role</h1>
    <ul class="bg-white shadow rounded-lg p-6">
        @foreach($roles as $role)
            <li class="mb-2">{{ ucfirst($role) }}</li>
        @endforeach
    </ul>
</div>
@endsection
