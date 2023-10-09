<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Articles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    /** @test */
    function articles_component_render_properly(): void
    {
        $this->get('/')->assertSeeLivewire(Articles::class);
    }
}
