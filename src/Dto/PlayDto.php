<?php

namespace Common\Dto;

class PlayDto
{
    /** @var string */
    private $title;

    /** @var PlayVersionDto */
    private $currentVersion;

    /**
     * Constructor.
     *
     * @param string $title
     * @param PlayVersionDto $currentVersion
     */
    public function __construct(string $title, PlayVersionDto $currentVersion)
    {
        $this->title = $title;
        $this->currentVersion = $currentVersion;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCurrentVersion(): PlayVersionDto
    {
        return $this->currentVersion;
    }
}