<?php


namespace App\Repositories;

use App\Models\Event;

class EventRepository extends Event
{
    public function events(array $columns = ["*"])
    {
        return $this->query()->get($columns);
    }
    public function getEventByID(string $id)
    {
        return $this->query()->where("id", "=", $id);
    }
    public function joinCertificateByStatus(bool $status)
    {
        return $this->query()->join("certificate", "certificate.event_id", "=", "event.id")->where("event.status", "=", $status);
    }
    public function joinNoteByStatus(bool $status)
    {
        return $this->query()->join("note", "note.event_note_id", "=", "event.id")->where("event.status", "=", $status);
    }
}
