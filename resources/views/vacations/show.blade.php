<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Package Details</h2>
            <a href="{{ route('vacations.index') }}" class="text-blue-500 hover:text-blue-700">← Back to Packages</a>
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-8">

                        {{-- Images --}}
                        <div>
                            @php $firstImage = $vacation->images->first(); @endphp
                            		<img src="{{ $vacation->main_image }}"
                                 alt="{{ $vacation->title }}"
                                 class="w-full rounded-lg shadow-lg mb-3">

                            @if($vacation->images->count() > 1)
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach($vacation->images->skip(1) as $image)
                                        <img src="{{ asset('storage/' . $image->route) }}"
                                             alt="{{ $vacation->title }}"
                                             class="w-full h-16 object-cover rounded">
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div>
                            <span class="inline-block text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded mb-2">
                                {{ $vacation->type->name }} — {{ $vacation->country }}
                            </span>
                            <h1 class="text-3xl font-bold mb-4">{{ $vacation->title }}</h1>
                            <p class="text-gray-700 mb-6 leading-relaxed">{{ $vacation->description }}</p>

                            <div class="mb-6">
                                <span class="text-4xl font-bold text-blue-600">{{ number_format($vacation->price, 2) }}€</span>
                                <span class="ml-3 text-gray-500 text-sm">per person</span>
                            </div>

                            <div class="space-y-3">
                                {{-- Book button for normal users --}}
                                @if(Auth::user()->rol === 'normal')
                                    @php
                                        $alreadyReserved = $vacation->reserves->contains('id_user', Auth::id());
                                    @endphp
                                    @if($alreadyReserved)
                                        <div class="w-full bg-gray-100 text-gray-500 font-bold py-3 px-6 rounded-lg text-center">
                                            Already booked ✓
                                        </div>
                                    @else
                                        <form action="{{ route('reserves.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id_vacation" value="{{ $vacation->id }}">
                                            <button type="submit"
                                                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg transition">
                                                Book Now
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                {{-- Edit / Delete for admin and advanced (own packages) --}}
                                @if(Auth::user()->rol === 'admin' || (Auth::user()->rol === 'advanced' && $vacation->id_user === Auth::id()))
                                    <div class="flex gap-2">
                                        <a href="{{ route('vacations.edit', $vacation) }}"
                                           class="flex-1 font-bold py-3 px-6 rounded-lg text-center" style="background-color: yellow">
                                            Edit Package
                                        </a>
                                        <form action="{{ route('vacations.destroy', $vacation) }}" method="POST" class="flex-1"
                                              onsubmit="return confirm('Are you sure you want to delete this package?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-full text-white font-bold py-3 px-6 rounded-lg" style="background-color: red">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Comments section --}}
                    <div class="mt-8 border-t pt-8">
                        <h2 class="text-2xl font-bold mb-4">Comments ({{ $vacation->comments->count() }})</h2>

                        {{-- Add comment form — only if user has booked AND hasn't commented yet --}}
                        @if(Auth::user()->rol === 'normal')
                            @php
                                $hasReserved  = $vacation->reserves->contains('id_user', Auth::id());
                                $hasCommented = $vacation->comments->contains('id_user', Auth::id());
                            @endphp

                            @if($hasReserved && !$hasCommented)
                                <form action="{{ route('comments.store', $vacation) }}" method="POST" class="bg-gray-50 p-6 rounded-lg mb-6">
                                    @csrf
                                    <input type="hidden" name="id_vacation" value="{{ $vacation->id }}">
                                    <div class="mb-4">
                                        <label class="block text-gray-700 text-sm font-bold mb-2">Your Comment</label>
                                        <textarea name="text" rows="3"
                                                  class="shadow border rounded w-full py-2 px-3 text-gray-700"
                                                  placeholder="Share your experience with this package..."
                                                  required>{{ old('text') }}</textarea>
                                        @error('text')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Submit Comment
                                    </button>
                                </form>
                            @elseif(!$hasReserved)
                                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded mb-6 text-sm">
                                    You need to book this package before you can comment.
                                </div>
                            @endif
                        @endif

                        {{-- Comment list --}}
                        @if($vacation->comments->count() > 0)
                            <div class="space-y-4">
                                @foreach($vacation->comments as $comment)
                                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-bold text-gray-800">{{ $comment->user->name }}</span>
                                            <div class="flex gap-3 items-center">
                                                <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>

                                                {{-- Edit — only the author --}}
                                                @if(Auth::id() === $comment->id_user)
                                                    <button onclick="document.getElementById('edit-{{ $comment->id }}').classList.toggle('hidden')"
                                                            class="text-blue-500 hover:text-blue-700 text-sm">
                                                        Edit
                                                    </button>
                                                @endif

                                                {{-- Delete — admin or author --}}
                                                @if(Auth::user()->rol === 'admin' || Auth::id() === $comment->id_user)
                                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                                          onsubmit="return confirm('Delete this comment?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>

                                        <p class="text-gray-700">{{ $comment->text }}</p>

                                        {{-- Inline edit form --}}
                                        @if(Auth::id() === $comment->id_user)
                                            <div id="edit-{{ $comment->id }}" class="hidden mt-3">
                                                <form action="{{ route('comments.update', $comment) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="text" rows="2"
                                                              class="shadow border rounded w-full py-2 px-3 text-gray-700 text-sm mb-2">{{ $comment->text }}</textarea>
                                                    <div class="flex gap-2">
                                                        <button type="submit"
                                                                class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-4 rounded text-sm font-semibold">
                                                            Save
                                                        </button>
                                                        <button type="button"
                                                                onclick="document.getElementById('edit-{{ $comment->id }}').classList.add('hidden')"
                                                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-1 px-4 rounded text-sm">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No comments yet.</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
