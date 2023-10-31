<x-app-layout>
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-1/5">
            <p class="text-center text-2xl font-bold mb-4">{{$file['id']}}</p>
            <img src='{{ asset("storage/{$file->filepath}") }}' class="mx-auto mb-4" alt="File Image" />
            <p class="text-center">Filesize: {{$file['filesize']}}</p>
            <p class="text-center">Created at: {{$file['created_at']}}</p>
            <p class="text-center">Last time updated: {{$file['updated_at']}}</p>
        </div>
    </div>
</x-app-layout>