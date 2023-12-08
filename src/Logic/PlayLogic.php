<?php

namespace Common\Logic;

use Common\Dto\PlayDto;

class PlayLogic
{
    function createEmbedText(PlayDto $play): string
    {
        //  公演タイトル
        $resultText = '<h2>' . $play->getTitle() . '</h2>';

        // スケジュール
        $schedules = $play->getCurrentVersion()->getSchedules();
        $resultText .= '{pre}';
        foreach ($schedules as $schedule) {
            if ($schedule->getScheduleInfo() !== null && $schedule->getScheduleInfo() !== '') {
                $resultText .= $schedule->getScheduleInfo();
            } elseif ($schedule->getOpeningDate() !== null || $schedule->getClosingDate() !== null) {
                $resultText .= ($schedule->getFormattedOpeningDate() ?? '') . '～' . ($schedule->getFormattedClosingDate() ?? '');
            }
            if ($schedule->getClosingDate() !== null && $schedule->getClosingDate()->isPast()) {
                $resultText .= '※公演終了' . PHP_EOL;
            }
            $resultText .= $schedule->getVenueName() . PHP_EOL;
            $resultText .= PHP_EOL;
        }
        $resultText .= '{/pre}';

        // スタッフ
        $versionStaffs = $play->getCurrentVersion()->getStaffs();
        if (count($versionStaffs) > 0) {
            $resultText .= '<h3>スタッフ</h3>';
            $groups = collect($versionStaffs)->groupBy('group');
            foreach ($groups as $group => $staffs) {
                $resultText .= '<h4>' . $group . '</h4>';
                $resultText .= '{pre}';
                $staffGroups = collect($staffs)->groupBy('part');
                foreach ($staffGroups as $part => $staffGroup) {
                    $resultText .= $part . '：';
                    $resultText .= collect($staffGroup)->map(function ($staff) {
                        return $staff->getName();
                    })->implode(' / ');
                    $resultText .= PHP_EOL;
                }
                $resultText .= '{/pre}';
            }
        }

        // キャスト
        $versionCasts = $play->getCurrentVersion()->getCasts();
        if (count($versionCasts) > 0) {
            $resultText .= '<h3>出演</h3>';
            $resultText .= '{pre}';
            $castGroups = collect($versionCasts)->groupBy('part');
            foreach ($castGroups as $part => $castGroup) {
                $resultText .= $part . '：';
                $resultText .= collect($castGroup)->map(function ($cast) {
                    return $cast->getName();
                })->implode(' / ');
                $resultText .= PHP_EOL;
            }
            $resultText .= '{/pre}';
        }

        // 注釈
        $annotation = $play->getCurrentVersion()->getAnnotation();
        if ($annotation !== null && $annotation !== '') {
            $resultText .= '<p class="NA_article_text-correction">' . $annotation . '</p>';
        }

        return $resultText;
    }
}