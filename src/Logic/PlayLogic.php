<?php

namespace Common\Logic;

use Common\Dto\PlayDto;
use Common\Dto\PlayVersionArtistDto;

class PlayLogic
{
    static function renderEmbedText(PlayDto $play, int $version, bool $isRawBody): string
    {
        $playVersion = $play->getSpecificVersion($version);
        if ($playVersion === null) {
            return '';
        }

        //  公演タイトル
        $resultText = '<h2>' . $play->getTitle() . '</h2>' . PHP_EOL;

        // スケジュール
        $schedules = $playVersion->getSchedules();
        if (!empty($schedules)) {
            $schedulePreformattedText = '';
            foreach ($schedules as $index => $schedule) {
                // 公演期間
                if ($schedule->getScheduleInfo() !== null && $schedule->getScheduleInfo() !== '') {
                    $schedulePreformattedText .= $schedule->getScheduleInfo();
                } elseif ($schedule->getOpeningDate() !== null || $schedule->getClosingDate() !== null) {
                    $schedulePreformattedText .= ($schedule->getFormattedOpeningDate() ?? '') . '～' . ($schedule->getFormattedClosingDate() ?? '');
                }
                if ($schedule->getClosingDate() !== null && $schedule->getClosingDate()->isPast()) {
                    $schedulePreformattedText .= '※公演終了' ;
                }
                $schedulePreformattedText .= PHP_EOL;

                // 会場名
                if ($schedule->getVenueName() !== null && $schedule->getVenueName() !== '') {
                    $schedulePreformattedText .= $schedule->getVenueName() . PHP_EOL;
                }
                if ($index < count($schedules) - 1) {
                    $schedulePreformattedText .= PHP_EOL;
                }
            }
            $resultText .= self::renderPreformattedText($schedulePreformattedText, $isRawBody);
        }

        // スタッフ
        $staffs = $playVersion->getStaffs();
        if (!empty($staffs)) {
            $resultText .= PHP_EOL;
            $resultText .= '<h3>スタッフ</h3>' . PHP_EOL;

            $renderedStaff = self::renderArtists($staffs, $isRawBody);
            if ($renderedStaff) {
                $resultText .= $renderedStaff;
            }
        }

        // キャスト
        $casts = $playVersion->getCasts();
        if (!empty($casts)) {
            $resultText .= PHP_EOL;
            $resultText .= '<h3>出演</h3>' . PHP_EOL;

            $groupingCasts = self::renderArtists($casts, $isRawBody);
            if ($groupingCasts) {
                $resultText .= $groupingCasts;
            }
        }

        // 注釈
        $annotation = $playVersion->getAnnotation();
        if ($annotation !== null && $annotation !== '') {
            $annotation = nl2br($annotation, false);
            $resultText .= PHP_EOL;
            $resultText .= '<p class="NA_article_text-correction">' . PHP_EOL;
            $resultText .= $annotation . PHP_EOL;
            $resultText .= '</p>' . PHP_EOL;
        }

        return $resultText;
    }

    /**
     * 整形済みテキストを加工して返却
     *
     * @param string $text
     * @param bool $isRawBody
     * @return string
     */
    private static function renderPreformattedText(string $text, bool $isRawBody): string
    {
        $resultText = ($isRawBody ? '{pre}' : '<p>') . PHP_EOL;
        $resultText .= ($isRawBody ? $text : nl2br($text, false));
        $resultText .= ($isRawBody ? '{/pre}' : '</p>') . PHP_EOL;
        return $resultText;
    }

    /**
     * スタッフ・キャスト レンダリング処理
     *
     * @param PlayVersionArtistDto[] $artists
     * @param bool $isRawBody
     * @return string
     */
    private static function renderArtists(array $artists, bool $isRawBody): string
    {
        $groupings = [];
        $groupsIndex = 0;
        $partsIndex = 0;

        foreach ($artists as $index => $artist) {
            if ($index > 0) {
                $prevArtist = $artists[$index - 1];
                if ($prevArtist->getGroup() !== $artist->getGroup()) {
                    $groupsIndex++;
                    $partsIndex = 0;
                }
                if ($prevArtist->getPart() !== $artist->getPart()) {
                    $partsIndex++;
                }
            }
            $groupings[$groupsIndex]['group_name'] = $artist->getGroup();
            $groupings[$groupsIndex]['parts'][$partsIndex]['part_name'] = $artist->getPart();
            if (!isset($groupings[$groupsIndex]['parts'][$partsIndex]['artists'])) {
                $groupings[$groupsIndex]['parts'][$partsIndex]['artists'] = $artist->getDisplayName();
            } else {
                $groupings[$groupsIndex]['parts'][$partsIndex]['artists'] .= ' / ' . $artist->getDisplayName();
            }
        }

        $resultText = '';
        foreach ($groupings as $group) {
            $groupName = $group['group_name'];
            if ($groupName !== null && $groupName !== '') {
                $resultText .= '<h4>' . $groupName . '</h4>' . PHP_EOL;
            }
            $preformattedText = '';

            foreach ($group['parts'] as $part) {
                $partName = $part['part_name'];
                if ($partName !== null && $partName !== '') {
                    $preformattedText .= $partName . '：';
                }
                $preformattedText .= $part['artists'] . PHP_EOL;
            }
            $resultText .= self::renderPreformattedText($preformattedText, $isRawBody);
        }

        return $resultText;
    }
}
