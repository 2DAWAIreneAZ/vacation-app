<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Package Types</h2>
            @if(Auth::user()->rol === 'admin')
                <a href="{{ route('types.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add New Type
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left py-3 px-6 font-semibold text-gray-700">#</th>
                            <th class="text-left py-3 px-6 font-semibold text-gray-700">Name</th>
                            <th class="text-left py-3 px-6 font-semibold text-gray-700">Packages</th>
                            @if(Auth::user()->rol === 'admin')
                                <th class="text-right py-3 px-6 font-semibold text-gray-700">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($types as $type)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-6 text-gray-400">{{ $type->id }}</td>
                                <td class="py-3 px-6 font-medium text-gray-800">{{ $type->name }}</td>
                                <td class="py-3 px-6 text-gray-500">{{ $type->vacations_count }}</td>
                                @if(Auth::user()->rol === 'admin')
                                    <td class="py-3 px-6 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('types.edit', $type) }}"
                                               class="font-semibold py-1 px-3 rounded text-sm" style="background-color: yellow">
                                                Edit
                                            </a>
                                            <form action="{{ route('types.destroy', $type) }}" method="POST"
                                                  onsubmit="return confirm('Delete this type?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-white font-semibold py-1 px-3 rounded text-sm" style="background-color: red">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-gray-400">No types found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
