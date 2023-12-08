<?php

namespace Common\Dto;

class PlayVersionDto
{
    /** @var int */
    private $version;

    /** @var PlayVersionScheduleDto[] */
    private $schedules;

    /** @var PlayVersionArtistDto[] */
    private $staffs;

    /** @var PlayVersionArtistDto[] */
    private $casts;

    /** @var string|null */
    private $annotation;

    /**
     * Constructor.
     *
     * @param int $version
     * @param PlayVersionScheduleDto[] $schedules
     * @param PlayVersionArtistDto[] $staffs
     * @param PlayVersionArtistDto[] $casts
     * @param string|null $annotation
     */
    public function __construct(int $version, array $schedules, array $staffs, array $casts, ?string $annotation)
    {
        $this->version = $version;
        $this->schedules = $schedules;
        $this->staffs = $staffs;
        $this->casts = $casts;
        $this->annotation = $annotation;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getSchedules(): array
    {
        return $this->schedules;
    }

    public function getStaffs(): array
    {
        return $this->staffs;
    }

    public function getCasts(): array
    {
        return $this->casts;
    }

    public function getAnnotation(): ?string
    {
        return $this->annotation;
    }
}