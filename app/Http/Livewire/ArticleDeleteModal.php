<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ArticleDeleteModal extends Component
{
    public $article;

    public bool $showDeleteModal = false;

    protected $listeners = [
        'confirmArticleDeletion'
    ];

    public function confirmArticleDeletion()
    {
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        Storage::disk('public')->delete($this->article->image);
        $this->article->delete();

        session()->flash('status', __('Article deleted.'));

        $this->redirect(route('articles.index'));
    }

    public function render()
    {
        return view('livewire.article-delete-modal');
    }
}
