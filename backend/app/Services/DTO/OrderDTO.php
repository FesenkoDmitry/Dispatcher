<?php


namespace App\Services\DTO;

class OrderDTO extends BaseDTO
{
    /**
     * @var string
     */
    public string $name;
    /**
     * @var string
     */
    public string $phone;
    /**
     * @var int
     */
    public int $issueId;
    /**
     * @var bool
     */
    public bool $isUrgent;
    /**
     * @var int
     */
    public int $dateTime;
    /**
     * @var array
     */
    public array $coords;

    /**
     * @var string
     */
    public string $address;

}
