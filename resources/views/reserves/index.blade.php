<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Reservations</h2>
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

            @forelse($reserves as $reserve)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 flex">
                    @php $firstImage = $reserve->vacation->images->first(); @endphp
                    <img src="{{ $firstImage ? asset('storage/' . $firstImage->route) : 'https://via.placeholder.com/200' }}"
                         alt="{{ $reserve->vacation->title }}"
                         class="w-48 h-36 object-cover flex-shrink-0">

                    <div class="p-4 flex-1 flex justify-between items-center">
                        <div>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $reserve->vacation->type->name }}</span>
                            <h3 class="text-lg font-bold text-gray-800 mt-1">{{ $reserve->vacation->title }}</h3>
                            <p class="text-gray-500 text-sm">{{ $reserve->vacation->country }}</p>
                            <p class="text-blue-600 font-bold text-xl mt-1">{{ number_format($reserve->vacation->price, 2) }}€</p>
                        </div>

                        <div class="text-center mr-6">
                            <p class="text-xs text-gray-400 mb-1">Booked on</p>
                            <p class="text-sm font-medium text-gray-700">{{ $reserve->created_at->format('d/m/Y') }}</p>
                            <span class="inline-block mt-2 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                                Active
                            </span>
                        </div>

                        <div class="flex flex-col gap-2">
                            <a href="{{ route('vacations.show', $reserve->vacation) }}"
                               class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded text-sm text-center">
                                View Package
                            </a>
                            <form action="{{ route('reserves.destroy', $reserve) }}" method="POST"
                                  onsubmit="return confirm('Cancel this reservation?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full text-white font-semibold py-2 px-4 rounded text-sm" style="background-color: red">
                                    Cancel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                    <p class="text-gray-500 text-lg mb-4">You have no reservations yet.</p>
                    <a href="{{ route('vacations.index') }}"
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Browse Packages
                    </a>
                </div>
            @endforelse

            @if($reserves->hasPages())
                <div class="mt-6">{{ $reserves->links() }}</div>
            @endif

        </div>
    </div>
</x-app-layout>
