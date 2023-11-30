<x-app-layout>
@include('partials.flash')

    <form method="post" action="{{ route('places.update', $place)  }}" enctype="multipart/form-data" class="max-w-md mx-auto">
        @csrf
        @method('PUT')
        <img class="w-3/6" src='{{ asset("storage/{$place->file->filepath}") }}'  alt="File Image">
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Name') }}:</label>
            <input type="text" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="name" value="{{$place->name}}" required/>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Description') }}:</label>
            <input type="text" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="description" value="{{$place->description}}" required/>
        </div>
        <div class="mb-4">
            <label for="upload" class="block text-gray-700 text-sm font-bold mb-2">{{ __('File') }}:</label>
            <input type="file" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="upload"/>
        </div>
        <div class="mb-4">
            <label for="latitude" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Latitude') }}:</label>
            <input type="number" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="latitude" value="{{$place->latitude}}" required/>
        </div>
        <div class="mb-4">
            <label for="longitude" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Longitude') }}:</label>
            <input type="number" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="longitude" value="{{$place->longitude}}" required/>
        </div>
        <div class="flex space-x-4">
            @can('update', $place)
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-800">{{ __('Update') }}</button>
            <button type="reset" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-gray focus:border-gray-700 active:bg-gray-800">{{ __('Reset') }}</button>
            @endcan
            <a href="{{ route('places.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
            {{ __('Return') }}
            </a>
        </div>
    </form>
</x-app-layout>