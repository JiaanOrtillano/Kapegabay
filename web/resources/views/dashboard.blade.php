<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Farmers List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 border-b text-left">Name</th>
                                    <th class="px-6 py-3 border-b text-left">Email</th>
                                    <th class="px-6 py-3 border-b text-left">Address</th>
                                    <th class="px-6 py-3 border-b text-left">Phone Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($farmers as $farmer)
                                <tr>
                                    <td class="px-6 py-4 border-b">{{ $farmer->name }}</td>
                                    <td class="px-6 py-4 border-b">{{ $farmer->email }}</td>
                                    <td class="px-6 py-4 border-b">{{ $farmer->address }}</td>
                                    <td class="px-6 py-4 border-b">{{ $farmer->number }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div class="mt-4 flex justify-between items-center">
                            <div class="text-sm text-gray-700">
                                Showing {{ $farmers->firstItem() ?? 0 }} to {{ $farmers->lastItem() ?? 0 }} of {{ $farmers->total() }} entries
                            </div>
                            <div class="flex space-x-2">
                                @if($farmers->onFirstPage())
                                    <button disabled class="px-4 py-2 bg-gray-200 text-gray-500 rounded-md cursor-not-allowed">
                                        Previous
                                    </button>
                                @else
                                    <a href="{{ $farmers->previousPageUrl() }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                        Previous
                                    </a>
                                @endif

                                @if($farmers->hasMorePages())
                                    <a href="{{ $farmers->nextPageUrl() }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                        Next
                                    </a>
                                @else
                                    <button disabled class="px-4 py-2 bg-gray-200 text-gray-500 rounded-md cursor-not-allowed">
                                        Next
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
