<?php
App::uses('SqliteTestCase', 'Test');
App::uses('ClassRegistry', 'Utility');

/**
 * Class UserTest
 */
class UserTest extends SqliteTestCase
{
    /** @test */
    public function it_can_count_numbers_of_users()
    {
        $this->assertCount(2, ClassRegistry::init('User')->find('all'));
    }
}