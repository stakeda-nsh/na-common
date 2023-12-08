<?php

namespace Common\Dto;

class PlayVersionArtistDto
{
    /** @var string */
    private $artistId;

    /** @var string */
    private $name;

    /** @var string */
    private $group;

    /** @var string */
    private $part;

    /** @var string */
    private $credit;

    public function __construct(string $artistId, string $name, string $group, string $part, string $credit)
    {
        $this->artistId = $artistId;
        $this->name = $name;
        $this->group = $group;
        $this->part = $part;
        $this->credit = $credit;
    }

    public function getArtistId(): string
    {
        return $this->artistId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    public function getPart(): string
    {
        return $this->part;
    }

    public function getCredit(): string
    {
        return $this->credit;
    }
}