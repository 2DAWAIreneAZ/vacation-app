<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}!</h3>

                    @if(Auth::user()->rol === 'admin')

                        <div class="mb-6 p-4 bg-purple-50 border border-purple-200 rounded-lg">
                            <p class="text-purple-800 font-semibold">Administrator Mode</p>
                            <p class="text-purple-600 text-sm">You have full access to manage vacation packages, types, and all users.</p>
                        </div>

                        <div class="grid md:grid-cols-3 gap-6">
                            <a href="{{ route('vacations.index') }}"
                               class="block p-6 bg-blue-100 rounded-lg hover:bg-blue-200 transition">
                                <h4 class="text-xl font-bold mb-2">Manage Packages</h4>
                                <p class="text-gray-700">View, create, edit, and delete vacation packages</p>
                            </a>

                            <a href="{{ route('types.index') }}"
                               class="block p-6 bg-green-100 rounded-lg hover:bg-green-200 transition">
                                <h4 class="text-xl font-bold mb-2">Manage Types</h4>
                                <p class="text-gray-700">Organize packages into categories</p>
                            </a>

                            <a href="{{ route('users.index') }}"
                               class="block p-6 bg-purple-100 rounded-lg hover:bg-purple-200 transition">
                                <h4 class="text-xl font-bold mb-2">Manage Users</h4>
                                <p class="text-gray-700">Create, edit, and delete user accounts</p>
                            </a>
                        </div>

                    @elseif(Auth::user()->rol === 'advanced')

                        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-yellow-800 font-semibold">Advanced Account</p>
                            <p class="text-yellow-600 text-sm">You can create and manage vacation packages and types.</p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <a href="{{ route('vacations.index') }}"
                               class="block p-6 bg-blue-100 rounded-lg hover:bg-blue-200 transition">
                                <h4 class="text-xl font-bold mb-2">Manage Packages</h4>
                                <p class="text-gray-700">View, create, and edit your vacation packages</p>
                            </a>

                            <a href="{{ route('types.index') }}"
                               class="block p-6 bg-green-100 rounded-lg hover:bg-green-200 transition">
                                <h4 class="text-xl font-bold mb-2">Manage Types</h4>
                                <p class="text-gray-700">Organize packages into categories</p>
                            </a>
                        </div>

                    @else

                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-blue-800 font-semibold">Customer Account</p>
                            <p class="text-blue-600 text-sm">Browse and book amazing vacation packages!</p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <a href="{{ route('vacations.index') }}"
                               class="block p-6 bg-green-100 rounded-lg hover:bg-green-200 transition">
                                <h4 class="text-xl font-bold mb-2">Browse Packages</h4>
                                <p class="text-gray-700">Explore our catalog and book your next adventure</p>
                            </a>

                            <a href="{{ route('reserves.index') }}"
                               class="block p-6 bg-blue-100 rounded-lg hover:bg-blue-200 transition">
                                <h4 class="text-xl font-bold mb-2">My Reservations</h4>
                                <p class="text-gray-700">View and manage your active bookings</p>
                            </a>
                        </div>

                    @endif

                    <div class="mt-8 p-4 bg-gray-100 rounded-lg">
                        <p class="text-sm text-gray-600">
                            <strong>Account Type:</strong>
                            <span class="ml-2 px-3 py-1 rounded-full text-xs font-semibold
                                {{ Auth::user()->rol === 'admin'    ? 'bg-purple-200 text-purple-800' :
                                   (Auth::user()->rol === 'advanced' ? 'bg-yellow-200 text-yellow-800' :
                                                                       'bg-blue-200 text-blue-800') }}">
                                {{ strtoupper(Auth::user()->rol) }}
                            </span>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
