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
            return strip_tags($data, "<b></b>$lineBreak");
        }
        $result = '';
        end($data);
        $lastKey = key($data);
        foreach ($data as $key => $traceLine) {
            if (is_string($traceLine) || is_numeric($traceLine) || is_bool($traceLine)) {
                if ($traceLine === '') {
                    $result .= '';
                    continue;
                }
                if (is_bool($traceLine) && $traceLine === false) {
                    $traceLine = '0';
                }
                $result .= self::tab($level == 1 ? 0 : $level).(is_int($key) ? '' : "$key: ").
                    trim($traceLine).($key == $lastKey ? "" : "$lineBreak");
                continue;
            }
            if (is_null($traceLine)) {
                continue;
            }
            $result .= self::tab($level)."<b>$key:</b>$lineBreak";
            foreach ($traceLine as $key => $value) {
                $long = false;
                if (is_array($value) && !empty($value)) {
                    $value = $this->asJson($value, $level+2);
                    $long = true;
                } elseif (empty($value)) {
                    $value = '';
                }
                $result .= trim(self::tab($level+1)."$key:".($long ? "$lineBreak" : " ")."$value")."$lineBreak";
            }
        }
        return strip_tags($result, "<b></b>$lineBreak");
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
