<x-app-layout>
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-1/5">
            <p class="text-center text-2xl font-bold mb-4">{{$file['id']}}</p>
            <img src='{{ asset("storage/{$file->filepath}") }}' class="mx-auto mb-4" alt="File Image" />
            <p class="text-center">Filesize: {{$file['filesize']}}</p>
            <p class="text-center">Created at: {{$file['created_at']}}</p>
            <p class="text-center">Last time updated: {{$file['updated_at']}}</p>
            <div class="flex items-center justify-center mt-2 space-x-4">
                <a href="{{ route('files.edit', $file->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-yellow active:bg-yellow-800">
                    Editar
                </a>
                
                <form action="{{ route('files.destroy', $file->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-red active:bg-red-800">
                        Eliminar
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</x-app-layout>