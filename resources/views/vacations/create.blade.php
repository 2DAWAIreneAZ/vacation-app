<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add New Package</h2>
            <a href="{{ route('vacations.index') }}" class="text-blue-500 hover:text-blue-700">← Back to Packages</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('vacations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Title *</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                   placeholder="e.g. Tropical Beaches in Cancún"
                                   class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('title') border-red-400 @enderror"
                                   required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Description *</label>
                            <textarea name="description" rows="4"
                                      placeholder="Describe the package: activities, accommodation, what's included..."
                                      class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('description') border-red-400 @enderror"
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Price (€) *</label>
                                <input type="number" name="price" value="{{ old('price') }}"
                                       min="0" step="0.01" placeholder="1299.00"
                                       class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('price') border-red-400 @enderror"
                                       required>
                                @error('price')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Country *</label>
                                <input type="text" name="country" value="{{ old('country') }}"
                                       placeholder="Mexico, Spain, Maldives..."
                                       class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('country') border-red-400 @enderror"
                                       required>
                                @error('country')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Type *</label>
                            <select name="id_type"
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('id_type') border-red-400 @enderror"
                                    required>
                                <option value="">-- Select a type --</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ old('id_type') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Images <span class="font-normal text-gray-500">(up to 10, optional)</span>
                            </label>
                            <input type="file" name="images[]" id="imagesInput"
                                   accept="image/*" multiple
                                   class="shadow border rounded w-full py-2 px-3 text-gray-700"
                                   onchange="previewImages(this)">
                            <div id="imagePreview" class="mt-3 flex flex-wrap gap-2"></div>
                            @error('images.*')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <button type="submit"
                                    class="flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Package
                            </button>
                            <a href="{{ route('vacations.index') }}"
                               class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImages(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-20 h-20 object-cover rounded shadow';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
</x-app-layout>
