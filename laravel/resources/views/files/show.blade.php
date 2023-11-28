<x-app-layout>

<a href="{{ route('files.index') }}"><button class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-800 mt-2 ml-12">Volver</button></a>           

    <div class="min-h-screen flex items-center justify-center">
        <div class="w-1/5">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <p class="text-center text-2xl font-bold mb-4">{{$file['id']}}</p>
            <img src='{{ asset("storage/{$file->filepath}") }}' class="mx-auto mb-4" alt="File Image" />
            <p class="text-center">{{ __('Filesize') }}: {{$file['filesize']}}</p>
            <p class="text-center">{{ __('Created') }}: {{$file['created_at']}}</p>
            <p class="text-center">{{ __('Updated') }}: {{$file['updated_at']}}</p>
            <div class="flex items-center justify-center mt-2 space-x-4">
                
                @can('update', $file)
                <a href="{{ route('files.edit', $file->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-yellow active:bg-yellow-800">
                {{ __('Edit') }}
                </a>
                @endcan
                @can('delete', $file)
                <form action="{{ route('files.destroy', $file->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-red active:bg-red-800">
                    {{ __('Delete') }}
                    </button>
                </form>
                @endcan
            </div>
            
        </div>
    </div>
</x-app-layout>