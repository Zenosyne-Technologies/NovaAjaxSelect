<?php

namespace Zenosyne\AjaxSelect;

use Laravel\Nova\Fields\Field;

class AjaxSelect extends Field
{
    public $showOnIndex = false;

    public $showOnDetail = false;

    public $component = 'zenosyne-ajax-select';

    /**
     * @param string $endpoint
     * @return $this
     */
    public function get(string $endpoint): AjaxSelect
    {
        $this->withMeta(['endpoint' => $endpoint]);

        return $this;
    }


    /**
     * @param array $attribute
     * @return $this
     */
    public function parent(array $attribute): AjaxSelect
    {
        $this->withMeta(['parent_attribute' => $attribute]);

        return $this;
    }
}
