<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAvatarUpload()
    {
        $user = factory(User::class)->create();

        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $path = route('users.update', ['user' => $user]);

        $response = $this->actingAs($user)->json('PATCH', $path, [
            'avatar' => $file,
        ]);
        $response->assertSessionHasNoErrors();

        
    }
}
