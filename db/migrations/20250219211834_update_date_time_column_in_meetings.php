<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateDateTimeColumnInMeetings extends AbstractMigration
{
    public function change(): void
    {
        $this->table('meetings')
            ->changeColumn('meeting_datetime', 'date', ['null' => true])
            ->update();
    }
}
