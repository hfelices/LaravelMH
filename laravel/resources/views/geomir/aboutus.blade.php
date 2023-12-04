<x-geomir-layout>
    @section('title', 'Home')
@section('content')
<div class="relative h-screen">
  <!-- Contenido del iframe -->
  <canvas id="matrix" class="h-full w-full invisible" style="background: #000; display: block;">
  </canvas> 
  <!-- Contenido de las cards -->
  <div class="flex items-center mx-20 justify-around h-full absolute  inset-0">
    
    <div class="max-w-xl bg-white p-4 rounded-md shadow-md" id="imagen">
      <img  src="https://img.nbc.com/files/images/2013/11/12/dwight-500x500.jpg" alt="Imagen 1" class="mb-4 rounded-md">
      <h2 class="text-xl font-bold mb-2">Título de la Card 1</h2>
      <p class="text-gray-700">Descripción de la Card 1.</p>
      <audio id="audio" src='{{ asset("audio/Rick Astley - Never Gonna Give You Up (Official Music Video).mp3")}}'></audio>
    </div>
    <div class="max-w-xl bg-white p-4 rounded-md shadow-md">
      <img src="https://www.paperflite.com/sites/default/files/inline-images/tumblr_df754ac3e0c09bc5957dd9b17c08dba8_af889488_400.gif" alt="Imagen 1" class="mb-4 rounded-md">
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
     
    <script>


      document.addEventListener("DOMContentLoaded", function () {
    var imagen = document.getElementById("imagen");
    var audio = document.getElementById("audio");
    var matrix = document.getElementById("matrix");


    imagen.addEventListener("mouseover", function () {
        audio.play();
        matrix.classList.remove("invisible");
    });

    // imagen.addEventListener("mouseout", function () {
    //     audio.pause();
    //     audio.currentTime = 0; 
    // });



    var canvas = document.querySelector('canvas'),
            ctx = canvas.getContext('2d');
        
        // Setting the width and height of the canvas
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        
        // Setting up the letters
        var letters = 'ABCDEFGHIJKLMNOPQRSTUVXYZABCDEFGHIJKLMNOPQRSTUVXYZABCDEFGHIJKLMNOPQRSTUVXYZABCDEFGHIJKLMNOPQRSTUVXYZABCDEFGHIJKLMNOPQRSTUVXYZABCDEFGHIJKLMNOPQRSTUVXYZ';
        letters = letters.split('');
        
        // Setting up the columns
        var fontSize = 10,
            columns = canvas.width / fontSize;
        
        // Setting up the drops
        var drops = [];
        for (var i = 0; i < columns; i++) {
          drops[i] = 1;
        }
        
        // Setting up the draw function
        function draw() {
          ctx.fillStyle = 'rgba(0, 0, 0, .1)';
          ctx.fillRect(0, 0, canvas.width, canvas.height);
          for (var i = 0; i < drops.length; i++) {
            var text = letters[Math.floor(Math.random() * letters.length)];
            ctx.fillStyle = '#0f0';
            ctx.fillText(text, i * fontSize, drops[i] * fontSize);
            drops[i]++;
            if (drops[i] * fontSize > canvas.height && Math.random() > .95) {
              drops[i] = 0;
            }
          }
        }
        
        // Loop the animation
        setInterval(draw, 33);
});
  </script>
@endsection

</x-geomir-layout>