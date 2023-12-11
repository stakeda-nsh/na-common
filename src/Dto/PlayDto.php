<?php

namespace Common\Dto;

class PlayDto
{
    /** @var string */
    private $title;

    /** @var PlayVersionDto[] */
    private $versions;

    /**
     * Constructor.
     *
     * @param string $title
     * @param PlayVersionDto[] $versions
     */
    public function __construct(string $title, array $versions)
    {
        $this->title = $title;
        $this->versions = $versions;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getVersions(): array
    {
        return $this->versions;
    }

    public function getSpecificVersion(int $version): ?PlayVersionDto
    {
        foreach ($this->versions as $playVersion) {
            if ($playVersion->getVersion() === $version) {
                return $playVersion;
            }
        }
        return null;
    }
}
