<x-geomir-layout>
    @section('title', 'Home')
@section('content')
    
<div class="flex h-screen overflow-hidden">
    <div class="w-7/12 overflow-y-auto z-10 noScrollbar">  
        @if(isset($posts))
            @include('geomir.posts')
        @elseif(isset($places))
            @include('geomir.places')
        @endif
    </div>
    <div class="w-5/12 relative">
        <img class="w-full h-full object-cover z-[-10]" src="{{ asset('img/barcelona_centro.jpg') }}" alt="">
    </div>
</div>
    @include('partials.nav')     
@endsection
</x-geomir-layout>