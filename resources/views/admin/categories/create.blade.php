<x-layouts.app :title="__('Categories')">
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('admin.categories.index') }}">Categorías</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Categorías</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="card">
        <form action="{{ route('admin.categories.store') }}" method="post">
            @csrf
            <flux:input label="Nombre" name="name" value="{{ old('name') }}" placeholder="Escriba el nombre de la categoría" />
            <div class="flex justify-end mt-4">
                <flux:button variant="primary" type="submit">
                    Enviar
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>
