<x-app-layout>
@include('partials.flash')

    <div class="min-h-screen flex items-center justify-center">
            <div class="w-1/5">
            @if(session('success'))
                <div class="alert alert-success">
            {{ session('success') }}
            </div>
            @endif
            <p class="text-center text-2xl font-bold mb-4">{{$place['id']}}</p>
            <img src='{{ asset("storage/{$place->file->filepath}") }}' class="mx-auto mb-4" alt="File Image" />
            <p class="text-center">{{ __('Name') }}: {{$place['name']}}</p>
            <p class="text-center">{{ __('Description') }}: {{$place['description']}}</p>
            <p class="text-center">{{ __('File') }}: {{$place['file_id']}}</p>
            <p class="text-center">{{ __('Latitude') }}: {{$place['latitude']}}</p>
            <p class="text-center">{{ __('Longitude') }}: {{$place['longitude']}}</p>
            <p class="text-center">{{ __('Author ID') }}: {{$place['author_id']}}</p>
            <p class="text-center">{{ __('Created') }}: {{$place['created_at']}}</p>
            <p class="text-center">{{ __('Updated') }}: {{$place['updated_at']}}</p>
            <div class="flex items-center justify-center mt-2 space-x-4">
                @can('update',$place)
                <a href="{{ route('places.edit', $place->id) }}" class="bg-yellow-500 hover:bg-yellow-700 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-yellow active:bg-yellow-800">
                {{ __('Edit') }}
                </a>
                @endcan
                @can('delete', $place)
                <form action="{{ route('places.destroy', $place->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-red active:bg-red-800">
                    {{ __('Delete') }}
                    </button>
                    
                </form>

                @endcan
                <form action="{{ route('places.favorite', $place->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @if ($userFav)
                    <button type="submit" class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                        {{ $favorites }} <i class="fa-solid fa-heart"></i>
                    </button>

                    @else
                    <button type="submit" class="bg-yellow-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                        {{ $favorites }} <i class="fa-regular fa-heart"></i>
                    </button>
                    @endif
                </form>


                <a href="{{ route('places.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                {{ __('Return') }}
                </a>

            </div>
            
        </div>
    </div>
    <div class="mt-2 ml-20 pb-20 items-center justify-center">
    <h1>Comentarios</h1>
    <form action="{{ route('reviews.store', $place->id) }}" method="POST" style="display: inline;">
    @csrf
    <div class="mb-4">
            <label for="body" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Body') }}:</label>
            <input type="text" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="body" required/>
            <div id=descriptionError class="text-red-500"> </div>
        </div>
    <button type="submit" class="bg-yellow-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
        Añadir comentario
    </button>
</form>
    <hr>
    @if ($reviews->count() > 0)
        
        @foreach($reviews as $index => $review)
        <div class="bg-white mx-auto w-full sm:w-3/4 md:w-1/2 lg:w-1/2 xl:w-1/2 border border-gray-300 rounded-lg p-4  mt-6">
            <h2>{{$review->user->name }}</h2>
            <p>{{$review->body}}</p>
            
            @can('delete', $review)
                <form action="{{ route('reviews.destroy', $review->id)  }}" method="POST" onsubmit="return confirm('¿Estás seguro?')" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-red active:bg-red-800">
                    {{ __('Delete') }}
                    </button>
                    
                </form>

                @endcan
        </div>
        @endforeach

    @else
    <h1>No hay comentarios aún</h1>
    @endif
</div>
</x-app-layout>