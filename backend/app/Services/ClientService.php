<?php


namespace App\Services;


use App\Models\Client;
use App\Services\DTO\ClientDTO;
use App\Services\DTO\ContactDTO;

class ClientService
{
    public static function findOrCreate(ClientDTO $clientDto): Client
    {
        $client = Client::whereHas('contacts', function($query) use ($clientDto) {
            $query->where('contacts.value', 'like', $clientDto->contact->value);
        })->first();

        if (!$client) {
            $client = new Client();
            $client->name = $clientDto->name;
            $client->save();
            $contactDto = $clientDto->contact;
            $contactDto->entityId = $client->id;
            ContactService::create($contactDto);
        }

        return $client;
    }

    public static function findByContact(ContactDTO $contact)
    {

    }
}
