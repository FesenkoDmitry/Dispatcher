<?php


namespace App\Services\DTO;


class ClientDTO
{
    public string $name;
    public ContactDTO $contact;

    /**
     * ClientDTO constructor.
     * @param string $name
     * @param ContactDTO $contact
     */
    public function __construct(string $name, ContactDTO $contact)
    {
        $this->name = $name;
        $this->contact = $contact;
    }
}
