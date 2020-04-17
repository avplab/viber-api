<?php

namespace AvpLab\ViberApi\Message\Keyboard\Button;

use AvpLab\ViberApi\Message\DataEntity;

class InternalBrowser implements DataEntity
{
    const ACTION_BUTTON_FORWARD = 'forward';
    const ACTION_BUTTON_SEND = 'forward';
    const ACTION_BUTTON_OPEN_EXTERNALLY = 'open-externally';
    const ACTION_BUTTON_SEND_TO_BOT = 'send-to-bot';
    const ACTION_BUTTON_NONE = 'none';

    const TITLE_TYPE_DOMAIN = 'domain';
    const TITLE_TYPE_DEFAULT = 'default';

    const FOOTER_TYPE_DEFAULT = 'default';
    const FOOTER_TYPE_HIDDEN = 'hidden';

    const MODE_FULLSCREEN = 'fullscreen';
    const MODE_FULLSCREEN_PORTRAIT = 'fullscreen-portrait';
    const MODE_FULLSCREEN_LANDSCAPE = 'fullscreen-landscape';
    const MODE_FULLSCREEN_PARTIAL_SIZE = 'partial-size';

    /**
     * @var array
     */
    private $internalBrowser = [];

    /**
     * @param string $actionButton
     * @return $this
     */
    public function setActionButton(string $actionButton)
    {
        $this->internalBrowser['ActionButton'] = $actionButton;
        return $this;
    }

    /**
     * @param string $actionPredefinedURL
     * @return $this
     */
    public function setActionPredefinedURL(string  $actionPredefinedURL)
    {
        $this->internalBrowser['ActionPredefinedURL'] = $actionPredefinedURL;
        return $this;
    }

    /**
     * @param string $titleType
     * @return $this
     */
    public function setTitleType(string $titleType)
    {
        $this->internalBrowser['TitleType'] = $titleType;
        return $this;
    }

    /**
     * @param string $customTitle
     * @return $this
     */
    public function setCustomTitle(string $customTitle)
    {
        $this->internalBrowser['CustomTitle'] = $customTitle;
        return $this;
    }

    /**
     * @param string $mode
     * @return $this
     */
    public function setMode(string $mode)
    {
        $this->internalBrowser['Mode'] = $mode;
        return $this;
    }

    /**
     * @param string $footerType
     * @return $this
     */
    public function setFooterType(string $footerType)
    {
        $this->internalBrowser['FooterType'] = $footerType;
        return $this;
    }

    /**
     * @param string $actionReplyData
     * @return $this
     */
    public function setActionReplyData(string $actionReplyData)
    {
        $this->internalBrowser['ActionReplyData'] = $actionReplyData;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationRules()
    {
        $rules = [];

        if (isset($this->internalBrowser['ActionButton'])) {
            $actionButtons = [
                self::ACTION_BUTTON_FORWARD,
                self::ACTION_BUTTON_NONE,
                self::ACTION_BUTTON_OPEN_EXTERNALLY,
                self::ACTION_BUTTON_SEND,
                self::ACTION_BUTTON_SEND_TO_BOT
            ];
            $rules[] = [
                sprintf('InternalBrowser.ActionButton must be one of the %s', implode(', ', $actionButtons)),
                function() use ($actionButtons) {
                    return in_array($this->internalBrowser['ActionButton'], $actionButtons);
                }
            ];
        }

        if (isset($this->internalBrowser['ActionPredefinedURL'])) {
            $rules[] = [
                'InternalBrowser.ActionPredefinedURL must be 1 or more characters',
                function() {
                    return strlen($this->internalBrowser['ActionPredefinedURL']) >= 1;
                }
            ];
        }

        if (isset($this->internalBrowser['TitleType'])) {
            $titleTypes = [
                self::ACTION_BUTTON_FORWARD,
                self::ACTION_BUTTON_NONE,
                self::ACTION_BUTTON_OPEN_EXTERNALLY,
                self::ACTION_BUTTON_SEND,
                self::ACTION_BUTTON_SEND_TO_BOT
            ];
            $rules[] = [
                sprintf('InternalBrowser.TitleType must be one of the %s', implode(', ', $titleTypes)),
                function() use ($titleTypes) {
                    return in_array($this->internalBrowser['TitleType'], $titleTypes);
                }
            ];
        }

        if (isset($this->internalBrowser['CustomTitle'])) {
            $rules[] = [
                'InternalBrowser.CustomTitle must be up to 15 characters',
                function() {
                    return strlen($this->internalBrowser['CustomTitle']) <= 15;
                }
            ];
        }

        if (isset($this->internalBrowser['Mode'])) {
            $modes = [
                self::MODE_FULLSCREEN,
                self::MODE_FULLSCREEN_PORTRAIT,
                self::MODE_FULLSCREEN_LANDSCAPE,
                self::MODE_FULLSCREEN_PARTIAL_SIZE
            ];
            $rules[] = [
                sprintf('InternalBrowser.Mode must be one of the %s', implode(', ', $modes)),
                function() use ($modes) {
                    return in_array($this->internalBrowser['Mode'], $modes);
                }
            ];
        }

        if (isset($this->internalBrowser['FooterType'])) {
            $footerTypes = [
                self::FOOTER_TYPE_DEFAULT,
                self::FOOTER_TYPE_HIDDEN
            ];
            $rules[] = [
                sprintf('InternalBrowser.FooterType must be one of the %s', implode(', ', $footerTypes)),
                function() use ($footerTypes) {
                    return in_array($this->internalBrowser['FooterType'], $footerTypes);
                }
            ];
        }

        if (isset($this->internalBrowser['ActionReplyData'])) {
            $rules[] = [
                'InternalBrowser.ActionReplyData requires at least API version 6',
                function($message) { return $message['min_api_version'] >= 6; }
            ];
        }
        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->internalBrowser;
    }
    
}
