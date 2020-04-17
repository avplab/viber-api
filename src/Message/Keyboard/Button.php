<?php

namespace AvpLab\ViberApi\Message\Keyboard;

use AvpLab\ViberApi\Message\DataEntity;
use AvpLab\ViberApi\Message\Keyboard\Button\Frame;
use AvpLab\ViberApi\Message\Keyboard\Button\InternalBrowser;
use AvpLab\ViberApi\Message\Keyboard\Button\Map;
use AvpLab\ViberApi\Message\Keyboard\Button\MediaPlayer;

class Button implements DataEntity
{
    const BG_MEDIA_TYPE_PICTURE = 'picture';
    const BG_MEDIA_TYPE_GIF = 'gif';

    const SCALE_TYPE_CROP = 'crop';
    const SCALE_TYPE_FILL = 'fill';
    const SCALE_TYPE_FIT = 'fit';

    const ACTION_TYPE_REPLY = 'reply';
    const ACTION_TYPE_OPEN_URL = 'open-url';
    const ACTION_TYPE_LOCATION_PICKER = 'location-picker';
    const ACTION_TYPE_SHARE_PHONE = 'share-phone';
    const ACTION_TYPE_NONE = 'none';

    const TEXT_VALIGN_TOP = 'top';
    const TEXT_VALIGN_MIDDLE = 'middle';
    const TEXT_VALIGN_BOTTOM = 'bottom';

    const TEXT_HALIGN_LEFT = 'left';
    const TEXT_HALIGN_CENTER = 'center';
    const TEXT_HALIGN_RIGHT = 'right';

    const TEXT_SIZE_SMALL = 'small';
    const TEXT_SIZE_MEDIUM = 'medium';
    const TEXT_SIZE_LARGE = 'large';

    const OPEN_URL_TYPE_INTERNAL = 'internal';
    const OPEN_URL_TYPE_EXTERNAL = 'external';

    const OPEN_URL_MEDIA_TYPE_NOT_MEDIA = 'not-media';
    const OPEN_URL_MEDIA_TYPE_VIDEO = 'video';
    const OPEN_URL_MEDIA_TYPE_GIF = 'git';
    const OPEN_URL_MEDIA_TYPE_PICTURE = 'picture';

    private $button = [];

    /**
     * @var InternalBrowser
     */
    private $internalBrowser;

    /**
     * @var MediaPlayer
     */
    private $mediaPlayer;

    /**
     * @var Map
     */
    private $map;

    /**
     * @var Frame
     */
    private $frame;

    public function __construct($actionBody)
    {
        $this->button['ActionBody'] = $actionBody;
    }

    /**
     * @param int $cols
     * @param int $rows
     * @return $this
     */
    public function setSize(int $cols, int $rows)
    {
        $this->button['Columns'] = $cols;
        $this->button['Rows'] = $rows;
        return $this;
    }

    /**
     * @param string $bgColor
     * @return $this
     */
    public function setBgColor(string $bgColor)
    {
        $this->button['BgColor'] = $bgColor;
        return $this;
    }

    /**
     * @param bool $silent
     * @return $this
     */
    public function setSilent(bool $silent)
    {
        $this->button['Silent'] = $silent;
        return $this;
    }

    /**
     * @param string $bgMediaType
     * @return $this
     */
    public function setBgMediaType(string $bgMediaType)
    {
        $this->button['BgMediaType'] = $bgMediaType;
        return $this;
    }

    /**
     * @param string $bgMedia
     * @return $this
     */
    public function setBgMedia(string $bgMedia)
    {
        $this->button['BgMedia'] = $bgMedia;
        return $this;
    }

    /**
     * @param string $bgMediaScaleType
     * @return $this
     */
    public function setBgMediaScaleType(string $bgMediaScaleType)
    {
        $this->button['BgMediaScaleType'] = $bgMediaScaleType;
        return $this;
    }

    /**
     * @param string $imageScaleType
     * @return $this
     */
    public function setImageScaleType(string $imageScaleType)
    {
        $this->button['ImageScaleType'] = $imageScaleType;
        return $this;
    }

    /**
     * @param bool $bgLoop
     * @return $this
     */
    public function setBgLoop(bool $bgLoop)
    {
        $this->button['BgLoop'] = $bgLoop;
        return $this;
    }

    /**
     * @param string $actionType
     * @return $this
     */
    public function setActionType($actionType)
    {
        $this->button['ActionType'] = $actionType;
        return $this;
    }

    /**
     * @param string $actionBody
     * @return $this
     */
    public function setActionBody($actionBody)
    {
        $this->button['ActionBody'] = $actionBody;
        return $this;
    }

    /**
     * @param string $image
     * @return $this
     */
    public function setImage($image)
    {
        $this->button['Image'] = $image;
        return $this;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->button['Text'] = $text;
        return $this;
    }

    /**
     * @param string $textVAlign
     * @return $this
     */
    public function setTextVAlign($textVAlign)
    {
        $this->button['TextVAlign'] = $textVAlign;
        return $this;
    }

