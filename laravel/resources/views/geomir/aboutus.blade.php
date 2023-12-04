<x-geomir-layout>
    @section('title', 'Home')
@section('content')
<div class="relative h-screen">
  <!-- Contenido del iframe -->
  <iframe class="h-full w-full z-0" src='{{ asset("html/matrix.html") }}' frameborder="0"></iframe>

  <!-- Contenido de las cards -->
  <div class="flex items-center mx-auto justify-center h-full absolute inset-0">
    <!-- Primera Card -->
    <div class="max-w-xl bg-white p-4 rounded-md shadow-md">
      <img src="https://forbes.es/wp-content/uploads/2022/08/Never-Gonna-Give-You-Up-Rick-Astley.jpg" alt="Imagen 1" class="mb-4 rounded-md">
      <h2 class="text-xl font-bold mb-2">Título de la Card 1</h2>
      <p class="text-gray-700">Descripción de la Card 1.</p>
    </div>
    <div class="max-w-xl bg-white p-4 rounded-md shadow-md">
      <img src="https://forbes.es/wp-content/uploads/2022/08/Never-Gonna-Give-You-Up-Rick-Astley.jpg" alt="Imagen 1" class="mb-4 rounded-md">
      <h2 class="text-xl font-bold mb-2">Título de la Card 1</h2>
      <p class="text-gray-700">Descripción de la Card 1.</p>
    </div>
  </div>
</div>


    @include('partials.nav')   
     
@endsection

</x-geomir-layout>