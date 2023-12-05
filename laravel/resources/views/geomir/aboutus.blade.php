<x-geomir-layout>
    @section('title', 'Home')
@section('content')
<style>
  .imagen-hector:hover{
    transform: rotate(1080deg);
    transition: transform 0.9s ease-in-out;
  }
  .imagen-hector{
    transform: rotate(0deg);
    transition: transform 0.3s ease-in-out; 
  }
  .imagen-mark:hover{
    transform: rotate(180deg);
    transition: transform 0.3s ease-in-out;
  }
  .imagen-mark{
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

  #modal-mark,#modal-hector {
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

    #modal-mark-content,#modal-hector-content  {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      max-width: 80%;
      text-align: center;
    }
</style>

<div class="relative h-screen bg-black">
  
  <canvas id="matrix" class="h-full w-full invisible" style="background: #000; display: block;">
  </canvas> 

  <div class="flex md:flex-row flex-col items-center mx-20 justify-around h-full absolute  inset-0">
    

  <div class="max-w-xl bg-white p-4 rounded-md shadow-md imagen imagen-hector" id="imagen-hector" >
      <img  src="https://img.nbc.com/files/images/2013/11/12/dwight-500x500.jpg" alt="Imagen 1" class="h-96 w-auto mb-4 rounded-md   seria">
      <img  src="https://i.pinimg.com/originals/74/30/bd/7430bd5c400e0ed5613afa2842fda124.gif" alt="Imagen 1" class=" h-96 w-auto mb-4  rounded-md  divertida">
      <h2 class="text-xl font-bold mb-2">Dwight Schrute</h2>
      <p class="text-gray-700">Assistant Regional Manager</p>
      <audio id="audio-hector" src='{{ asset("audio/Rick Astley - Never Gonna Give You Up (Official Music Video).mp3")}}'></audio>
    </div>
    
  <div class="max-w-xl bg-white p-4 rounded-md shadow-md" id="imagen-mark">
    <div class="imagen imagen-mark">
      <img  src='{{ asset("img/foto_divertida.jpg") }}' alt="Imagen 1" class="h-96 w-auto mb-4 rounded-md divertida">
      <img src='{{ asset("img/foto_seria.jpg") }}' alt="Imagen 2" class="h-96 w-auto mb-4 rounded-md seria">
    </div>
    <h2 class="text-xl font-bold mb-2">Mark López Morales</h2>
    <p class="text-gray-700">Definitivamente una descripción.</p>
  </div>

 
    <div id="modal-mark">
      <div id="modal-mark-content">
        <iframe width="800"height="450"src="https://www.youtube.com/embed/PQ7b6frW_vY?autoplay=1&mute=1"frameborder="0"allowfullscreen></iframe>
      </div>
      <audio id="audio-mark"><source src='{{ asset("audio/All Devouring Narwhal  Shadow Phase - Genshin Impact 4.2 OST.mp3")}}'></audio>
    </div>
    <div id="modal-hector">
      <div id="modal-hector-content">
        <iframe   width="800"height="450" src="https://www.youtube.com/embed/6stlCkUDG_s?autoplay=1&mute=1" frameborder="0" allowfullscreen></iframe>
      </div>
    </div>

    
    
</div>


    @include('partials.nav')
     
    <script>

    
      document.addEventListener("DOMContentLoaded", function () {
    var imagenHector = document.getElementById("imagen-hector");
    var imagenMark = document.getElementById("imagen-mark");
    var audioHector = document.getElementById("audio-hector");
    var audioMark = document.getElementById("audio-mark");
    var matrix = document.getElementById("matrix");

    imagenMark.addEventListener("mouseover", function () {
        audioMark.play();
        matrix.classList.remove("invisible");
    });

    imagenMark.addEventListener("mouseout", function () {
        audioMark.pause();
        matrix.classList.add("invisible");
      });

    imagenHector.addEventListener("mouseover", function () {
        audioHector.play();
        matrix.classList.remove("invisible");
    });

    imagenHector.addEventListener("mouseout", function () {
        audioHector.pause();
        matrix.classList.add("invisible");
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


document.getElementById('imagen-mark').addEventListener('click', function() {
    document.getElementById('modal-mark').style.display = 'flex';
  });

  
  document.getElementById('modal-mark').addEventListener('click', function(e) {
    if (e.target === this) {
      this.style.display = 'none';
    }
  });

document.getElementById('imagen-hector').addEventListener('click', function() {
    document.getElementById('modal-hector').style.display = 'flex';
  });

  
  document.getElementById('modal-hector').addEventListener('click', function(e) {
    if (e.target === this) {
      this.style.display = 'none';
    }
  });
  </script>
@endsection

</x-geomir-layout>