<?php

namespace achertovsky\formatter\i18n;

use yii\i18n\Formatter as I18nFormatter;

/**
 * Extends vanilla formatter to display pretty json
 */
class Formatter extends I18nFormatter
{
    /**
     * Undocumented function
     *
     * @param mixed $data
     * Data to display
     * @param integer $level
     * Internal param. Used to define amount of tabs
     * @param string $lineBreak
     * Will be added to end of every line.
     * @return void
     */
    public function asJson($data, $level = 0, $lineBreak = "<br>")
    {
        if (is_string($data)) {
            return $data;
        }
        $result = '';
        end($data);
        $lastKey = key($data);
        foreach ($data as $key => $traceLine) {
            if (is_object($traceLine)) {
                $traceLine = (array)$traceLine;
            }
            if (is_string($traceLine) || is_numeric($traceLine) || is_bool($traceLine)) {
                if ($traceLine === '') {
                    $result .= '';
                    continue;
                }
                if (is_bool($traceLine) && $traceLine === false) {
                    $traceLine = '0';
                }
                $traceLine = htmlspecialchars($traceLine);
                $result .= self::tab($level == 1 ? 0 : $level).(is_int($key) ? '' : "$key: ").
                    trim($traceLine).($key == $lastKey ? "" : "$lineBreak");
                continue;
            }
            if (is_null($traceLine)) {
                continue;
            }
            if (is_array($traceLine)) {
                $result .= self::tab($level)."<b>$key:</b>$lineBreak";
                $result .= $this->asJson($traceLine, $level+2).($lastKey == $key ? '' : $lineBreak);
            }
        }
        return $result;
    }

    /**
     * Tabbing func.
     *
     * @param integer $level
     * @return void
     */
    private static function tab($level)
    {
        return str_pad('', ($level*4)*6, '&nbsp;');
    }
}
