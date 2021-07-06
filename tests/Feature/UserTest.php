<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    function testPostRelation ()
    {
        $user = factory(User::class)->create();
        /* $user->postがCollection::Class(クラス)のインスタンスであること
        use Illuminate\Support\Collection; が必要 */
        $this->assertInstanceOf(Collection::Class, $user->posts);
    }
}
