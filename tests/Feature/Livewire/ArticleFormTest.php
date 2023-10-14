<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ArticleForm;
use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ArticleFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guest_cannot_create_or_update_articles(): void
    {
        $this->get(route('articles.create'))
            ->assertRedirect('login');

        $article = Article::factory()->create();

        $this->get(route('articles.edit', $article))
            ->assertRedirect('login');
    }

    /** @test */
    function article_form_renders_properly(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('articles.create'))
            ->assertSeeLivewire(ArticleForm::class);

        $article = Article::factory()->create();

        $this->actingAs($user)->get(route('articles.edit', $article))
            ->assertSeeLivewire(ArticleForm::class);
    }

    /** @test */
    function blade_template_is_wired_properly(): void
    {
        Livewire::test(ArticleForm::class)
            ->assertSeeHtml('wire:submit.prevent="save"')
            ->assertSeeHtml('wire:model="article.title"')
            ->assertSeeHtml('wire:model="article.slug"');
    }

    /** @test */
    function can_create_new_articles(): void
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('post-image.png');

        $user = User::factory()->create();

        Livewire::actingAs($user)->test(ArticleForm::class)
            ->set('image', $image)
            ->set('article.title', 'New article')
            ->set('article.slug', 'new-article')
            ->set('article.content', 'Article content')
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('articles.index'));

        $this->assertDatabaseHas('articles', [
            'image' => $imagePath = Storage::disk('public')->files()[0],
            'title' => 'New article',
            'slug' => 'new-article',
            'content' => 'Article content',
            'user_id' => $user->id,
        ]);

        Storage::disk('public')->assertExists($imagePath);
    }

    /** @test */
    function can_update_articles(): void
    {
        $article = Article::factory()->create();

        $user = User::factory()->create();

        Livewire::actingAs($user)->test(ArticleForm::class, ['article' => $article])
            ->assertSet('article.title', $article->title)
            ->assertSet('article.slug', $article->slug)
            ->assertSet('article.content', $article->content)
            ->set('article.title', 'Updated title')
            ->set('article.slug', 'updated-slug')
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('articles.index'));

        $this->assertDatabaseCount('articles', 1);

        $this->assertDatabaseHas('articles', [
            'title' => 'Updated title',
            'slug' => 'updated-slug',
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    function can_update_articles_image(): void
    {
        Storage::fake('public');

        $oldImage = UploadedFile::fake()->image('old-image.png');
        $oldImagePath = $oldImage->store('/', 'public');
        $newImage = UploadedFile::fake()->image('new-image.png');

        $article = Article::factory()->create([
            'image' => $oldImagePath,
        ]);

        $user = User::factory()->create();

        Livewire::actingAs($user)->test(ArticleForm::class, ['article' => $article])
            ->set('image', $newImage)
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('articles.index'));

        Storage::disk('public')
            ->assertExists($article->fresh()->image)
            ->assertMissing($oldImagePath);
    }

    /** @test */
    function title_is_required(): void
    {
        Livewire::test(ArticleForm::class)
            ->set('article.content', 'Article content')
            ->call('save')
            ->assertHasErrors(['article.title' => 'required'])
            ->assertSeeHtml(__('validation.required', ['attribute' => 'title']));
    }

    /** @test */
    function image_is_required(): void
    {
        Livewire::test(ArticleForm::class)
            ->set('article.title', 'Article title')
            ->set('article.content', 'Article content')
            ->call('save')
            ->assertHasErrors(['image' => 'required'])
            ->assertSeeHtml(__('validation.required', ['attribute' => 'image']));
    }

    /** @test */
    function image_field_must_be_of_type_image(): void
    {
        Livewire::test(ArticleForm::class)
            ->set('image', 'string-not-allowed')
            ->call('save')
            ->assertHasErrors(['image' => 'image'])
            ->assertSeeHtml(__('validation.image', ['attribute' => 'image']));
    }

    /** @test */
    function image_must_be_2mb_max(): void
    {
        Storage::fake('public');

        $image = UploadedFile::fake()
            ->image('post-image.png')
            ->size(3000);

        Livewire::test(ArticleForm::class)
            ->set('image', $image)
            ->call('save')
            ->assertHasErrors(['image' => 'max'])
            ->assertSeeHtml(__('validation.max.file', [
                'attribute' => 'image',
                'max' => '2048',
            ]));
    }

    /** @test */
    function slug_is_required(): void
    {
        Livewire::test(ArticleForm::class)
            ->set('article.title', 'New Article')
            ->set('article.slug', null)
            ->set('article.content', 'Article content')
            ->call('save')
            ->assertHasErrors(['article.slug' => 'required'])
            ->assertSeeHtml(__('validation.required', ['attribute' => 'slug']));
    }

    /** @test */
    function slug_must_be_unique(): void
    {
        $article = Article::factory()->create();

        Livewire::test(ArticleForm::class)
            ->set('article.title', 'New Article')
            ->set('article.slug', $article->slug)
            ->set('article.content', 'Article content')
            ->call('save')
            ->assertHasErrors(['article.slug' => 'unique'])
            ->assertSeeHtml(__('validation.unique', ['attribute' => 'slug']));
    }

    /** @test */
    function slug_must_only_contains_letters_numbers_dashes_and_underscores(): void
    {
        $article = Article::factory()->create();

        Livewire::test(ArticleForm::class)
            ->set('article.title', 'New Article')
            ->set('article.slug', 'new-article$%')
            ->set('article.content', 'Article content')
            ->call('save')
            ->assertHasErrors(['article.slug' => 'alpha_dash'])
            ->assertSeeHtml(__('validation.alpha_dash', ['attribute' => 'slug']));
    }

    /** @test */
    function unique_rule_should_be_ignored_when_updating_the_same_slug(): void
    {
        $article = Article::factory()->create();

        $user = User::factory()->create();

        Livewire::actingAs($user)->test(ArticleForm::class, ['article' => $article])
            ->set('article.title', 'New Article')
            ->set('article.slug', $article->slug)
            ->set('article.content', 'Article content')
            ->call('save')
            ->assertHasNoErrors(['article.slug' => 'unique']);
    }

    /** @test */
    function title_must_be_4_characters_min(): void
    {
        Livewire::test(ArticleForm::class)
            ->set('article.title', 'Art')
            ->set('article.content', 'Article content')
            ->call('save')
            ->assertHasErrors(['article.title' => 'min'])
            ->assertSeeHtml(__('validation.min.string', [
                'attribute' => 'title',
                'min' => 4
            ]));
    }

    /** @test */
    function content_is_required(): void
    {
        Livewire::test(ArticleForm::class)
            ->set('article.title', 'Article title')
            ->call('save')
            ->assertHasErrors(['article.content' => 'required'])
            ->assertSeeHtml(__('validation.required', ['attribute' => 'content']));
    }

    /** @test */
    function real_time_validation_works_for_title(): void
    {
        Livewire::test(ArticleForm::class)
            ->set('article.title', '')
            ->assertHasErrors(['article.title' => 'required'])
            ->set('article.title', 'New')
            ->assertHasErrors(['article.title' => 'min'])
            ->set('article.title', 'New Articles')
            ->assertSessionHasNoErrors();
    }

    /** @test */
    function real_time_validation_works_for_content(): void
    {
        Livewire::test(ArticleForm::class)
            ->set('article.content', '')
            ->assertHasErrors(['article.content' => 'required'])
            ->set('article.content', 'New Content')
            ->assertSessionHasNoErrors();
    }

    /** @test */
    function slug_is_generated_automatically(): void
    {
        Livewire::test(ArticleForm::class)
            ->set('article.title', 'Nuevo artículo')
            ->assertSet('article.slug', 'nuevo-articulo');
    }
}
