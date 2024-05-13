<?php
namespace SimpleDemoBlog\Tests;

include __DIR__ . '/../vendor/autoload.php';

use SimpleDemoBlog\Models\User;
use SimpleDemoBlog\Tests\TestCase;
use Faker\Factory as FakerFactory;

class UserTest extends TestCase
{
    /**
     * Test the validatePassword function of the User class.
     * @covers \SimpleDemoBlog\Models\User::setUser_name
     * @covers \SimpleDemoBlog\Models\User::setEmail
     * @covers \SimpleDemoBlog\Models\User::setPassword
     * @covers \SimpleDemoBlog\Models\User::setId
     * @covers \SimpleDemoBlog\Models\User::validatePassword
     */
    public function testValidatePassword() {
        $user = new User;

        $password = $this->faker->password;
        $user->setUser_name($this->faker->userName);
        $user->setEmail($this->faker->email);
        $user->setPassword($password);
        $user->setId($this->faker->randomNumber(3));
        $user->save();

        $this->assertFalse($user->validatePassword($this->faker->password));
        $this->assertTrue($user->validatePassword($password));
    }
}