<?php

namespace App\Http\Services\dashboard\admin;

use App\Http\Services\Service;
use App\Models\EventNote;
use App\Repositories\EventRepository;
use App\Repositories\NoteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NoteService extends Service
{
    protected $eventRepository;
    protected $eventNote;
    protected $noteRepository;
    public function __construct()
    {
        $this->eventRepository = new EventRepository();
        $this->eventNote  = new EventNote();
        $this->noteRepository = new NoteRepository();
    }

    public function events()
    {
        return [
            "events" => $this->eventRepository->query()->where("status", "=", true)->get(array("event.id", "eventName"))
        ];
    }

    public function insert(Request $request,  $note,  $event_id)

    {
        $rules = array(
            "event_id" => ["required"],
            "note" => ["required"]
        );

        $messages = array(
            "required" => ":attribute tidak boleh kosong"
        );

        $this->validation($request, $rules, $messages);
        $eventID = Str::uuid()->toString();
        $this->eventNote->event_id = $event_id;
        $this->eventNote->id = $eventID;
        $event = $this->eventNote->save();
        if (!$event) return false;
        $response =  $this->noteRepository->create(array("event_note_id" => $eventID, "note" => $note));

        if (!$response) return false;


        return true;
    }
    public function detailNote($id)
    {
        return $this->noteRepository->query()->join("event_note", "event_note.id", "=", "note.event_note_id")->join('event', "event.id", "=", "event_note.event_id")->where("note.id", "=", $id);
    }
    public function updateNote(Request $request, $id, $note)
    {

        $rules = array(
            "event_id" => ["required"],
            "note" => ["required"]
        );

        $messages = array(
            "required" => ":attribute tidak boleh kosong"
        );

        $this->validation($request, $rules, $messages);

        $this->validation($request, $rules, $messages);

        $response = $this->noteRepository->where("id", "=", $id)->update(array("note" => $note));
        return $response == 1;
    }
    public function destroy($id)
    {
        return $this->noteRepository->where("id", "=", $id)->delete();
    }
}
