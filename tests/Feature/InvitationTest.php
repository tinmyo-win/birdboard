<?php

namespace Tests\Feature;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationTest extends TestCase
{
    /** @test */
    public function non_owners_may_not_invite_users()
    {
        $this->actingAs(factory(User::class)->create())
            ->post(ProjectFactory::create()->path() . '/invitations')
            ->assertStatus(403);
    }

    /** @test */
    public function a_project_owner_can_invite_a_user()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();
        $userToInvite = factory(User::class)->create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'email' => $userToInvite->email,
            ])
            ->assertRedirect($project->path());
        $this->assertTrue($project->members->contains($userToInvite));
    }

    /** @test */
    public function invited_users_may_update_project_details()
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = factory(User::class)->create());

        $this->singIn($newUser);
        $this->post($project->path() . '/tasks', $task = ['body' => 'Foobar task']);

        $this->assertDatabaseHas('tasks', $task);
    }

    /** @test */
    public function the_invited_email_must_be_associated_with_birdboard_account()
    {
        $project = ProjectFactory::create();
        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'email' => 'notuser@example.com',
            ])
            ->assertSessionHasErrors([
                'email' => "The user you are inviting must have a Birdboard account"
            ]);
    }
}
