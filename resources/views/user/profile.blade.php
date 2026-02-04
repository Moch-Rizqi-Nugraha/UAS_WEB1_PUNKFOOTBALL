<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile - Punk Football</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    @include('user.partials.navbar')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
                <a href="{{ route('user.dashboard') }}" class="btn-secondary">Back to Dashboard</a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile Information -->
                <div class="lg:col-span-2">
                    <div class="card">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Profile Information</h3>

                        <form method="POST" action="{{ route('user.profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="btn-primary">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Account Information -->
                <div>
                    <div class="card">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Account Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Role</dt>
                                <dd class="text-sm text-gray-900">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email Verified</dt>
                                <dd class="text-sm text-gray-900">
                                    {{ $user->email_verified_at ? 'Yes' : 'No' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                                <dd class="text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</dd>
                            </div>
                        </dl>
                    </div>

                    @if($user->isAdmin())
                    <div class="card mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Admin Access</h3>
                        <p class="text-sm text-gray-600 mb-4">You have admin privileges. Access the admin panel to manage users and system settings.</p>
                        <a href="{{ route('admin.dashboard') }}" class="btn-primary inline-block w-full text-center">Go to Admin Panel</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>