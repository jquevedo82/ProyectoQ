<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts Index') }}
        </h2>
    </x-slot>

    @php
        $favoritePostIds = [];
    @endphp
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    @auth
                        <div class="flex flex-col sm:flex-row">
                            <input type="hidden" id="auth-user-id" value="{{ auth()->id() }}">
                            <form id="favorites-form" action="{{ route('posts.getFavorites') }}" method="POST"
                                class="w-full sm:w-1/2">
                                @csrf
                                <input type="hidden" name="favorites" id="favorites-input">
                                <button type="submit"
                                    class="bg-blue-800 text-white font-bold text-sm uppercase rounded hover:bg-blue-700 px-5 py-3 mt-4 w-full hidden"
                                    id="toggle-favorites">
                                    Favoritos
                                </button>
                            </form>
                            <a href="{{ route('posts.index') }}"
                                class="bg-blue-800 text-center text-white font-bold text-sm uppercase rounded hover:bg-blue-700 px-5 py-3 mt-4 w-full sm:w-1/2"
                                id="toggle-all">
                                Todos
                            </a>

                            <a href="{{ route('posts.search') }}"
                                class="bg-blue-800 text-center text-white font-bold text-sm uppercase rounded hover:bg-blue-700 px-5 py-3 mt-4 w-full sm:w-1/2">
                                Buscar
                            </a>

                        </div>

                        <div class="flex">
                            <a href="{{ route('posts.create') }}"
                                class="bg-blue-800 text-white font-bold text-sm uppercase rounded hover:bg-blue-700 px-5 py-3 mt-4">
                                Create new post
                            </a>
                        </div>
                    @endauth


                    @forelse ($posts as $post)
                        <article class="flex flex-col shadow my-4">
                            <div class="bg-white flex flex-col justify-start p-6">
                                <a href="{{ route('posts.show', $post) }}"
                                    class="text-3xl font-bold hover:text-gray-700 pb-4">
                                    {{ $post->titulo }}
                                </a>
                                <p class="pb-6">{{ $post->texto }}</p>
                                <a href="{{ route('posts.show', $post) }}"
                                    class="uppercase text-gray-800 hover:text-black">Continue Reading <i
                                        class="fas fa-arrow-right"></i></a>
                            </div>
                            <div class="relative">
                                <img src="{{ asset('storage/img/' . $post->imagen) }}" class="w-full h-auto"
                                    alt="Imagen del post">
                                <button type="button"
                                    class="absolute top-0 right-0 mt-2 mr-2 hover:opacity-75 favorite-button"
                                    data-post-id="{{ $post->id . '_' . auth()->id() }}">
                                    @if (auth()->check())
                                        @if (in_array($post->id, $favoritePostIds))
                                            <i class="fas fa-heart text-red-500  text-3xl"></i>
                                        @else
                                            <i class="far fa-heart text-red-500  text-3xl"></i>
                                        @endif
                                    @endif
                                </button>
                            </div>
                        </article>
                    @empty
                        <article class="flex flex-col shadow my-4">
                            No existen Posts
                        </article>
                    @endforelse

                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var favoriteButtons = document.querySelectorAll('.favorite-button');
            favoriteButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {

                    var postId = this.dataset.postId;
                    var favorites = JSON.parse(localStorage.getItem('favorites')) || [];

                    var index = favorites.indexOf(postId);
                    if (index !== -1) {
                        favorites.splice(index, 1);
                        this.innerHTML = '<i class="far fa-heart text-red-500  text-3xl "></i>';
                    } else {
                        favorites.push(postId);
                        this.innerHTML = '<i class="fas fa-heart text-red-500  text-3xl"></i>';
                    }

                    localStorage.setItem('favorites', JSON.stringify(favorites));
                    document.getElementById('favorites-input').value = JSON.stringify(favorites);
                });

                var favoritePostIds = JSON.parse(localStorage.getItem('favorites')) || [];

                favoritePostIds.forEach(function(x) {
                    var favoriteButton = document.querySelector('.favorite-button[data-post-id="' +
                        x + '"]');

                    if (favoriteButton) {
                        var isFavorite = true;

                        var iconElement = favoriteButton.querySelector('i');

                        if (isFavorite) {
                            iconElement.classList.remove('far');
                            iconElement.classList.add('fas');
                        } else {
                            iconElement.classList.remove('fas');
                            iconElement.classList.add('far');
                        }
                    }
                });
                document.getElementById('favorites-input').value = JSON.stringify(favoritePostIds);
            });
            const favoritesForm = document.getElementById('favorites-form');
            const allButton = document.getElementById('toggle-all');
            const favoritesButton = document.getElementById('toggle-favorites');


            // Recuperar el estado de los botones del almacenamiento local al cargar la página
            const isFavoritesVisible = localStorage.getItem('isFavoritesVisible') === 'false';

            if (isFavoritesVisible) {
                favoritesForm.classList.remove('hidden');
                favoritesButton.classList.remove('hidden');
                allButton.classList.add('hidden');
            } else {
                allButton.classList.remove('hidden');
                favoritesForm.classList.add('hidden');
                favoritesButton.classList.add('hidden');
            }

            allButton.addEventListener('click', function() {
                favoritesForm.classList.remove('hidden');
                favoritesButton.classList.remove('hidden');
                allButton.classList.add('hidden');
                localStorage.setItem('isFavoritesVisible', 'false');
            });

            favoritesButton.addEventListener('click', function() {
                allButton.classList.remove('hidden');
                favoritesForm.classList.add('hidden');
                favoritesButton.classList.add('hidden');
                localStorage.setItem('isFavoritesVisible', 'true');
            });
        });
    </script>
</x-app-layout>
