<?php

namespace Cian\Slack\Builders;

class ElementBuilder
{
    public static function button(string $text, string $actionId, $value = '', string $style = 'primary', string $type = 'plain_text')
    {
        $value = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value;
        $options = [
            'type' => 'button',
            'style' => $style,
            'action_id' => $actionId,
            'text' => [
                'type' => $type,
                'text' => $text,
            ],
            'value' => $value
        ];

        // 若想套用 default 樣式
        // slack api 表示需不帶 style key
        if (strtolower($style) === 'default') {
            unset($options['style']);
        }

        return $options;
    }
}
