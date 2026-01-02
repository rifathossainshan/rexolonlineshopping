@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h3 class="text-gray-700 text-3xl font-medium">Settings</h3>

        <div class="mt-8">
            <div class="p-6 bg-white rounded-md shadow-md">
                <h2 class="text-lg text-gray-700 font-semibold capitalize">Site Logo</h2>

                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data"
                    class="mt-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 mt-4">
                        <!-- Current Logo Preview -->
                        @if($logo)
                            <div>
                                <label class="text-gray-700">Current Logo</label>
                                <div class="mt-2 bg-gray-100 p-4 rounded items-center flex justify-center">
                                    <img src="{{ asset($logo) }}?v={{ time() }}" alt="Site Logo" class="h-16">
                                </div>
                            </div>
                        @endif

                        <!-- Upload Input -->
                        <div>
                            <label class="text-gray-700" for="site_logo">Upload New Logo (SVG only)</label>
                            <input type="file" name="site_logo" id="site_logo" accept=".svg"
                                class="w-full mt-2 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                            @error('site_logo')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button
                            class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-gray-900 rounded-md hover:bg-gray-800 focus:outline-none focus:bg-gray-600">Save
                            Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection