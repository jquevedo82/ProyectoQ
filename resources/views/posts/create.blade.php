<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts Crear') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <form action="{{ route('posts.store') }}" method="post"  enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col w-full my-4">
                            <div class="flex flex-col mt-5">
                                <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">Titulo</label>
                                <input id="titulo"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror"
                                    type="text" name="titulo" placeholder="Escriba Titulo aqui"
                                    value="{{ old('titulo') }}">
                                @error('titulo')
                                    <p class="text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex flex-col mt-5">
                                <label for="texto" class="block text-gray-700 text-sm font-bold mb-2">Texto</label>
                                <textarea id="texto" name="texto"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('body') border-red-500 @enderror"
                                    placeholder="Escriba el Texto aqui" rows="5">{{ old('texto') }}</textarea>
                                @error('texto')
                                    <p class="text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex flex-col mt-5">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="imagen">Cargar Imagen</label>
                                <input
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    id="imagen" name="imagen" type="file" >
                                @error('imagen')
                                    <p class="text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="flex flex-row">
                            <button type="submit"
                                class="bg-blue-800 text-white font-bold text-sm uppercase rounded hover:bg-blue-700 flex items-center justify-center px-5 py-3 mt-4">Save
                                post</button>
                            <button type="reset"
                                class="text-sm uppercase rounded flex items-center justify-center px-5 py-3 mt-4">Reset</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


</x-app-layout>
