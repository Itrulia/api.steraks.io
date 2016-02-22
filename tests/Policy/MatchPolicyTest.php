<?php namespace Tests\Services\Avatar;

use App\League;
use App\Match;
use App\Policies\MatchPolicy;
use App\User;
use Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

class MatchPolicyTest extends TestCase
{
    /**
     * @var MatchPolicy
     */
    protected $instance;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Match
     */
    protected $match;

    public function setUp()
    {
        parent::setUp();
        $this->instance = new MatchPolicy();

        $this->user = Mockery::mock(User::class, function (MockInterface $mock) {
            $mock->makePartial();
            /** @var User $mock */
            $mock->id = 1000;
        });

        $this->match = Mockery::mock(Match::class, function (MockInterface $mock) {
            $mock->makePartial();
            /** @var Match $mock */
            $mock->id = 1002;

            $mock->league = Mockery::mock(League::class, function (MockInterface $mock) {
                $mock->makePartial();
                /** @var League $mock */
                $mock->id = 1001;
                $mock->user_id = 1000;
            });
        });
    }

    public function testStore()
    {
        $this->assertTrue($this->instance->store($this->user, $this->match));
    }

    public function testUpdate()
    {
        $this->assertTrue($this->instance->update($this->user, $this->match));
    }

    public function testDestroy()
    {
        $this->assertTrue($this->instance->destroy($this->user, $this->match));
    }
}
