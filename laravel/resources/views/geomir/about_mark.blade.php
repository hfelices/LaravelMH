<x-geomir-layout>
    @section('title', 'Home')
@section('content')
<style>
  .imagen:hover{
    transform: rotate(180deg);
    transition: transform 0.3s ease-in-out;
  }
  .imagen{
    transform: rotate(0deg);
    transition: transform 0.3s ease-in-out;
  }
  .imagen .divertida{
    display:none;
    /* opacity:1; */
  }
  .imagen .seria{
    /* opacity:0; */
    display:block;
  }
  .imagen:hover .seria{
    /* opacity:1; */
    display:none;
  }
  .imagen:hover .divertida{
    /* opacity:0; */
    display:block;
  }
  .divertida{
    filter: contrast(150%);
  }
  .seria{
    filter: grayscale(100%);
  }
  
  #modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      justify-content: center;
      align-items: center;
    }

    #modal-content {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      max-width: 80%;
      text-align: center;
    }

</style>
<audio id="audio_mark">
    <source src='{{ asset("audio/All Devouring Narwhal  Shadow Phase - Genshin Impact 4.2 OST.mp3")}}'>
</audio>

<div class="relative h-screen">
  <canvas id="matrix" class="h-full w-full" style="background: #000; display: block;">
  </canvas> 
  <div class="flex items-center mx-20 justify-around h-full absolute inset-0">
    
    <div class="max-w-xl bg-white p-4 rounded-md shadow-md" id="imagen">
      <div class="imagen w-1/1">
        <img  src='{{ asset("img/foto_divertida.jpg") }}' alt="Imagen 1" class="mb-4 rounded-md divertida">
        <img src='{{ asset("img/foto_seria.jpg") }}' alt="Imagen 2" class="mb-4 rounded-md seria">
      </div>
      <h2 class="text-xl font-bold mb-2">Mark López Morales</h2>
      <p class="text-gray-700 divertida">Definitivamente una descripción.</p>
    </div>
    <div id="modal">
    <div id="modal-content">
      <iframe
        width="800"
        height="450"
        src="https://www.youtube.com/embed/PQ7b6frW_vY?autoplay=1&mute=1"
        frameborder="0"
        allowfullscreen></iframe>
    </div>
  </div>

  </div>
</div>
     
    <script>


      document.addEventListener("DOMContentLoaded", function () {
    var matrix = document.getElementById("matrix");


    var imagen = document.getElementById("imagen");
    var audio = document.getElementById("audio_mark");
    imagen.addEventListener('mouseover', () => {
      console.log("hola")
        audio.play();
    })


    imagen.addEventListener('mouseout', () => {
        audio.pause();
    })


    var canvas = document.querySelector('canvas'),
            ctx = canvas.getContext('2d');

        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        var letters = 'ABCDEFGHIJKLMNOPQRSTUVXYZABCDEFGHIJKLMNOPQRSTUVXYZABCDEFGHIJKLMNOPQRSTUVXYZABCDEFGHIJKLMNOPQRSTUVXYZABCDEFGHIJKLMNOPQRSTUVXYZABCDEFGHIJKLMNOPQRSTUVXYZ';
        letters = letters.split('');
        
        var fontSize = 10,
            columns = canvas.width / fontSize;
        
        var drops = [];
        for (var i = 0; i < columns; i++) {
          drops[i] = 1;
        }
        
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
        
        setInterval(draw, 33);
});
document.getElementById('imagen').addEventListener('click', function() {
    document.getElementById('modal').style.display = 'flex';
  });


  // Función para ocultar el modal al hacer clic fuera del contenido
  document.getElementById('modal').addEventListener('click', function(e) {
    if (e.target === this) {
      this.style.display = 'none';
    }
  });

  </script>
@endsection

</x-geomir-layout>