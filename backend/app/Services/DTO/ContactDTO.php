<?php


namespace App\Services\DTO;


class ContactDTO
{
    /**
     * @var int|null
     */
    public $entityId;

    /**
     * @var string|null
     */
    public $entityType;

    /**
     * @var string|null
     */
    public $type;

    /**
     * @var string|null
     */
    public $value;

    /**
     * ContactDTO constructor.
     * @param int|null $entityId
     * @param string|null $entityType
     * @param string|null $type
     * @param string|null $value
     */
    public function __construct(
        int $entityId = null,
        string $entityType = null,
        string $type = null,
        string $value = null
    )
    {
        $this->entityId = $entityId;
        $this->entityType = $entityType;
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'entity_id' => $this->entityId,
            'entity_type' => $this->entityType,
            'type' => $this->type,
            'value' => $this->value,
        ];
    }
}
