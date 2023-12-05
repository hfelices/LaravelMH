<x-geomir-layout>
    @section('title', 'Home')
@section('content')
<style>
  .imagen:hover{
    transform: rotate(1080deg);
    transition: transform 0.9s ease-in-out;
  }
  .imagen{
    transform: rotate(0deg);
    transition: transform 0.3s ease-in-out;
    
  }
  .imagen .divertida{
    display:none;
   
  }
  .imagen .seria{
   
    display:block;
  }
  .imagen:hover .seria{
   
    display:none;
  }
  .imagen:hover .divertida{
    
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

<div class="relative h-screen">
  
  <canvas id="matrix" class="h-full w-full invisible" style="background: #000; display: block;">
  </canvas> 

  <div class="flex md:flex-row flex-col items-center mx-20 justify-around h-full absolute  inset-0">
    
    <div class="max-w-xl bg-white p-4 rounded-md shadow-md imagen" id="imagen" >
      <img  src="https://img.nbc.com/files/images/2013/11/12/dwight-500x500.jpg" alt="Imagen 1" class="mb-4 rounded-md   seria">
      <img  src="https://i.pinimg.com/originals/74/30/bd/7430bd5c400e0ed5613afa2842fda124.gif" alt="Imagen 1" class="mb-4  rounded-md  divertida">
      <h2 class="text-xl font-bold mb-2">Dwight Schrute</h2>
      <p class="text-gray-700">Assistant Regional Manager</p>
      <audio id="audio" src='{{ asset("audio/Rick Astley - Never Gonna Give You Up (Official Music Video).mp3")}}'></audio>
    </div>
    
   
    <div id="modal">
      <div id="modal-content">
        <iframe  class="h-60 w-96" src="https://www.youtube.com/embed/6stlCkUDG_s?autoplay=1&mute=1" frameborder="0" allowfullscreen></iframe>
      </div>
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

    imagen.addEventListener("mouseout", function () {
        audio.pause();
        // audio.currentTime = 0; 
    });



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




document.getElementById('imagen').addEventListener('click', function() {
    document.getElementById('modal').style.display = 'flex';
  });

  
  document.getElementById('modal').addEventListener('click', function(e) {
    if (e.target === this) {
      this.style.display = 'none';
    }
  });
  </script>
@endsection

</x-geomir-layout>