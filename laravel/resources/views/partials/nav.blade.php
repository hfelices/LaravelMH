<div class="h-screen justify-center flex absolute bottom-0 w-full md:top-0 md:right-0 ">
    <ul class="flex justify-center items-end gap-x-2 w-full md:ml-0 p-0 md:flex md:flex-col md:items-end md:space-y-4 md:pr-4 md:justify-center">
        <li class="flex"><a href="{{ url('/posts') }}"><img class="hidden md:block w-14 h-14 rounded-full md:w-16 md:h-16" src="https://cdn-icons-png.flaticon.com/512/5720/5720464.png" alt=""></a></li>
        <li class="flex"><a href="{{ url('/posts/create') }}"><img class="hidden md:block w-14 h-14 rounded-full md:w-16 md:h-16" src="{{asset('img/post.jpg')}}" alt=""></a></li>
        <li class="flex"><a href="{{ url('/places/create') }}"><img class="hidden md:block w-14 h-14 rounded-full md:w-16 md:h-16" src="{{asset('img/map.jpg')}}" alt=""></a></li>
        <li class="flex"><a href="{{ url('/profile') }}"><img class="w-14 h-14 rounded-full md:w-16 md:h-16" src="{{asset('img/user.jpg')}}" alt=""></a></li>
        <li class="flex"><a href=""><img class="w-14 h-14 rounded-full md:w-16 md:h-16" src="{{asset('img/compass.jpg')}}" alt=""></a></li>
        <li class="flex"><a href=""><img class="w-14 h-14 rounded-full md:w-16 md:h-16" src="{{asset('img/fav.jpg')}}" alt=""></a></li>
        <li class="flex"><a href=""><img class="w-14 h-14 rounded-full md:w-16 md:h-16" src="{{asset('img/group.jpg')}}" alt=""></a></li>
        <li class="flex"><a href=""><img class="w-14 h-14 rounded-full md:w-16 md:h-16" src="{{asset('img/message.jpg')}}" alt=""></a></li>
        <!-- <li class="flex"><a href=""><x-geomir-nav-button filepath="img/message.jpg"/></a></li> -->
    </ul>
</div>