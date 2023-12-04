<x-geomir-layout>
    @section('title', 'Home')
@section('content')
    
<div class="flex h-screen overflow-hidden">
    
    <div class="scrollArea md:w-7/12 w-full overflow-y-auto z-10 noScrollbar">
        @if(isset($posts))
            @include('geomir.posts')
        @elseif(isset($places))
            @include('geomir.places')
        @endif
    </div>

    <!-- Div en dispositivos grandes y pequeños -->
    <div class="md:w-5/12 md:block hidden relative">
        <img class="w-full h-full object-cover z-[-10]" src="{{ asset('img/barcelona_centro.jpg') }}" alt="">
    </div>
</div>
    @include('partials.nav')     
@endsection
</x-geomir-layout>