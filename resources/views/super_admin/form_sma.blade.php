@extends('super_admin.layouts.super_admin_layout')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($sma) ? 'Edit Data Sekolah' : 'Tambah Data Sekolah' }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-4xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ isset($sma) ? route('super_admin.sma.update', $sma) : route('super_admin.sma.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($sma))
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label for="nama_sma" class="block text-gray-700 text-sm font-bold mb-2">Nama Sekolah</label>
                        <input type="text" name="nama_sma" id="nama_sma" value="{{ old('nama_sma', $sma->nama_sma ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('nama_sma')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="akreditasi_id" class="block text-gray-700 text-sm font-bold mb-2">Akreditasi</label>
                        <select name="akreditasi_id" id="akreditasi_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($akreditasis as $akreditasi)
                                <option value="{{ $akreditasi->id }}" @if(isset($sma) && $sma->akreditasi_id == $akreditasi->id) selected @endif>
                                    {{ $akreditasi->jenis_akreditasi }}
                                </option>
                            @endforeach
                        </select>
                        @error('akreditasi_id')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="logo_sma" class="block text-gray-700 text-sm font-bold mb-2">Logo Sekolah</label>
                        <input type="file" name="logo_sma" id="logo_sma" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('logo_sma')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                        @if(isset($sma) && $sma->logo_sma)
                            <p class="text-sm text-gray-500 mt-2">Logo saat ini:</p>
                            <img src="{{ Storage::url($sma->logo_sma) }}" alt="Logo Sekolah" class="w-20 h-20 mt-2">
                        @endif
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            {{ isset($sma) ? 'Perbarui' : 'Simpan' }}
                        </button>
                        <a href="{{ route('super_admin.data_sma') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection