<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class ArticlesTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public function sortBy(string $field)
    {
        $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : $this->sortDirection = 'asc';

        $this->sortField = $field;
    }

    public function render()
    {
        return view('livewire.articles-table', [
            'articles' => Article::query()
                ->where('title', 'like', "%{$this->search}%")
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(5),
        ]);
    }
}
