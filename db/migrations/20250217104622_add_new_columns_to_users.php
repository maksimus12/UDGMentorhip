<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddNewColumnsToUsers extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('users');
        $table->addColumn('is_deleted', 'boolean', ['default' => false, 'null' => false])
            ->update();
    }
}
