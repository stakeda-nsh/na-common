<?php

namespace Common\Dto;

class PlayVersionArtistDto
{
    /** @var string */
    private $displayName;

    /** @var string|null */
    private $group;

    /** @var string|null */
    private $part;

    /** @var string|null */
    private $credit;

    public function __construct(string $displayName, ?string $group, ?string $part, ?string $credit)
    {
        $this->displayName = $displayName;
        $this->group = $group;
        $this->part = $part;
        $this->credit = $credit;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    public function getPart(): ?string
    {
        return $this->part;
    }

    public function getCredit(): ?string
    {
        return $this->credit;
    }
}
