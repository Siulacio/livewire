<?php

namespace Tests\Feature\Livewire;

use App\Livewire\ArticlesTable;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticlesTableTest extends TestCase
{
    /** @test */
    function articles_component_render_properly(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('articles.index'))
            ->assertSeeLivewire(ArticlesTable::class);
    }
}
