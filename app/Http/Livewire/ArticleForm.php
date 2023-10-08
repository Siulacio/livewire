<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ArticleForm extends Component
{
    public Article $article;

    /**
     * este metodo se usa para reemplazar el array pues en el array no se podía concatenar el id del slug
     * dado que es un atributo de la clase. pero al usar la función vemos que ahora si es posible
     */
    protected function rules(): array
    {
        return [
            'article.title' => ['required', 'min:4'],
            'article.slug' => [
                'required',
                'alpha_dash',
                Rule::unique('articles', 'slug')->ignore($this->article)
            ],
            'article.content' => ['required'],
        ];
    }

    public function mount(Article $article)
    {
        $this->article = $article;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedArticleTitle($title)
    {
        $this->article->slug = Str::slug($title);
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
