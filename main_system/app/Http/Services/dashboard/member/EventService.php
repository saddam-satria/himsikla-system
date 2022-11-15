<?php


namespace App\Http\Services\dashboard\member;

use App\Http\Services\Service;
use App\Models\Event;
use App\Repositories\EventRepository;

class EventService extends Service
{
    private $eventRepository;
    public function __construct()
    {
        $this->eventRepository = new EventRepository();
    }
    public function getEvents(array $columns = ["*"], bool $isGeneral = false)
    {
        return $this->eventRepository->query()->where("isGeneral", "=", $isGeneral)->get($columns);
    }
    public function getEventByCertificateAbsenceNote($id)
    {
        return Event::query()->where("id", "=", $id)->withCount("absence")->first();
    }
}
