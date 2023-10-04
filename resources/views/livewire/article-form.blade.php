<div>
    <h1>Crear artículo</h1>
    <form wire:submit.prevent="save">
        <label>
            <input wire:model="title" type="text" placeholder="Título">
        </label>
        <label>
            <textarea wire:model="content" placeholder="Contenido"></textarea>
        </label>
        <input type="submit" value="Guardar">
    </form>
</div>
