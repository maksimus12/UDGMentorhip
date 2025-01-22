<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InsertDataFromJson extends AbstractMigration
{

    public function up()
    {
        $usersData = json_decode(file_get_contents(__DIR__ . '/../data/users.json'), true);
        $studentsData = json_decode(file_get_contents(__DIR__ . '/../data/students.json'), true);
        $meetingsData = json_decode(file_get_contents(__DIR__ . '/../data/meetings.json'), true);

        $usersTable = $this->table('users');
        $studentsTable = $this->table('students');
        $meetingsTable = $this->table('meetings');

        $usersTable->insert($usersData)->save();
        $studentsTable->insert($studentsData)->save();
        $meetingsTable->insert($meetingsData)->save();
    }

    public function down()
    {
        $this->table('users')->drop()->save();
        $this->table('students')->drop()->save();
        $this->table('meetings')->drop()->save();
    }
}
