<div class="md:z-0 justify-center flex fixed bottom-3 w-full md:top-0 md:right-2 z-20">
    <ul class="flex justify-center items-end gap-x-2 w-full md:ml-0 p-0 md:flex md:flex-col md:items-end md:space-y-4 md:pr-4 md:justify-center">
        <li class="flex"><a href="{{ (request()->path() == 'posts') ? url('/places') : url('/posts') }}"><img class="hidden md:block w-14 h-14 rounded-full md:w-16 md:h-16" src="https://cdn-icons-png.flaticon.com/512/5720/5720464.png" alt=""></a></li>
        <li class="flex"><a href="{{ url('/posts/create') }}"><img class="{{ (request()->path() == 'posts') ? '' : 'hidden md:block' }} w-14 h-14 rounded-full md:w-16 md:h-16" src="{{asset('img/post.jpg')}}" alt=""></a></li>
        <li class="flex"><a href="{{ url('/places/create') }}"><img class="{{ (request()->path() == 'places') ? '' : 'hidden md:block' }} w-14 h-14 rounded-full md:w-16 md:h-16" src="{{asset('img/map.jpg')}}" alt=""></a></li>
        <li class="flex"><a href="{{ url('/profile') }}"><img class="w-14 h-14 rounded-full md:w-16 md:h-16" src="{{asset('img/user.jpg')}}" alt=""></a></li>
        <li class="flex"><a href="{{ url('/about_mark') }}"><img class="w-14 h-14 rounded-full md:w-16 md:h-16" src="{{asset('img/compass.jpg')}}" alt=""></a></li>
        <li class="flex"><a href=""><img class="w-14 h-14 rounded-full md:w-16 md:h-16" src="{{asset('img/fav.jpg')}}" alt=""></a></li>
        <li class="flex"><a href=""><img class="w-14 h-14 rounded-full md:w-16 md:h-16" src="{{asset('img/group.jpg')}}" alt=""></a></li>
        <li class="flex"><a href=""><img class="w-14 h-14 rounded-full md:w-16 md:h-16" src="{{asset('img/message.jpg')}}" alt=""></a></li>
        <!-- <li class="flex"><a href=""><x-geomir-nav-button filepath="img/message.jpg"/></a></li> -->
    </ul>
</div>