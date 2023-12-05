

@include('partials.flash')

    <div class="h-screen">
    {{-- @can('create', App\Models\place::class)
    <a href="{{ route('places.create') }}"><button class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-800 mt-2 ml-12">{{__('New')}} place +</button></a>           
    @endcan --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="background-image: url('{{ asset('img/fondos/04.jpg') }}'); background-size: cover; background-position: center;">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg"  >
                <div class="p-6  border-b border-gray-200 transparent">
                {{-- Formulario de búsqueda --}}
                <form action="{{ route('places.index') }}" method="GET" class="mb-4">
                    @csrf
                    
                    <div class="flex">
                        <input type="text" name="search" placeholder="{{__('Search in the body of the place')}}" class="form-input flex-grow mr-2" />
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">{{__('Search')}}</button>
                    </div>
                
                </form>
                    @foreach ($places as $place)
                        <a href="{{ route('places.show', $place->id) }}">
                            <div class=" bg-white mx-auto w-3/4 border border-gray-300 rounded-lg p-4 mb-4">
                                <div class="flex items-center mb-2">
                                    <img class="w-10 h-10 rounded-full mr-4" src='{{ asset("storage/{$place->file->filepath}") }}' alt="File Image" />
                                    <div>
                                        <p class="text-gray-800 font-semibold">{{ $place->user->name }}</p>
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-4 max-w-full break-words">{!! $place->description !!}</p>
                                <img class="w-1/1 mx-auto mb-4" src='{{ asset("storage/{$place->file->filepath}") }}' alt="File Image" />
                        </a>
                                <div class="flex justify-between text-gray-600">
                                    <p>{{ $place->created_at->diffForHumans() }}</p>
                                    @can('create',App\Models\Place::class)
                                        <form action="{{ route('places.favorite', $place->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @if ( $place->favoritedByUser )
                                                <button type="submit" class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                                                    {{ $place->favorited_count }} <i class="fa-solid fa-heart"></i>
                                                </button>
                                            @else
                                                <button type="submit" class="bg-yellow-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                                                    {{ $place->favorited_count }} <i class="fa-regular fa-heart"></i>
                                                </button>
                                            @endif
                                        </form>
                                        @endcan
                                    
                                </div>
                            </div> 
                       
                    @endforeach

                   
                    <div class="mt-4">
                        {{ $places->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>