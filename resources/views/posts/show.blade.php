<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts Mostrar') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <div class="flex flex-col w-full my-4">
                        <div class="flex flex-col mt-5">
                            <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">Titulo</label>
                            {{ $post->titulo }}

                        </div>
                        <div class="flex flex-col mt-5">
                            <label for="texto" class="block text-gray-700 text-sm font-bold mb-2">Texto</label>
                            {{ $post->texto }}

                        </div>
                        <div class="flex flex-col mt-5">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="imagen">Imagen</label>
                            <img src="{{ asset('storage/img/' . $post->imagen) }}" alt="Imagen del post"
                                class="w-full h-auto">
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex items-center space-x-4">
                    <div x-data="{ open: false }" @click.away="open = false" class="relative">
                        <button @click="open = !open" class="bg-gray-200 px-4 py-2 rounded focus:outline-none focus:bg-gray-300">
                            Compartir
                        </button>
                        <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 divide-y divide-gray-200 rounded-md shadow-lg flex flex-col">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl() . '/' . $post->id) }}" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-facebook"></i>Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl() . '/' . $post->id) }}" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-twitter"></i>Twitter
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?url={{ urlencode(request()->fullUrl() . '/' . $post->id) }}" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-linkedin"></i>LinkedIn
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
