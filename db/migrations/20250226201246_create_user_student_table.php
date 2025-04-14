<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUserStudentTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('users_students', ['id' => 'id', 'signed' => false, 'collation' => 'utf8mb4_general_ci']);

        $table->addColumn('user_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('student_id', 'integer', ['null' => true, 'signed' => false])
            ->addIndex('user_id')
            ->addIndex('student_id')
            ->addForeignKey('user_id', 'users', 'id', ['update' => 'NO_ACTION', 'delete' => 'NO_ACTION'])
            ->addForeignKey('student_id', 'students', 'id', ['update' => 'NO_ACTION', 'delete' => 'CASCADE'])
            ->create();
    }
}
