<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">User Management</h2>
            <a href="{{ route('users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New User
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Filter --}}
            <div class="mb-6 flex gap-4">
                <form method="GET" class="flex gap-4 w-full">
                    <input type="text" name="search" placeholder="Search by name or email..."
                           value="{{ request('search') }}"
                           class="flex-1 rounded-md border-gray-300 shadow-sm">
                    <select name="rol" class="rounded-md border-gray-300 shadow-sm">
                        <option value="">All Roles</option>
                        <option value="admin"    {{ request('rol') === 'admin'    ? 'selected' : '' }}>Admin</option>
                        <option value="advanced" {{ request('rol') === 'advanced' ? 'selected' : '' }}>Advanced</option>
                        <option value="normal"   {{ request('rol') === 'normal'   ? 'selected' : '' }}>Normal</option>
                    </select>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-6 py-2 rounded">Filter</button>
                    <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-6 py-2 rounded">Clear</a>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left py-3 px-6 font-semibold text-gray-700">Name</th>
                            <th class="text-left py-3 px-6 font-semibold text-gray-700">Email</th>
                            <th class="text-left py-3 px-6 font-semibold text-gray-700">Role</th>
                            <th class="text-left py-3 px-6 font-semibold text-gray-700">Reservations</th>
                            <th class="text-right py-3 px-6 font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-6 font-medium text-gray-800">{{ $user->name }}</td>
                                <td class="py-3 px-6 text-gray-500">{{ $user->email }}</td>
                                <td class="py-3 px-6">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $user->rol === 'admin'    ? 'bg-purple-200 text-purple-800' :
                                           ($user->rol === 'advanced' ? 'bg-yellow-200 text-yellow-800' :
                                                                        'bg-blue-200 text-blue-800') }}">
                                        {{ strtoupper($user->rol) }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-gray-500">{{ $user->reserves->count() }}</td>
                                <td class="py-3 px-6 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('users.edit', $user) }}"
                                           class="font-semibold py-1 px-3 rounded text-sm" style="background-color: yellow">
                                            Edit
                                        </a>
                                        @if(Auth::id() !== $user->id)
                                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                  onsubmit="return confirm('Delete user {{ $user->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-white font-semibold py-1 px-3 rounded text-sm" style="background-color: red">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-400">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
