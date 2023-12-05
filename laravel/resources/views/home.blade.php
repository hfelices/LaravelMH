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
        <iframe class="w-full h-full object-cover z-0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d23215.640104711196!2d1.7282362004974146!3d41.23116493697484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zM0nCsDAyJzA1LjQiTiAxwrAzMCczMy41Ilc!5e0!3m2!1sen!2sus!4v1638561261762!5m2!1sen!2sus" width="940" height="350" style="border:0"></iframe>
    </div>
</div>
    @include('partials.nav')     
@endsection
</x-geomir-layout>