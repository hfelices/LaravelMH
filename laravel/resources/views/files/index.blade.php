<x-app-layout>
   <x-slot name="header">
       <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           {{ __('Files') }}
       </h2>
   </x-slot>


   <div class="py-12">
        @can('create',App\Models\File::class)
        <a href="{{ route('files.create') }}"><button class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-800 mt-2 ml-12">Nuevo File +</button></a>           
        @endcan
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table">
                       <thead>
                            <tr>
                              <td scope="col">ID</td>
                              <td scope="col">{{ __('Filepath') }}</td>
                              <td scope="col">{{ __('Filesize') }}</td>
                              <td scope="col">{{ __('Created') }}</td>
                              <td scope="col">{{ __('Updated') }}</td>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($files as $file)
                          <tr>
                                <td class="w-1/6">{{ $file->id }}</td>
                                <td class="w-1/6"><img class="w-3/6" src='{{ asset("storage/{$file->filepath}") }}'  alt="File Image" /></td>
                                <td class="w-1/6">{{ $file->filesize }}</td>
                                <td class="w-1/6">{{ $file->created_at }}</td>
                                <td class="w-1/6">{{ $file->updated_at }}</td>
                                <td>
                                    <div class="flex items-center justify-center space-x-4">
                                        <a href="{{ route('files.show', $file->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                                        {{ __('View') }}
                                        </a>
                                        
                                        @can('update', $file)
                                        <a href="{{ route('files.edit', $file) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-yellow active:bg-yellow-800">
                                        {{ __('Edit') }}
                                        </a>
                                        @endcan
                                        
                                        @can('delete', $file)
                                        <form action="{{ route('files.destroy', $file) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-red active:bg-red-800">
                                            {{ __('Delete') }}
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
               </div>
           </div>
       </div>
   </div>
</x-app-layout>