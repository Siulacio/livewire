<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleForm extends Component
{
    public $title;
    public $content;

    protected $rules = [
        'title' => ['required', 'min:4'],
        'content' => ['required'],
    ];

    protected $messages = [
        'title.required' => 'El :attribute es obligatorio',
        'title.min' => 'El :attribute debe tener al menos 4 caracteres',
    ];

    protected $validationAttributes = [
        'title' => 'Título',
        'content' => 'Contenido',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        Article::create($this->validate());

        session()->flash('status', __('Article created.'));

        $this->redirectRoute('articles.index');
    }

    public function render()
    {
        return view('livewire.article-form');
    }
}
