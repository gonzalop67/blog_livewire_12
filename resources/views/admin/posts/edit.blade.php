<x-layouts.app :title="__('Posts')">

    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('admin.posts.index') }}">Posts</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form action="{{ route('admin.posts.update', $post) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="relative mb-2">
            @php
                $ruta = dirname(dirname(__FILE__));
            @endphp

            <img id="imgPreview" class="w-full aspect-video object-cover" src="{{ $post->image_path ? Storage::url($post->image_path) : "https://placehold.co/90x160?text=Imagen+Post" }}" alt="">

            <div class="absolute top-8 right-8">
                <label class="bg-white px-4 py-2 rounded-lg cursor-pointer">
                    Cambiar imagen
                    <input class="hidden" type="file" name="image" accept="image/*" onchange="previewImage(event, '#imgPreview')">
                </label>
            </div>
        </div>
        
        <div class="card" class="space-y-4">
            <flux:input label="Título" name="title" value="{{ old('title', $post->title) }}"
                placeholder="Escriba el título del post" />

            <flux:input label="Slug" id="slug" name="slug" value="{{ old('slug', $post->slug) }}"
                placeholder="Escriba el slug del post" />

            <flux:select label="Categoría" name="category_id">
                @foreach ($categories as $category)
                    <flux:select.option value="{{ $category->id }}"
                        :selected="$category->id == old('category_id', $post->category_id)">
                        {{ $category->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:textarea label="Resumen" name="excerpt">{{ old('excerpt', $post->excerpt) }}</flux:textarea>

            <flux:textarea label="Contenido" name="content" rows="16">{{ old('content', $post->content) }}
            </flux:textarea>

            <div class="space-x-3">
                <label>
                    <input type="radio" name="is_published" value="0" @checked(old('is_published', $post->is_published) == 0)>
                    <span class="ml-1">
                        No pubicado
                    </span>
                </label>

                <label>
                    <input type="radio" name="is_published" value="1" @checked(old('is_published', $post->is_published) == 1)>
                    <span class="ml-1">
                        Pubicado
                    </span>
                </label>
            </div>

            <div class="flex justify-end">
                <flux:button variant="primary" type="submit">
                    Enviar
                </flux:button>
            </div>
        </div>
    </form>

    @push('js')
        <script>
            function previewImage(event, querySelector){

                //Recuperamos el input que desencadeno la acción
                let input = event.target;
                
                //Recuperamos la etiqueta img donde cargaremos la imagen
                let imgPreview = document.querySelector(querySelector);

                // Verificamos si existe una imagen seleccionada
                if(!input.files.length) return
                
                //Recuperamos el archivo subido
                let file = input.files[0];

                //Creamos la url
                let objectURL = URL.createObjectURL(file);
                
                //Modificamos el atributo src de la etiqueta img
                imgPreview.src = objectURL;
                            
            }
        </script>
    @endpush

</x-layouts.app>
