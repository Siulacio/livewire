<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleForm extends Component
{
    public $title;
    public $content;

    public function save()
    {
        $data = $this->validate([
            'title' => ['required'],
            'content' => ['required'],
        ]);

        Article::create($data);

        session()->flash('status', __('Article created.'));

        $this->redirectRoute('articles.index');
    }

    public function render()
    {
        return view('livewire.article-form');
    }
}
