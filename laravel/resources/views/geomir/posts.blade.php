

@include('partials.flash')

    <div class="py-12">
    @can('create', App\Models\Post::class)
    <a href="{{ route('posts.create') }}"><button class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-800 mt-2 ml-12">{{__('New')}} Post +</button></a>           
    @endcan
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                {{-- Formulario de búsqueda --}}
                <form action="{{ route('posts.index') }}" method="GET" class="mb-4">
                    @csrf
                    
                    <div class="flex">
                        <input type="text" name="search" placeholder="{{__('Search in the body of the post')}}" class="form-input flex-grow mr-2" />
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">{{__('Search')}}</button>
                    </div>
                
                </form>
                    @foreach ($posts as $post)
                        <a href="{{ route('posts.show', $post->id) }}">
                            <div class="bg-white mx-auto w-full sm:w-3/4 md:w-1/2 lg:w-1/2 xl:w-1/2 border border-gray-300 rounded-lg p-4 mb-4">
                                <div class="flex items-center mb-2">
                                    <img class="w-10 h-10 rounded-full mr-4" src='{{ asset("storage/{$post->file->filepath}") }}' alt="File Image" />
                                    <div>
                                        <p class="text-gray-800 font-semibold">{{ $post->user->name }}</p>
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-4 max-w-full break-words">{!! $post->body !!}</p>
                                <img class="w-1/1 mx-auto mb-4" src='{{ asset("storage/{$post->file->filepath}") }}' alt="File Image" />
                        </a>
                                <div class="flex justify-between text-gray-600">
                                    <p>{{ $post->created_at->diffForHumans() }}</p>
                                    @can('create', App\Models\Post::class)
                                    @if ($post->likedByUser)
                                    <form action="{{ route('posts.unlike', $post) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="flex">
                                            <p class="mr-1">{{ $post->liked_count }} </p>
                                            <button type="submit" class="btn-like">
                                                <i class="far fa-thumbs-down"></i>
                                            </button>
                                        </div>
                                        
                                    </form>
                                    @else
                                    <form action="{{ route('posts.like', $post) }}" method="POST">
                                        @csrf
                                        <div class="flex">
                                            <p class="mr-1">{{ $post->liked_count }} </p>
                                            <button type="submit" class="btn-like">
                                                <i class="fa-regular fa-thumbs-up"></i>
                                            </button>
                                        </div>
                                        
                                    </form>
                                    @endif
                                    @endcan
                                    
                                </div>
                            </div> 
                       
                    @endforeach

                   
                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>