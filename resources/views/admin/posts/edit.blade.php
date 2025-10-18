<x-layouts.app :title="__('Posts')">

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    @endpush

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

            <img id="imgPreview" class="w-full aspect-video object-cover"
                src="{{ $post->image_path ? Storage::url($post->image_path) : 'https://placehold.co/90x160?text=Imagen+Post' }}"
                alt="">

            <div class="absolute top-8 right-8">
                <label class="bg-white px-4 py-2 rounded-lg cursor-pointer">
                    Cambiar imagen
                    <input class="hidden" type="file" name="image" accept="image/*"
                        onchange="previewImage(event, '#imgPreview')">
                </label>
            </div>
        </div>

        <div class="card" class="space-y-4">
            <flux:input class="mb-4" label="Título" name="title" value="{{ old('title', $post->title) }}"
                placeholder="Escriba el título del post" />

            <flux:input class="mb-4" label="Slug" id="slug" name="slug"
                value="{{ old('slug', $post->slug) }}" placeholder="Escriba el slug del post" />

            <flux:select class="mb-4" label="Categoría" name="category_id">
                @foreach ($categories as $category)
                    <flux:select.option value="{{ $category->id }}"
                        :selected="$category->id == old('category_id', $post->category_id)">
                        {{ $category->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:textarea class="mb-4" label="Resumen" name="excerpt">{{ old('excerpt', $post->excerpt) }}
            </flux:textarea>

            {{-- <flux:textarea class="mb-4" label="Contenido" name="content" rows="16">
                {{ old('content', $post->content) }}
            </flux:textarea> --}}

            <div class="mb-4">
                <p class="font-medium text-sm mb-1">
                    Contenido
                </p>

                <div id="editor">{!! old('content', $post->content) !!}</div>
                <textarea class="hidden" name="content" id="content">{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="mb-4">
                <p class="text-sm font-medium mb-1">Etiquetas</p>

                <ul>
                    @foreach ($tags as $tag)
                        <li>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    @checked(in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())))>
                                <span>{{ $tag->name }}</span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-4">
                <p class="text-sm font-medium mb-1">Estado</p>
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
            </div>

            <div class="flex justify-end">
                <flux:button variant="primary" type="submit">
                    Enviar
                </flux:button>
            </div>
        </div>
    </form>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

        <script>
            const quill = new Quill('#editor', {
                theme: 'snow'
            });

            quill.on('text-change', function() {
                document.querySelector('#content').value = quill.root.innerHTML;
            });
        </script>
    @endpush

</x-layouts.app>
