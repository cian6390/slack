<?php

namespace Cian\Slack\Builders;

class BlockBuilder
{
    protected $blocks = [];

    public function get($index = null)
    {
        return is_null($index) ? $this->blocks : $this->blocks[$index];
    }

    public function clear($index = null)
    {
        if (is_null($index)) {
            $this->blocks = [];
        } else {
            array_splice($this->blocks, $index, 1);
        }
    }

    public function context($options)
    {
        $this->blocks[] = static::makeContext($options);
        return $this;
    }

    public function input($options)
    {
        $this->blocks[] = static::makeInput($options);
        return $this;
    }

    public function file($options)
    {
        $this->blocks[] = static::makeFile($options);
        return $this;
    }

    public function image($options)
    {
        $this->blocks[] = static::makeImage($options);
        return $this;
    }

    public function section($text, $options = [])
    {
        $this->blocks[] = static::makeSection($text, $options);
        return $this;
    }

    public function divider()
    {
        $this->blocks[] = static::makeDivider();
        return $this;
    }

    public function actions($elements, $options = [])
    {
        $this->blocks[] = static::makeActions($elements, $options);
        return $this;
    }

    public static function makeSection($text, $options = [])
    {
        if (is_string($text)) {
            $text = [
                'type' => 'mrkdwn',
                'text' => $text
            ];
        }

        return array_merge([
            'type' => 'section',
            'text' => $text
        ], $options);
    }

    public static function makeActions($elements, $options = [])
    {
        $elements = is_array($elements) ? $elements : [$elements];
        return array_merge([
            'type' => 'actions',
            'elements' => $elements
        ], $options);
    }

    public static function makeDivider()
    {
        return ['type' => 'divider'];
    }

    public static function makeFile($options)
    {
        if (!is_array($options)) {
            $options = [
                'external_id' => $options
            ];
        }
        return array_merge([
            'type' => 'file',
            'source' => 'remote'
        ], $options);
    }

    public static function makeImage($options)
    {
        return array_merge([
            'type' => 'image'
        ], $options);
    }

    public static function makeInput($options)
    {
        return array_merge([
            'type' => 'input'
        ], $options);
    }

    public static function makeContext($options)
    {
        return array_merge([
            'type' => 'context'
        ], $options);
    }
}
