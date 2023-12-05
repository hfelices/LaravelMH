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
        <iframe class="w-full h-full object-cover z-0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3000.888639591206!2d1.7260894999999998!3d41.2241972!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a386e33e206255%3A0x690a371d65bf15c6!2sPla%C3%A7a%20de%20la%20Vila%2C%2008800%20Vilanova%20i%20la%20Geltr%C3%BA%2C%20Barcelona!5e0!3m2!1sca!2ses!4v1701797822619!5m2!1sca!2ses"  style="border:0"></iframe>
        
    </div>
</div>
    @include('partials.nav')     
@endsection
</x-geomir-layout>