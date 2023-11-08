<x-app-layout>
<a href="{{ route('posts.show', $post) }}"><button class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-800 mt-2 ml-12">Volver</button></a>           

<form method="post" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data" class="max-w-md mx-auto">
        @csrf
        @method('PUT')
        <div class="mb-4">
        <label for="body" class="block text-gray-700 text-sm font-bold mb-2">Body:</label>
        <textarea name="body"  id="body" rows="3" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5">{{ $post->body }}</textarea>
        </div>

    <!-- Campo File -->
    <div class="mb-4">
        <label for="upload" class="block text-gray-700 text-sm font-bold mb-2">File:</label>
        <input type="file" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="upload"/>
        <img class="w-full mb-4" src='{{ asset("storage/{$post->file->filepath}") }}' alt="File Image" />
    </div>


    <!-- Campo Latitude -->
    <div class="mb-4">
        <label for="latitude" class="block text-gray-700 text-sm font-bold mb-2">Latitude:</label>
        <input type="number" name="latitude" value="{{ $post->latitude}}" id="latitude" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
    </div>

    <!-- Campo Longitude -->
    <div class="mb-4">
        <label for="longitude" class="block text-gray-700 text-sm font-bold mb-2">Longitude:</label>
        <input type="number" name="longitude" value="{{ $post->longitude}}" id="longitude" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
    </div>

    <!-- Botones de acción -->
    <div class="flex space-x-4">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-800">Update</button>
        <button type="reset" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-gray focus:border-gray-700 active:bg-gray-800">Reset</button>
    </div>
    </form>
</x-app-layout>