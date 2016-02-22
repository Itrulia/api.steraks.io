<?php namespace Tests\Services\Avatar;

use App\Services\Avatar\Gravatar;
use App\User;
use Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

class GravatarTest extends TestCase
{
    /**
     * @var Gravatar
     */
    protected $avatar;

    public function setUp()
    {
        parent::setUp();
        $this->avatar = new Gravatar();
    }

    public function testGetAvatar() {
        /**
         * @var User $user
         */
        $user = $user = Mockery::mock(User::class, function(MockInterface $mock) {
            $mock->makePartial();
            $mock->email = 'info@karl-merkli.ch';
        });

        $expected = '//gravatar.com/avatar/d9f7d064e522b26a3821a504876f451a?s=72';
        $actual = $this->avatar->getAvatar($user, 72);

        $this->assertEquals($expected, $actual, 'Avatars do not match.');
    }
}
