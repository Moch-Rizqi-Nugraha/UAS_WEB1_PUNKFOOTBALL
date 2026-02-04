@php
    if (auth()->user()->isAdmin()) {
        header('Location: ' . route('admin.dashboard'));
        exit;
    } else {
        header('Location: ' . route('user.dashboard'));
        exit;
    }
@endphp
