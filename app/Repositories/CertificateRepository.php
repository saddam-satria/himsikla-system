<?php


namespace App\Repositories;

use App\Models\Certificate;



class CertificateRepository extends Certificate
{
    public function certificateByEventID(string $eventID, array $columns = ["*"])
    {
        return $this->query()->where("event_id", "=", $eventID)->get($columns)->first();
    }
    public function certificateByID(string $idCertificate)
    {
        return $this->query()->where("id", "=", $idCertificate);
    }
}
