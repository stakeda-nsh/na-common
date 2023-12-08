<?php

namespace Common\Dto;

use Carbon\Carbon;

class PlayVersionScheduleDto
{
    /** @var Carbon|null */
    private $openingDate;

    /** @var Carbon|null */
    private $closingDate;

    /** @var string|null */
    private $scheduleInfo;

    /** @var string|null */
    private $venueName;

    private const DATE_FORMAT = 'Y年m月d日（a）';

    public function __construct(?Carbon $openingDate, ?Carbon $closingDate, ?string $scheduleInfo, ?string $venueName)
    {
        $this->openingDate = $openingDate;
        $this->closingDate = $closingDate;
        $this->scheduleInfo = $scheduleInfo;
        $this->venueName = $venueName;
    }

    public function getOpeningDate(): ?Carbon
    {
        return $this->openingDate;
    }

    public function getFormattedOpeningDate(): ?string
    {
        return $this->openingDate ? $this->openingDate->format(self::DATE_FORMAT) : null;
    }

    public function getClosingDate(): ?Carbon
    {
        return $this->closingDate;
    }

    public function getFormattedClosingDate(): ?string
    {
        return $this->closingDate ? $this->closingDate->format(self::DATE_FORMAT) : null;
    }

    public function getScheduleInfo(): ?string
    {
        return $this->scheduleInfo;
    }

    public function getVenueName(): ?string
    {
        return $this->venueName;
    }
}