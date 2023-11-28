<x-app-layout>
   <x-slot name="header">
       <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           {{ __('Places') }}
       </h2>
   </x-slot>


   <div class="py-12">
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center justify-center space-x-4">
                @can('create',App\Models\Place::class)
                <a href="{{ route('places.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                    + {{ __('Create') }}
                </a>
                @endcan    
            </div>
                   <table class="table">
                      <thead>
                          <tr>
                              <td scope="col">ID</td>
                              <td scope="col">{{ __('Name') }}</td>
                              <td scope="col">{{ __('Description') }}</td>
                              <td scope="col">{{ __('File') }}</td>
                              <td scope="col">{{ __('Latitude') }}</td>
                              <td scope="col">{{ __('Longitude') }}</td>
                              <td scope="col">{{ __('Author ID') }}</td>
                              <td scope="col">{{ __('Created') }}</td>
                              <td scope="col">{{ __('Updated') }}</td>
                          </tr>
                      </thead>
                      <tbody>
                            @foreach ($places as $index => $place)
                            <tr>
                                <td class="text-center text-2xl font-bold mb-4">{{$place['id']}}</td>
                                <td class="text-center w-1/6">{{ $place->name }}</td>
                                <td class="text-center w-1/6">{{ $place->description }}</td>
                                <td class="text-center w-1/6">{{ $place->file_id }} ><img class="w-3/6" src='{{ asset("storage/{$place->file->filepath}") }}'  alt="File Image" /></td>
                                <td class="text-center w-1/6">{{ $place->latitude }}</td>
                                <td class="text-center w-1/6">{{ $place->longitude }}</td>
                                <td class="text-center w-1/6">{{ $place->author_id }}</td>
                                <td class="text-center w-1/6">{{ $place->created_at }}</td>
                                <td class="text-center w-1/6">{{ $place->updated_at }}</td>
                                <td>
                                    <div class="flex items-center justify-center space-x-4">
                                        <a href="{{ route('places.show', $place->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                                        {{ __('View') }}
                                        </a>
                                        @can('update', $place)
                                        <a href="{{ route('places.edit', $place) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-yellow active:bg-yellow-800">
                                        {{ __('Edit') }}
                                        </a>
                                        @endcan
                                        @can('delete', $place)
                                        <form action="{{ route('places.destroy', $place) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-red active:bg-red-800">
                                            {{ __('Delete') }}
                                            </button>
                                        </form>
                                        @endcan
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
                                </td>
                            </tr>
                            @endforeach
                            <br>
                            <br>
                            <form action="{{ route('places.index') }}" method="GET" class="mb-4">
                            @csrf
                                <div class="flex">
                                    <input type="text" name="search" placeholder="{{ __('Search in the place body') }}" class="form-input flex-grow mr-2" />
                                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">{{ __('Search') }}</button>
                                </div>
                            </form>
                            <div class="mt-4">
                                {{$places->links()}}
                            </div>
                      </tbody>
                  </table>
               </div>
           </div>
       </div>
   </div>
</x-app-layout>