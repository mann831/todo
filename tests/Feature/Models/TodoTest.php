<?php

namespace Tests\Feature\Models;

use App\Models\Todo;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_todo_factory_persists_fields_and_casts_completion_status(): void
    {
        $todo = Todo::factory()->create([
            'title' => 'Study Laravel',
            'is_completed' => true,
        ]);

        $this->assertModelExists($todo);
        $this->assertSame('Study Laravel', $todo->fresh()->title);
        $this->assertSame(true, $todo->fresh()->is_completed);
    }

    public function test_new_todos_default_to_pending(): void
    {
        $todo = Todo::query()->create([
            'title' => 'Read the Laravel documentation',
        ]);

        $this->assertSame(false, $todo->fresh()->is_completed);
    }
}
