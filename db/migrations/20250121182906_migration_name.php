<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MigrationName extends AbstractMigration
{
    public function change(): void
    {
        $this
            ->table('users', ['id' => 'id', 'signed' => false, 'collation' => 'utf8mb4_general_ci'])
            ->addColumn('email', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('password', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('role', 'integer', ['null' => true])
            ->addColumn('is_deleted', 'boolean', ['default' => false, 'null' => false])
            ->create();

        $this
            ->table('students', ['id' => 'id', 'signed' => false, 'collation' => 'utf8mb4_general_ci'])
            ->addColumn('fname', 'string', ['limit' => 255, 'null' => true])
            ->create();

        $this
            ->table('meetings', ['id' => 'id', 'signed' => false, 'collation' => 'utf8mb4_general_ci'])
            ->addColumn('student_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('topic', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('body', 'text', ['null' => true])
            ->addColumn('user_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['null' => true, 'update' => 'CURRENT_TIMESTAMP'])
            ->addColumn('meeting_datetime', 'datetime', ['null' => true])
            ->addIndex(['user_id'])
            ->addIndex(['student_id'])
            ->addForeignKey('student_id', 'students', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create();
    }
}
