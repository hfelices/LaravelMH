<x-app-layout>
    @if ($errors->any())
    <div>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    </div>
    @endif

    @include('partials.flash')

    <form method="post" action="{{ route('places.store') }}" enctype="multipart/form-data" class="max-w-md mx-auto">
        @csrf
        @if(session('fails'))
        <div class="alert alert-fails">
            {{ session('fails') }}
        </div>
        @endif
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Name') }}:</label>
            <input type="text" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="name"/>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Description') }}:</label>
            <input type="text" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="description"/>
        </div>
        <div class="mb-4">
            <label for="upload" class="block text-gray-700 text-sm font-bold mb-2">{{ __('File') }}:</label>
            <input type="file" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="upload"/>
        </div>
        <div class="mb-4">
            <label for="latitude" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Latitude') }}:</label>
            <input type="number" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="latitude"/>
        </div>
        <div class="mb-4">
            <label for="longitude" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Longitude') }}:</label>
            <input type="number" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="longitude"/>
        </div>
        @can('create',App\Models\Place::class)
        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-800">{{ __('Create') }}</button>
            <button type="reset" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-gray focus:border-gray-700 active:bg-gray-800">{{ __('Reset') }}</button>
        </div>
        @endcan
    </form>
 
</x-app-layout>
