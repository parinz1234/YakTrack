<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class IndexTaskTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_see_a_list_of_tasks()
    {
        // Create project
        $project = factory(App\Models\Project::class)->create();

        // Create tasks
        $tasks = factory(App\Models\Task::class)->create(['project_id' => $project->id]);

        // Login first user
        $user = $this->actingAsUser();

        // Navigate to tasks index page from home page
        $this->visit(route('home'))
            ->click('Tasks');

        // Verify correct page loads
        $this->seePageIs(route('task.index'));

        // Verify tasks are visible
        $tasks->each(function ($task) {
            $this->see($task->name);
        });
    }
}
