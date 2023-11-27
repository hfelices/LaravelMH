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
    
    <form method="post" action="{{ route('places.store') }}" enctype="multipart/form-data" class="max-w-md mx-auto">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
            <input type="text" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="name"/>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
            <input type="text" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="description"/>
        </div>
        <div class="mb-4">
            <label for="upload" class="block text-gray-700 text-sm font-bold mb-2">File:</label>
            <input type="file" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="upload"/>
        </div>
        <div class="mb-4">
            <label for="latitude" class="block text-gray-700 text-sm font-bold mb-2">Latitude:</label>
            <input type="number" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="latitude"/>
        </div>
        <div class="mb-4">
            <label for="longitude" class="block text-gray-700 text-sm font-bold mb-2">Longitude:</label>
            <input type="number" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="longitude"/>
        </div>
        @can('create')
        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-800">Create</button>
            <button type="reset" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-gray focus:border-gray-700 active:bg-gray-800">Reset</button>
        </div>
        @endcan
    </form>
 
</x-app-layout>
