<?php

namespace App\Repositories;

use App\Models\MeetNote;

class MeetNoteRepository extends MeetNote
{
    public function getByID(string $id)
    {
        return $this->query()->where("id", "=", $id);
    }
}
