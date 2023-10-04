<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleForm extends Component
{
    public $title;
    public $content;

    protected $rules = [
        'title' => ['required'],
        'content' => ['required'],
    ];

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
