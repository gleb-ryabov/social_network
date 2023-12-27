<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Список пользователей') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @foreach($users as $user)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <a href = "{{route('profile.show', $user->id)}}">
                        <div class="max-w-xl">
                                {{$user->email}}
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

</x-app-layout>
