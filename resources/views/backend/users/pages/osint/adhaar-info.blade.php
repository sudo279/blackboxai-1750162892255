@extends('backend.layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-lg shadow-xl p-8 mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Aadhaar Information Lookup</h1>
            <p class="text-gray-300">Securely verify and manage Aadhaar information with advanced tracking capabilities.</p>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
        @endif

        <!-- Search Form -->
        <div class="bg-white rounded-lg shadow-md mb-8">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h2 class="text-lg font-medium text-gray-900">Aadhaar Verification</h2>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <form action="{{ route('osint-tools.adhaar-check') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="adhaar" class="block text-sm font-medium text-gray-700">
                                Aadhaar Number
                            </label>
                            <div class="mt-1">
                                <input type="text" 
                                       name="adhaar" 
                                       id="adhaar"
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('adhaar') border-red-500 @enderror"
                                       placeholder="Enter 12-digit Aadhaar number"
                                       maxlength="12"
                                       value="{{ old('adhaar') }}"
                                       required>
                                @error('adhaar')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="reset" 
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Reset
                            </button>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Verify Aadhaar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- History Table -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h2 class="text-lg font-medium text-gray-900">Lookup History</h2>
            </div>
            <div class="px-4 py-5 sm:p-6">
                @if($adhaarInfoData->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500">No lookup history available</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aadhaar Number
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date & Time
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($adhaarInfoData as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ substr_replace($record->adhaar, str_repeat('*', 8), 2, 8) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $record->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Verified
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add input masking for Aadhaar number
    document.getElementById('adhaar').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 12) value = value.slice(0, 12);
        e.target.value = value;
    });
</script>
@endpush
