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

        foreach ($usersData as $user) {
            $usersTable->insert([
                'id' => $user['id'],
                'email' => $user['email'],
                'password' => $user['password'],
                'role' => $user['role'],
            ])->save();
        }

        foreach ($studentsData as $student) {
            $studentsTable->insert([
                'id' => $student['id'],
                'fname' => $student['fname'],
            ])->save();
        }

        foreach ($meetingsData as $meeting) {
            $meetingsTable->insert([
                'id' => $meeting['id'],
                'student_id' => $meeting['student_id'],
                'topic' => $meeting['topic'],
                'body' => $meeting['body'],
                'user_id' => $meeting['user_id'],
                'created_at' => $meeting['created_at'],
                'updated_at' => $meeting['updated_at'],
                'meeting_datetime' => $meeting['meeting_datetime'],
            ])->save();
        }
    }

    public function down()
    {
        $this->table('users')->drop()->save();
        $this->table('students')->drop()->save();
        $this->table('meetings')->drop()->save();
    }
}
