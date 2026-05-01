<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Package
            </h2>
            <a href="{{ route('vacations.show', $vacation) }}" class="text-blue-500 hover:text-blue-700">
                ← Back to Package
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

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

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FORM PRINCIPAL DE ACTUALIZAR PAQUETE --}}
                    <form action="{{ route('vacations.update', $vacation) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Title *</label>
                            <input type="text"
                                   name="title"
                                   value="{{ old('title', $vacation->title) }}"
                                   class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('title') border-red-400 @enderror"
                                   required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Description *</label>
                            <textarea name="description"
                                      rows="4"
                                      class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('description') border-red-400 @enderror"
                                      required>{{ old('description', $vacation->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Price (€) *</label>
                                <input type="number"
                                       name="price"
                                       value="{{ old('price', $vacation->price) }}"
                                       min="0"
                                       step="0.01"
                                       class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('price') border-red-400 @enderror"
                                       required>
                                @error('price')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Country *</label>
                                <input type="text"
                                       name="country"
                                       value="{{ old('country', $vacation->country) }}"
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
                                    <option value="{{ $type->id }}" {{ old('id_type', $vacation->id_type) == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ADD MORE IMAGES --}}
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Add More Images <span class="font-normal text-gray-500">(optional, max 10 total)</span>
                            </label>

                            <input type="file"
                                   name="images[]"
                                   id="imagesInput"
                                   multiple
                                   accept="image/*"
                                   class="shadow border rounded w-full py-2 px-3 text-gray-700"
                                   onchange="previewImages(this)">

                            @error('images')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            @error('images.*')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <div id="imagePreview" class="mt-3 flex flex-wrap gap-2"></div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit"
                                    class="flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save Changes
                            </button>

                            <a href="{{ route('vacations.show', $vacation) }}"
                               class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded text-center">
                                Cancel
                            </a>
                        </div>
                    </form>

                    {{-- CURRENT IMAGES (FUERA DEL FORM PRINCIPAL) --}}
                    @if($vacation->images->count() > 0)
												<div class="mt-8 border-t pt-6">
														<label class="block text-gray-700 text-sm font-bold mb-3">
																Current Images ({{ $vacation->images->count() }}/10)
														</label>

														<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
																@foreach($vacation->images as $image)
																		<div class="relative group rounded-lg overflow-hidden shadow bg-gray-100">
																				<img src="{{ asset('storage/' . $image->route) }}"
																						alt="image"
																						class="w-full h-28 object-cover transition duration-200 group-hover:scale-105">

																				@if(Auth::user()->rol === 'admin' || (Auth::user()->rol === 'advanced' && $vacation->id_user === Auth::id()))
																						<form action="{{ route('images.destroy', $image) }}"
																									method="POST"
																									class="absolute top-2 right-2"
																									onsubmit="return confirm('Delete this image?')">
																								@csrf
																								@method('DELETE')

																								<button type="submit"
																												class="relative z-10 flex items-center justify-center w-8 h-8 rounded-full bg-red-600 text-white shadow-lg opacity-90 hover:opacity-100 hover:bg-red-700 transition"
																												title="Delete image">
																										×
																								</button>
																						</form>

																						<div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition"></div>
																				@endif
																		</div>
																@endforeach
														</div>
												</div>
										@endif

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