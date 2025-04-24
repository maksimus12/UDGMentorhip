<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InsertNewDataFromGoogleSheet extends AbstractMigration
{
    public function up()
    {
        $usersData = json_decode(file_get_contents(__DIR__ . '/../data/new_users.json'), true);
        $studentsData = json_decode(file_get_contents(__DIR__ . '/../data/new_students.json'), true);
        $meetingsData = json_decode(file_get_contents(__DIR__ . '/../data/new_meetings.json'), true);
        $users_studentsData = json_decode(file_get_contents(__DIR__ . '/../data/new_users_students.json'), true);

        $this->table('users')->insert($usersData)->save();
        $this->table('students')->insert($studentsData)->save();
        $this->table('meetings')->insert($meetingsData)->save();
        $this->table('users_students')->insert($users_studentsData)->save();

    }
    public function down()
    {
        $this->table('users')->drop()->save();
        $this->table('students')->drop()->save();
        $this->table('meetings')->drop()->save();
        $this->table('users_students')->drop()->save();
    }
}
