<?php


namespace App\Services\DTO;


class UserDTO extends BaseDTO
{
    /**
     * @var int|int[]|null
     */
    public $id;
    /**
     * @var string|null
     */
    public ?string $firstName;
    /**
     * @var string|null
     */
    public ?string $lastName;
    /**
     * @var int|int[]|null
     */
    public $statusId;
    /**
     * @var string|null
     */
    public ?string $login;

}
