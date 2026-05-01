<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit User</h2>
            <a href="{{ route('users.index') }}" class="text-blue-500 hover:text-blue-700">← Back to Users</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Name *</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('name') border-red-400 @enderror"
                                   required>
                            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email *</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('email') border-red-400 @enderror"
                                   required>
                            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                New Password
                                <span class="font-normal text-gray-400">(leave blank to keep current)</span>
                            </label>
                            <input type="password" name="password"
                                   class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('password') border-red-400 @enderror">
                            @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation"
                                   class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Role *</label>
                            <select name="rol"
                                    class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('rol') border-red-400 @enderror"
                                    required>
                                <option value="admin"    {{ old('rol', $user->rol) === 'admin'    ? 'selected' : '' }}>Admin – Full access</option>
                                <option value="advanced" {{ old('rol', $user->rol) === 'advanced' ? 'selected' : '' }}>Advanced – Manages packages</option>
                                <option value="normal"   {{ old('rol', $user->rol) === 'normal'   ? 'selected' : '' }}>Normal – Customer</option>
                            </select>
                            @error('rol') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-4">
                            <button type="submit"
                                    class="flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save Changes
                            </button>
                            <a href="{{ route('users.index') }}"
                               class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
