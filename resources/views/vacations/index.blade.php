<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Vacation Packages</h2>
            @if(Auth::user()->rol === 'admin' || Auth::user()->rol === 'advanced')
                <a href="{{ route('vacations.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add New Package
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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

            {{-- Filters --}}
            <div class="mb-6 flex gap-4">
                <form method="GET" class="flex gap-4 w-full">
                    <input type="text" name="search" placeholder="Search packages..."
                           value="{{ request('search') }}"
                           class="flex-1 rounded-md border-gray-300 shadow-sm">

                    <select name="type" class="rounded-md border-gray-300 shadow-sm">
                        <option value="">All Types</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>

                    <input type="text" name="country" placeholder="Country..."
                           value="{{ request('country') }}"
                           class="rounded-md border-gray-300 shadow-sm w-36">

                    <input type="number" name="max_price" placeholder="Max price..."
                           value="{{ request('max_price') }}"
                           class="rounded-md border-gray-300 shadow-sm w-32">

                    <select name="sort" class="rounded-md border-gray-300 shadow-sm">
                        <option value="">Sort by</option>
                        <option value="price_asc"  {{ request('sort') === 'price_asc'  ? 'selected' : '' }}>Price ↑</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price ↓</option>
                    </select>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-6 py-2 rounded">
                        Filter
                    </button>
                    <a href="{{ route('vacations.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-6 py-2 rounded">
                        Clear
                    </a>
                </form>
            </div>

            {{-- Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($vacations as $vacation)
                    @php $firstImage = $vacation->images->first(); @endphp
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                        <img src="{{ $vacation->main_image }}"
                             alt="{{ $vacation->title }}"
                             class="w-full h-48 object-cover">

                        <div class="p-4">
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $vacation->type->name }}</span>
                            <h3 class="font-bold text-lg mb-1 mt-2">{{ Str::limit($vacation->title, 40) }}</h3>
                            <p class="text-xs text-gray-500 mb-1">{{ $vacation->country }}</p>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($vacation->description, 80) }}</p>

                            <div class="flex items-center justify-between mb-3">
                                <span class="text-2xl font-bold text-blue-600">{{ number_format($vacation->price, 2) }}€</span>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('vacations.show', $vacation) }}"
                                   class="flex-1 bg-gray-200 hover:bg-gray-300 text-center py-2 rounded font-semibold">
                                    Details
                                </a>

                                @if(Auth::user()->rol === 'admin' || (Auth::user()->rol === 'advanced' && $vacation->id_user === Auth::id()))
                                    <a href="{{ route('vacations.edit', $vacation) }}"
                                       class="flex-1 text-center py-2 rounded font-semibold" style="background-color: yellow">
                                        Edit
                                    </a>
                                @endif

                                @if(Auth::user()->rol === 'admin' || (Auth::user()->rol === 'advanced' && $vacation->id_user === Auth::id()))
                                    <form action="{{ route('vacations.destroy', $vacation) }}" method="POST" class="flex-1"
                                          onsubmit="return confirm('Delete this package?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full text-white py-2 rounded font-semibold" style="background-color: red">
                                            Delete
                                        </button>
                                    </form>
                                @endif

                                @if(Auth::user()->rol === 'normal')
                                    <form action="{{ route('reserves.store') }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="id_vacation" value="{{ $vacation->id }}">
                                        <button type="submit"
                                                class="w-full bg-blue-500 hover:bg-blue-700 text-white py-2 rounded font-semibold">
                                            Book
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">No packages found.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $vacations->withQueryString()->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
