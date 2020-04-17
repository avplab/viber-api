<?php

namespace AvpLab\ViberApi\Message;

use AvpLab\ViberApi\Message\Keyboard\Button;
use AvpLab\ViberApi\Message\Keyboard\FavoritesMetadata;

class Keyboard implements DataEntity
{
    const INPUT_FIELD_STATE_REGULAR = 'regular';
    const INPUT_FIELD_STATE_MINIMIZED = 'minimized';
    const INPUT_FIELD_STATE_HIDDEN = 'hidden';

    /**
     * @var array
     */
    private $keyboard = [];

    /**
     * @var Button[]
     */
    private $buttons = [];

    /**
     * @var FavoritesMetadata
     */
    private $favoritesMetadata;

    /**
     * @param string $bgColor
     * @return $this
     */
    public function setBgColor(string $bgColor)
    {
        $this->keyboard['BgColor'] = $bgColor;
        return $this;
    }

    /**
     * @param bool $defaultHeight
     * @return $this
     */
    public function setDefaultHeight(bool $defaultHeight)
    {
        $this->keyboard['DefaultHeight'] = $defaultHeight;
        return $this;
    }

    /**
     * @param int $customDefaultHeight
     * @return $this
     */
    public function setCustomDefaultHeight(int $customDefaultHeight)
    {
        $this->keyboard['CustomDefaultHeight'] = $customDefaultHeight;
        return $this;
    }

    /**
     * @param int $heightScale
     * @return $this
     */
    public function setHeightScale(int $heightScale)
    {
        $this->keyboard['HeightScale'] = $heightScale;
        return $this;
    }

    /**
     * @param int $buttonsGroupColumns
     * @return $this
     */
    public function setButtonsGroupColumns(int $buttonsGroupColumns)
    {
        $this->keyboard['ButtonsGroupColumns'] = $buttonsGroupColumns;
        return $this;
    }

    /**
     * @param int $buttonsGroupRows
     * @return $this
     */
    public function setButtonsGroupRows(int $buttonsGroupRows)
    {
        $this->keyboard['ButtonsGroupRows'] = $buttonsGroupRows;
        return $this;
    }

    /**
     * @param string $inputFieldState
     * @return $this
     */
    public function setInputFieldState(string $inputFieldState)
    {
        $this->keyboard['InputFieldState'] = $inputFieldState;
        return $this;
    }

    /**
     * @param FavoritesMetadata $favoritesMetadata
     * @return $this
     */
    public function setFavoritesMetadata(FavoritesMetadata $favoritesMetadata)
    {
        $this->keyboard['FavoritesMetadata'] = $favoritesMetadata->getData();
        $this->favoritesMetadata = $favoritesMetadata;
        return $this;
    }

    /**
     * @param Button $button
     * @return $this
     */
    public function addButton(Button $button)
    {
        $this->keyboard['Buttons'][] = $button->getData();
        $this->buttons[] = $button;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationRules()
    {
        $rules = [
            [
                'At least one button should be added to the keyboard',
                function() { return isset($this->keyboard['Buttons']); }
            ]
        ];

        if (isset($this->keyboard['CustomDefaultHeight'])) {
            $rules[] = [
                'Keyboard.CustomDefaultHeight requires at least API version 3',
                function($message) { return $message['min_api_version'] >= 3; }
            ];
            $rules[] = [
                'Keyboard.CustomDefaultHeight must be between 40 and 70',
                function() { return $this->keyboard['CustomDefaultHeight'] >= 40 && $this->keyboard['CustomDefaultHeight'] <= 70; }
            ];
        }

        if (isset($this->keyboard['HeightScale'])) {
            $rules[] = [
                    'Keyboard.HeightScale requires at least API version 3',
                    function($message) { return $message['min_api_version'] >= 3; }
            ];
            $rules[] = [
                'Keyboard.HeightScale must be between 20 and 100',
                function() { return $this->keyboard['HeightScale'] >= 20 && $this->keyboard['HeightScale'] <= 100; }
            ];
        }

        if (isset($this->keyboard['ButtonsGroupColumns'])) {
            $rules[] = [
                'Keyboard.ButtonsGroupColumns requires at least API version 4',
                function($message) { return $message['min_api_version'] >= 4; }
            ];
            $rules[] = [
                'Keyboard.ButtonsGroupColumns must be between 1 and 6',
                function() {
                    return $this->keyboard['ButtonsGroupColumns'] >= 1 && $this->keyboard['ButtonsGroupColumns'] <= 6;
                }
            ];
        }

        if (isset($this->keyboard['ButtonsGroupRows'])) {
            $rules[] = [
                'Keyboard.ButtonsGroupRows requires at least API version 4',
                function($message) { return $message['min_api_version'] >= 4; }
            ];
            $rules[] = [
                'Keyboard.ButtonsGroupRows must be between 1 and 7',
                function() {
                    return $this->keyboard['ButtonsGroupRows'] >= 1 && $this->keyboard['ButtonsGroupRows'] <= 7;
                }
            ];
        }

        if (isset($this->keyboard['InputFieldState'])) {
            $rules[] = [
                'Keyboard.InputFieldState requires at least API version 4',
                function($message) { return $message['min_api_version'] >= 4; }
            ];
            $inputFieldStates = [
                self::INPUT_FIELD_STATE_REGULAR,
                self::INPUT_FIELD_STATE_MINIMIZED,
                self::INPUT_FIELD_STATE_HIDDEN
            ];
            $rules[] = [
                sprintf('Keyboard.InputFieldState must be one of the %s', implode(', ', $inputFieldStates)),
                function() use ($inputFieldStates) {
                    return in_array($this->keyboard['InputFieldState'], $inputFieldStates);
                }
            ];
        }

        // Buttons rules
        foreach ($this->buttons as $button) {
            $rules = array_merge($rules, $button->getValidationRules());
        }

        // FavoritesMetadata rules
        if ($this->favoritesMetadata instanceof DataEntity) {
            $rules[] = [
                'Keyboard.FavoritesMetadata requires at least API version 6',
                function($message) { return $message['min_api_version'] >= 6; }
            ];
            $rules = array_merge($rules, $this->favoritesMetadata->getValidationRules());
        }
        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->keyboard;
    }
}