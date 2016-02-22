<?php namespace Tests\Services\Avatar;

use App\League;
use App\Policies\LeaguePolicy;
use App\User;
use Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

class LeaguePolicyTest extends TestCase
{
    /**
     * @var LeaguePolicy
     */
    protected $instance;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var League
     */
    protected $league;

    public function setUp()
    {
        parent::setUp();
        $this->instance = new LeaguePolicy();

        $this->user = Mockery::mock(User::class, function (MockInterface $mock) {
            $mock->makePartial();
            /** @var User $mock */
            $mock->id = 1000;
        });

        $this->league = Mockery::mock(League::class, function (MockInterface $mock) {
            $mock->makePartial();
            /** @var League $mock */
            $mock->id = 1001;
            $mock->user_id = 1000;
        });
    }

    public function testStore()
    {
        $this->assertTrue($this->instance->store($this->user, $this->league));
    }

    public function testUpdate()
    {
        $this->assertTrue($this->instance->update($this->user, $this->league));
    }

    public function testDestroy()
    {
        $this->assertTrue($this->instance->destroy($this->user, $this->league));
    }

    public function testSignUp()
    {
        $user = Mockery::mock(User::class, function (MockInterface $mock) {
            $mock->makePartial();
            /** @var User $mock */
            $mock->id = 1000;
        });

        $league = Mockery::mock(League::class, function (MockInterface $mock) {
            $mock->makePartial();
            /** @var League $mock */
            $mock->id = 1001;
            $mock->user_id = 1002;
        });

        // creator is unable to play
        $this->assertFalse($this->instance->signUp($this->user, $this->league));
        $this->assertTrue($this->instance->signUp($user, $league));
    }

    public function testLeave()
    {
        $this->assertTrue($this->instance->leave($this->user, $this->league));
    }
}