    /**
     * @param string $textHAlign
     * @return $this
     */
    public function setTextHAlign($textHAlign)
    {
        $this->button['TextHAlign'] = $textHAlign;
        return $this;
    }

    /**
     * @param int $top
     * @param int $left
     * @param int $bottom
     * @param int $right
     * @return $this
     */
    public function setTextPaddings(int $top, int $left, int $bottom, int $right)
    {
        $this->button['TextPaddings'] = [$top, $left, $bottom, $right];
        return $this;
    }

    /**
     * @param int $textOpacity
     * @return $this
     */
    public function setTextOpacity(int $textOpacity)
    {
        $this->button['TextOpacity'] = $textOpacity;
        return $this;
    }

    /**
     * @param string $textSize
     * @return $this
     */
    public function setTextSize(string $textSize)
    {
        $this->button['TextSize'] = $textSize;
        return $this;
    }

    /**
     * @param string $openURLType
     * @return $this
     */
    public function setOpenURLType(string $openURLType)
    {
        $this->button['OpenURLType'] = $openURLType;
        return $this;
    }

    /**
     * @param string $openURLMediaType
     * @return $this
     */
    public function setOpenURLMediaType(string $openURLMediaType)
    {
        $this->button['OpenURLMediaType'] = $openURLMediaType;
        return $this;
    }

    /**
     * @param string $textBgGradientColor
     * @return $this
     */
    public function setTextBgGradientColor(string $textBgGradientColor)
    {
        $this->button['TextBgGradientColor'] = $textBgGradientColor;
        return $this;
    }

    /**
     * @param bool $textShouldFit
     * @return $this
     */
    public function setTextShouldFit(bool $textShouldFit)
    {
        $this->button['TextShouldFit'] = $textShouldFit;
        return $this;
    }

    /**
     * @param InternalBrowser $internalBrowser
     * @return $this
     */
    public function setInternalBrowser(InternalBrowser $internalBrowser)
    {
        $this->button['InternalBrowser'] = $internalBrowser->getData();
        $this->internalBrowser = $internalBrowser;
        return $this;
    }

    /**
     * @param Map $map
     * @return $this
     */
    public function setMap(Map $map)
    {
        $this->button['Map'] = $map->getData();
        $this->map = $map;
        return $this;
    }

    /**
     * @param Frame $frame
     * @return $this
     */
    public function setFrame(Frame $frame)
    {
        $this->button['Frame'] = $frame->getData();
        $this->frame = $frame;
        return $this;
    }

