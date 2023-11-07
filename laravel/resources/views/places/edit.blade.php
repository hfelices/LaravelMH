<x-app-layout>
    <form method="post" action="{{ route('places.update', $place)  }}" enctype="multipart/form-data" class="max-w-md mx-auto">
        @csrf
        @method('PUT')
        <img class="w-3/6" src='{{ asset("storage/{$place->file->filepath}") }}'  alt="File Image">
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
            <input type="text" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="name" value="{{$place->name}}" required/>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
            <input type="text" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="description" value="{{$place->description}}" required/>
        </div>
        <div class="mb-4">
            <label for="upload" class="block text-gray-700 text-sm font-bold mb-2">File:</label>
            <input type="file" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="upload"/>
        </div>
        <div class="mb-4">
            <label for="latitude" class="block text-gray-700 text-sm font-bold mb-2">Latitude:</label>
            <input type="number" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="latitude" value="{{$place->latitude}}" required/>
        </div>
        <div class="mb-4">
            <label for="longitude" class="block text-gray-700 text-sm font-bold mb-2">Longitude:</label>
            <input type="number" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="longitude" value="{{$place->longitude}}" required/>
        </div>
        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-800">Update</button>
            <button type="reset" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-gray focus:border-gray-700 active:bg-gray-800">Reset</button>
            <a href="{{ route('places.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                    Volver
                </a>
        </div>
    </form>
</x-app-layout>