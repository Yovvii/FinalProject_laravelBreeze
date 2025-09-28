@extends('super_admin.layouts.super_admin_layout')

@section('content')
    <div class="py-5">
        <div class="max-w-4xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-6">Edit Admin Sekolah: {{ $admin->name }}</h3>
                
                <form action="{{ route('super_admin.admin.update', $admin) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="sma_data_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Sekolah</label>
                        <select name="sma_data_id" id="sma_data_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}" {{ old('sma_data_id', $admin->sma_data_id) == $school->id ? 'selected' : '' }}>
                                    {{ $school->nama_sma }}
                                </option>
                            @endforeach
                        </select>
                        @error('sma_data_id')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Admin</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $admin->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Admin</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password Baru (Kosongkan jika tidak ingin diganti)</label>
                        <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('password')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Perbarui Admin
                        </button>
                        <a href="{{ route('super_admin.data_admin_sekolah') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection