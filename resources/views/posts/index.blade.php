<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts Index') }}
        </h2>
    </x-slot>
    @auth
        <input type="hidden" id="auth-user-id" value="{{ auth()->id() }}">
    @endauth
    @php
        $favoritePostIds = [];
    @endphp
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    @auth
                        <input type="hidden" id="auth-user-id" value="{{ auth()->id() }}">
                        @endauth @auth
                        <input type="hidden" id="auth-user-id" value="{{ auth()->id() }}">
                        <form id="favorites-form" action="{{ route('posts.getFavorites') }}" method="POST">
                            @csrf
                            <input type="hidden" name="favorites" id="favorites-input">
                            <button type="submit"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Favoritos</button>
                        </form>
                        <a href="{{ route('posts.index') }}"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Todos</a>
                    @endauth
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        Titulo
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        Texto
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Compartir</span>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Favoritos</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 ">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white post">
                                        {{ $post->id }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $post->titulo }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $post->texto }}
                                    </td>
                                    @if (auth()->check())
                                        <td class="px-6 py-4">
                                            <a href="#" class="favorite-button"
                                                data-post-id="{{ $post->id . '_' . auth()->id() }}">
                                                @if (in_array($post->id, $favoritePostIds))
                                                    <i class="fas fa-star text-yellow-500"></i>
                                                @else
                                                    <i class="far fa-star text-yellow-500"></i>
                                                @endif
                                            </a>
                                        </td>
                                        <div class="share-buttons">
                                            <td class="px-6 py-4">
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                                                    target="_blank" rel="noopener noreferrer">
                                                    <i class="fab fa-facebook"></i>
                                                </a>
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl() . '/' . $post->id) }}"
                                                    target="_blank" rel="noopener noreferrer">
                                                    <i class="fab fa-twitter"></i>
                                                </a>
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="https://www.linkedin.com/shareArticle?url={{ urlencode(request()->fullUrl())}}"
                                                    target="_blank" rel="noopener noreferrer">
                                                    <i class="fab fa-linkedin"></i>
                                                </a>
                                            </td>

                                        </div>

                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td colspan="5" class="px-6 py-4  text-center items-center">No existen Posts
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('posts.create') }}"
                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Nuevo Post</a>
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
                        this.innerHTML = '<i class="far fa-star text-yellow-500 "></i>';
                    } else {
                        favorites.push(postId);
                        this.innerHTML = '<i class="fas fa-star text-yellow-500"></i>';
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

        });
    </script>
</x-app-layout>
