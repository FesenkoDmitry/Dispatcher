<?php


namespace App\Services;


use App\Models\Contact;
use App\Services\DTO\ContactDTO;

class ContactService
{
    public static function create(ContactDTO $dto): Contact
    {
        return Contact::firstOrCreate($dto->toArray());
    }
}
