<div>
    <h1>Crear artículo</h1>
    <form wire:submit.prevent="save">
        <label>
            <input wire:model="article.title" type="text" placeholder="Título">
            @error('article.title') <div>{{ $message }}</div> @enderror
        </label>
        <label>
            <textarea wire:model="article.content" placeholder="Contenido"></textarea>
            @error('article.content') <div>{{ $message }}</div> @enderror
        </label>
        <input type="submit" value="Guardar">
    </form>
</div>
