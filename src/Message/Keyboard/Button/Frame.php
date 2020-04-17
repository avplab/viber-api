<?php

namespace AvpLab\ViberApi\Message\Keyboard\Button;

use AvpLab\ViberApi\Message\DataEntity;

class Frame implements DataEntity
{
    /**
     * @var array
     */
    private $frame = [];

    /**
     * @param int $borderWidth
     * @return $this
     */
    public function setBorderWidth(int $borderWidth)
    {
        $this->frame['BorderWidth'] = $borderWidth;
        return $this;
    }

    /**
     * @param string $borderColor
     * @return $this
     */
    public function setBorderColor(string $borderColor)
    {
        $this->frame['BorderColor'] = $borderColor;
        return $this;
    }

    /**
     * @param int $cornerRadius
     * @return $this
     */
    public function setCornerRadius(int $cornerRadius)
    {
        $this->frame['CornerRadius'] = $cornerRadius;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationRules()
    {
        $rules = [];
        if (isset($this->frame['BorderWidth'])) {
            $rules[] = [
                'Frame.BorderWidth must be between 0 and 10',
                function() {
                    return $this->frame['BorderWidth'] >= 0 && $this->frame['BorderWidth'] <= 10;
                }
            ];
        }

        if (isset($this->frame['CornerRadius'])) {
            $rules[] = [
                'Frame.CornerRadius must be between 0 and 10',
                function() {
                    return $this->frame['CornerRadius'] >= 0 && $this->frame['CornerRadius'] <= 10;
                }
            ];
        }
        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->frame;
    }
    
}