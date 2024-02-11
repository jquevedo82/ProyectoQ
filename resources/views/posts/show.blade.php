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
                            <img src="{{ asset('storage/img/' . $post->imagen) }}" alt="Imagen del post" width="400" height="300">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
