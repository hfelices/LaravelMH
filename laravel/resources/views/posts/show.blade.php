<x-app-layout>
    
@include('partials.flash')

<a href="{{ route('posts.index') }}"><button class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-800 mt-2 ml-12">Volver</button></a>           
<div class="flex items-center justify-center space-x-4 mt-2"> 
    @can('update',$post) 
    <a href="{{ route('posts.edit', $post) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-yellow active:bg-yellow-800">
        {{__('Edit')}}
    </a>
    @endcan
    @can('delete',$post)
    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-red active:bg-red-800">
            {{__('Delete')}}
        </button>
    </form>
    @endcan
</div>
<div class="bg-white mx-auto w-full sm:w-3/4 md:w-1/2 lg:w-1/2 xl:w-1/2 border border-gray-300 rounded-lg p-4  mt-6">
    <div class="flex items-center mb-2">
        <img class="w-10 h-10 rounded-full mr-4" src='{{ asset("storage/{$post->file->filepath}") }}' alt="File Image" />
        
        <p class="text-gray-800 font-semibold">{{ $post->user->name }}</p>
        
    </div>
    <div class="flex">
        <div class="w-1/3 mr-2">
            <p class="text-gray-700 max-w-full break-words">{!! $post->body !!}</p>
        </div>
        <div class="w-2/3">
            <img class="w-full mb-4" src='{{ asset("storage/{$post->file->filepath}") }}' alt="File Image" />
        </div>
    </div>
    <div class="flex justify-between text-gray-600">
        <p>{{ $post->created_at->diffForHumans() }}</p>
        @can('create', App\Models\Post::class)
        @if ($likedByUser)
        <form action="{{ route('posts.unlike', $post) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex">
                <p class="mr-1">{{ $likes }} </p>
                <button type="submit" class="btn-like">
                    <i class="far fa-thumbs-down"></i>
                </button>
            </div>
            
        </form>
        @else
        <form action="{{ route('posts.like', $post) }}" method="POST">
            @csrf
            <div class="flex">
                <p class="mr-1">{{ $likes }} </p>
                <button type="submit" class="btn-like">
                    <i class="fa-regular fa-thumbs-up"></i>
                </button>
            </div>
            
        </form>
        @endif
        @endcan
    </div>
    <button id="toggleButton" class="bg-blue-500 text-white px-4 py-2 rounded">Comentar</button>

    <div id="commentForm" class="form_comment hidden">
        <form id="create-comment-form" method="post" action="{{ route('comment.store', ['post' => $post]) }}" enctype="multipart/form-data" class="max-w-md mx-auto">
        @csrf    
        <label for="body" class="block text-gray-700 text-sm font-bold mb-2">{{__('Body')}}:</label>
            <textarea name="body" id="body" rows="3" class="form-input py-2 px-4 block w-full leading-5 rounded-md transition duration-150 ease-in-out sm:text-sm sm:leading-5"></textarea>
            <div id=bodyError class="text-red-500"> </div>
            <div class="flex mt-2 space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-800">{{__('Create')}}</button>
                <button type="reset" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-gray focus:border-gray-700 active:bg-gray-800">{{__('Reset')}}</button>
            </div>
        </form>
    </div>
    <div>
        @foreach($comments as $comment)
        <div class="bg-white shadow-lg shadow-cyan-600 rounded-lg p-4 mb-4">
            <p class="font-bold">{{ $comment->author->name }}:</p>
            <p>{{ $comment->body }}</p>
            @can('delete',$comment)
            <form action="{{ route('comment.destroy', $comment) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-red active:bg-red-800">
                    {{__('Delete')}}
                </button>
            </form>
            @endcan
        </div>
        
        @endforeach
    </div>
</div>
<script>
  document.getElementById('toggleButton').addEventListener('click', function() {
    var commentForm = document.getElementById('commentForm');
    commentForm.classList.toggle('hidden'); // Toggle la clase 'hidden'
  });
</script>
</x-app-layout>