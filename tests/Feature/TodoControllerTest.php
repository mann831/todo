<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class TodoControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_home_page_redirects_to_todo_list(): void
    {
        $this->get('/')->assertRedirect('/todos');
    }

    public function test_index_lists_todos_and_counts(): void
    {
        Todo::factory()->create(['title' => 'Finished task', 'is_completed' => true]);
        Todo::factory()->create(['title' => 'Open task', 'is_completed' => false]);

        $this->get(route('todos.index'))
            ->assertOk()
            ->assertSee('Finished task')
            ->assertSee('Open task')
            ->assertViewHas('totalCount', 2)
            ->assertViewHas('completedCount', 1)
            ->assertViewHas('pendingCount', 1);
    }

    public function test_index_filters_todos_by_search_term(): void
    {
        Todo::factory()->create(['title' => 'Buy milk']);
        Todo::factory()->create(['title' => 'Learn routing']);

        $this->get(route('todos.index', ['search' => 'milk']))
            ->assertOk()
            ->assertSee('Buy milk')
            ->assertDontSee('Learn routing');
    }

    public function test_create_page_is_shown(): void
    {
        $this->get(route('todos.create'))->assertOk()->assertSee('Create New Task');
    }

    public function test_store_saves_a_new_todo(): void
    {
        $this->post(route('todos.store'), [
            'title' => 'Write tests',
            'description' => 'Cover every CRUD action',
            'is_completed' => '0',
        ])
            ->assertRedirect(route('todos.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('todos', [
            'title' => 'Write tests',
            'description' => 'Cover every CRUD action',
            'is_completed' => false,
        ]);
    }

    public function test_store_requires_a_title(): void
    {
        $this->from(route('todos.create'))
            ->post(route('todos.store'), ['title' => '', 'is_completed' => '0'])
            ->assertRedirect(route('todos.create'))
            ->assertSessionHasErrors('title');

        $this->assertDatabaseCount('todos', 0);
    }

    public function test_store_rejects_an_invalid_status(): void
    {
        $this->post(route('todos.store'), ['title' => 'Task', 'is_completed' => 'maybe'])
            ->assertSessionHasErrors('is_completed');

        $this->assertDatabaseCount('todos', 0);
    }

    public function test_show_displays_one_todo(): void
    {
        $todo = Todo::factory()->create(['title' => 'Read the docs']);

        $this->get(route('todos.show', $todo))->assertOk()->assertSee('Read the docs');
    }

    public function test_show_returns_404_for_a_missing_todo(): void
    {
        $this->get(route('todos.show', 999))->assertNotFound();
    }

    public function test_edit_page_shows_current_values(): void
    {
        $todo = Todo::factory()->create(['title' => 'Old title']);

        $this->get(route('todos.edit', $todo))->assertOk()->assertSee('Old title');
    }

    public function test_update_saves_changes(): void
    {
        $todo = Todo::factory()->create(['title' => 'Old title', 'is_completed' => false]);

        $this->put(route('todos.update', $todo), [
            'title' => 'New title',
            'description' => null,
            'is_completed' => '1',
        ])
            ->assertRedirect(route('todos.show', $todo))
            ->assertSessionHas('success');

        $todo->refresh();
        $this->assertSame('New title', $todo->title);
        $this->assertTrue($todo->is_completed);
    }

    public function test_update_requires_a_title(): void
    {
        $todo = Todo::factory()->create(['title' => 'Keep me']);

        $this->put(route('todos.update', $todo), ['title' => '', 'is_completed' => '0'])
            ->assertSessionHasErrors('title');

        $this->assertSame('Keep me', $todo->fresh()->title);
    }

    public function test_destroy_deletes_the_todo(): void
    {
        $todo = Todo::factory()->create();

        $this->delete(route('todos.destroy', $todo))
            ->assertRedirect(route('todos.index'))
            ->assertSessionHas('success');

        $this->assertModelMissing($todo);
    }
}