    /**
     * @param MediaPlayer $mediaPlayer
     * @return $this
     */
    public function setMediaPlayer(MediaPlayer $mediaPlayer)
    {
        $this->button['MediaPlayer'] = $mediaPlayer->getData();
        $this->mediaPlayer = $mediaPlayer;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationRules()
    {
        $rules = [];
        if (isset($this->button['Columns'])) {
            $rules[] = [
                'Button.Columns must be between 1 and 6',
                function() { return $this->button['Columns'] >= 1 && $this->button['Columns'] <= 6; }
            ];
        }
        if (isset($this->button['Rows'])) {
            $rules[] = [
                'Button.Rows must be between 1 and 2',
                function() { return $this->button['Rows'] >= 1  && $this->button['Rows'] <= 2; }
            ];
        }

        if (isset($this->button['BgMediaType'])) {
            $bgMediaTypes = [
                self::BG_MEDIA_TYPE_GIF,
                self::BG_MEDIA_TYPE_PICTURE
            ];
            $rules[] = [
                sprintf('Button.BgMediaType must be one of the %s', implode(', ', $bgMediaTypes)),
                function() use ($bgMediaTypes) {
                    return in_array($this->button['BgMediaType'], $bgMediaTypes);
                }
            ];
        }

        $scaleTypes = [
            self::SCALE_TYPE_CROP,
            self::SCALE_TYPE_FILL,
            self::SCALE_TYPE_FIT
        ];
        if (isset($this->button['BgMediaScaleType'])) {
            $rules[] = [
                'Button.BgMediaScaleType requires at least API version 6',
                function($message) { return $message['min_api_version'] >= 6; }
            ];
            $rules[] = [
                sprintf('Button.BgMediaScaleType must be one of the %s', implode(', ', $scaleTypes)),
                function() use ($scaleTypes) {
                    return in_array($this->button['BgMediaScaleType'], $scaleTypes);
                }
            ];
        }
        if (isset($this->button['ImageScaleType'])) {
            $rules[] = [
                'Button.ImageScaleType requires at least API version 6',
                function($message) { return $message['min_api_version'] >= 6; }
            ];
            $rules[] = [
                sprintf('Button.ImageScaleType must be one of the %s', implode(', ', $scaleTypes)),
                function() use ($scaleTypes) {
                    return in_array($this->button['ImageScaleType'], $scaleTypes);
                }
            ];
        }

        $rules[] = [
            'Button.ActionBody is required',
            function() { return isset($this->button['ActionBody']); }
        ];

        if (isset($this->button['ActionType'])) {
            $actionTypes = [
                self::ACTION_TYPE_REPLY,
                self::ACTION_TYPE_OPEN_URL,
                self::ACTION_TYPE_LOCATION_PICKER,
                self::ACTION_TYPE_SHARE_PHONE,
                self::ACTION_TYPE_NONE
            ];
            $rules[] = [
                sprintf('Button.ActionType must be one of the %s', implode(', ', $actionTypes)),
                function() use ($actionTypes) {
                    return in_array($this->button['ActionType'], $actionTypes);
                }
            ];
        }

        if (isset($this->button['TextVAlign'])) {
            $vAlignTypes = [
                self::TEXT_VALIGN_TOP,
                self::TEXT_VALIGN_MIDDLE,
                self::TEXT_VALIGN_BOTTOM
            ];
            $rules[] = [
                sprintf('Button.TextVAlign must be one of the %s', implode(', ', $vAlignTypes)),
                function() use ($vAlignTypes) {
                    return in_array($this->button['ActionType'], $vAlignTypes);
                }
            ];
        }
        if (isset($this->button['TextHAlign'])) {
            $hAlignTypes = [
                self::TEXT_HALIGN_LEFT,
                self::TEXT_HALIGN_CENTER,
                self::TEXT_HALIGN_RIGHT
            ];
            $rules[] = [
                sprintf('Button.TextHAlign must be one of the %s', implode(', ', $hAlignTypes)),
                function() use ($hAlignTypes) {
                    return in_array($this->button['TextHAlign'], $hAlignTypes);
                }
            ];
        }

        if (isset($this->button['TextPaddings'])) {
            $rules[] = [
                'Button.TextPaddings requires at least API version 4',
                function($message) { return $message['min_api_version'] >= 4; }
            ];
            $rules[] = [
                'Button.TextPaddings per padding must be between 1 and 12',
                function() {
                    return !array_filter($this->button['TextPaddings'], function($item) { return $item < 1 || $item > 12; });
                }
            ];
        }

        if (isset($this->button['TextOpacity'])) {
            $rules[] = [
                'Button.TextOpacity must be between 0 and 100',
                function() {
                    return $this->button['TextOpacity'] >=0 && $this->button['TextOpacity'] <= 100;
                }
            ];
        }

        if (isset($this->button['OpenURLType'])) {
            $openUrlTypes = [
                self::OPEN_URL_TYPE_EXTERNAL,
                self::OPEN_URL_TYPE_INTERNAL
            ];
            $rules[] = [
                sprintf('Button.OpenURLType must be one of the %s', implode(', ', $openUrlTypes)),
                function() use ($openUrlTypes) {
                    return in_array($this->button['OpenURLType'], $openUrlTypes);
                }
            ];
        }

        if (isset($this->button['OpenURLMediaType'])) {
            $openUrlMediaTypes = [
                self::OPEN_URL_MEDIA_TYPE_NOT_MEDIA,
                self::OPEN_URL_MEDIA_TYPE_VIDEO,
                self::OPEN_URL_MEDIA_TYPE_GIF,
                self::OPEN_URL_MEDIA_TYPE_PICTURE
            ];
            $rules[] = [
                sprintf('Button.OpenURLMediaType must be one of the %s', implode(', ', $openUrlMediaTypes)),
                function() use ($openUrlMediaTypes) {
                    return in_array($this->button['OpenURLMediaType'], $openUrlMediaTypes);
                }
            ];
        }

        if (isset($this->button['TextShouldFit'])) {
            $rules[] = [
                'Button.TextShouldFit requires at least API version 6',
                function($message) { return $message['min_api_version'] >= 6; }
            ];
        }

        if ($this->internalBrowser instanceof DataEntity) {
            if (isset($this->button['InternalBrowser'])) {
                $rules[] = [
                    'Button.InternalBrowser requires at least API version 3',
                    function($message) { return $message['min_api_version'] >= 3; }
                ];
            }
            $rules = array_merge($rules, $this->internalBrowser->getValidationRules());
        }

        if ($this->map instanceof DataEntity) {
            if (isset($this->button['Map'])) {
                $rules[] = [
                    'Button.Map requires at least API version 6',
                    function($message) { return $message['min_api_version'] >= 6; }
                ];
            }
            $rules = array_merge($rules, $this->map->getValidationRules());
        }

        if ($this->frame instanceof DataEntity) {
            if (isset($this->button['Frame'])) {
                $rules[] = [
                    'Button.Frame requires at least API version 6',
                    function($message) { return $message['min_api_version'] >= 6; }
                ];
            }
            $rules = array_merge($rules, $this->frame->getValidationRules());
        }

        if ($this->mediaPlayer instanceof DataEntity) {
            if (isset($this->button['MediaPlayer'])) {
                $rules[] = [
                    'Button.MediaPlayer requires at least API version 6',
                    function($message) { return $message['min_api_version'] >= 6; }
                ];
            }
            $rules = array_merge($rules, $this->mediaPlayer->getValidationRules());
        }

        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->button;
    }
}