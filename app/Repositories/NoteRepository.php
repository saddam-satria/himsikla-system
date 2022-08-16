<?php


namespace App\Repositories;

use App\Models\Note;


class NoteRepository extends Note
{
    public function getAll()
    {
        return $this->query()->join("event_note", "event_note.id", "=", "note.event_note_id")->join('event', "event.id", "=", "event_note.event_id");
    }
    public function create($data)
    {
        return $this->query()->create($data);
    }
}
