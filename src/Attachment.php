<?php

namespace Cian\Slack;

 use Cian\Slack\ArrayObject;

class Attachment extends ArrayObject
{
    /**
     * A plain-text summary of the attachment.
     * This text will be used in clients that don't show formatted text (eg. IRC, mobile notifications) and should not contain any markup.
     * 
     * @var string|null $fallback
     */
    public $fallback;

    /**
     * Like traffic signals, color-coding messages can quickly communicate intent and help separate them from the flow of other messages in the timeline.
     * An optional value that can either be one of good, warning, danger, or any hex color code (eg. #439FE0).
     * This value is used to color the border along the left side of the message attachment.
     * 
     * @var string|null $color
     */
    public $color;

    /**
     * This is optional text that appears above the message attachment block.
     * 
     * @var string|null $pretext
     */
    public $pretext;

    /**
     * Small text used to display the author's name.
     * 
     * @var string|null $authorName
     */
    public $authorName;

    /**
     * A valid URL that will hyperlink the author_name text mentioned above.
     * Will only work if author_name is present.
     * 
     * @var string|null $authorLink
     */
    public $authorLink;

    /**
     * A valid URL that displays a small 16x16px image to the left of the author_name text.
     * Will only work if author_name is present.
     * 
     * @var string|null $authorIcon
     */
    public $authorIcon;

    /**
     * The title is displayed as larger,
     * bold text near the top of a message attachment.
     * 
     * @var string|null $title
     */
    public $title;

    /**
     * By passing a valid URL in the title_link parameter (optional),
     * the title text will be hyperlinked.
     * 
     * @var string|null $titleLink
     */
    public $titleLink;

    /**
     * This is the main text in a message attachment, and can contain standard message markup.
     * The content will automatically collapse if it contains 700+ characters or 5+ linebreaks,
     * and will display a "Show more..." link to expand the content.
     * Links posted in the text field will not unfurl.
     * 
     * @var string|null $text
     */
    public $text;

    /**
     * Fields are defined as an array.
     * Each entry in the array is a single field.
     * Each field is defined as a dictionary with key-value pairs.
     * For best results, include no more than 2-3 key/value pairs.
     * There is no optimal, programmatic way to display a greater amount of tabular data on Slack today.
     * 
     * @var Cian\Slack\Messages\AttachmentField[] $fields
     */
    public $fields = [];

    /**
     * A valid URL to an image file that will be displayed inside a message attachment.
     * Large images will be resized to a maximum width of 360px or a maximum height of 500px,
     * while still maintaining the original aspect ratio.
     * 
     * @var string|null $imageUrl
     */
    public $imageUrl;

    /**
     * A valid URL to an image file that will be displayed as a thumbnail on the right side of a message attachment.
     * The thumbnail's longest dimension will be scaled down to 75px while maintaining the aspect ratio of the image.
     * The filesize of the image must also be less than 500 KB.
     * For best results, please use images that are already 75px by 75px.
     * 
     * @var string|null $thumbUrl
     */
    public $thumbUrl;

    /**
     * Add some brief text to help contextualize and identify an attachment.
     * Limited to 300 characters,
     * and may be truncated further when displayed to users in environments with limited screen real estate.
     * 
     * @var string|null $footer
     */
    public $footer;

    /**
     * To render a small icon beside your footer text,
     * provide a publicly accessible URL string in the footer_icon field.
     * You must also provide a footer for the field to be recognized.
     * 
     * @var string|null $footerIcon
     */
    public $footerIcon;

    /**
     * By providing the ts field with an integer value in "epoch time",
     * the attachment will display an additional timestamp value as part of the attachment's footer.
     * 
     * Use ts when referencing articles or happenings.
     * Your message's timestamp will be displayed in varying ways,
     * depending on how far in the past or future it is,
     * relative to the present. Form factors,
     * like mobile versus desktop may also transform its rendered appearance.
     * 
     * Example: Providing 123456789 would result in a rendered timestamp of Nov 29th, 1973.
     * If it were currently 1973, the year might be trimmed off.
     * If it were only a few days ago, we might display also display the time of day, like 9:33pm.
     * 
     * @var int|null $ts
     */
    public $ts;

    public function __get($key)
    {
        return $this->$key;
    }

    public function __set($key, $value)
    {
        return $this->$key = $value;
    }
}