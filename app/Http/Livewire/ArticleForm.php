<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleForm extends Component
{
    public Article $article;

    protected $rules = [
        'article.title' => ['required', 'min:4'],
        'article.content' => ['required'],
    ];

    protected $messages = [
        'article.title.required' => 'El :attribute es obligatorio',
        'article.title.min' => 'El :attribute debe tener al menos 4 caracteres',
        'article.content.required' => 'El :attribute es obligatorio',
    ];

    protected $validationAttributes = [
        'title' => 'Título',
        'content' => 'Contenido',
    ];

    public function mount(Article $article)
    {
        $this->article = $article;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $this->article->save();

        session()->flash('status', __('Article saved.'));

        $this->redirectRoute('articles.index');
    }

    public function render()
    {
        return view('livewire.article-form');
    }
}
