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

    <a href="{{ route('posts.index') }}"><button class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-800 mt-2 ml-12">Volver</button></a>
    <form id="create-post-form" method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="max-w-md mx-auto">
        @csrf
        <div class="mb-4">
        <label for="body" class="block text-gray-700 text-sm font-bold mb-2">{{__('Body')}}:</label>
        <textarea name="body" id="body" rows="3" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5"></textarea>
        <div id=bodyError class="text-red-500"> </div>
        </div>

        <!-- Campo File -->
        <div class="mb-4">
            <label for="upload" class="block text-gray-700 text-sm font-bold mb-2">{{__('File')}}:</label>
            <input type="file" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="upload"/>
            <div id=uploadError class="text-red-500"> </div>
        </div>

        <!-- Campo Latitude -->
        <div class="mb-4">
            <label for="latitude" class="block text-gray-700 text-sm font-bold mb-2">{{__('Latitude')}}:</label>
            <input type="number" name="latitude" value="41.23115728107173" id="latitude" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
            <div id=latitudeError class="text-red-500"> </div>
        </div>

        <!-- Campo Longitude -->
        <div class="mb-4">
            <label for="longitude" class="block text-gray-700 text-sm font-bold mb-2">{{__('Longitude')}}:</label>
            <input type="number" name="longitude" value="1.7281609145235874" id="longitude" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
            <div id=longitudeError class="text-red-500"> </div>   
        </div>

        <!-- Botones de acción -->
        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-800">{{__('Create')}}</button>
            <button type="reset" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-gray focus:border-gray-700 active:bg-gray-800">{{__('Reset')}}</button>
        </div>
    </form>
 
</x-app-layout>
