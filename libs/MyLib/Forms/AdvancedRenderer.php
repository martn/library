<?php

/**
 * MyLib
 *
 * @copyright  Copyright (c) 2010 Martin Novák
 * @category   MyLib
 * @package    MyLib
 */
/**
 * Converts a Form into the HTML output, additional functionality of quick help and other
 *
 * @copyright  Copyright (c) 2010 Martin Novák
 * @package    MyLib
 */
require_once LIBS_DIR . '/Nette/Forms/Renderers/ConventionalRenderer.php';

class AdvancedRenderer extends NConventionalRenderer {
    const ADDITIONAL_HTML = 'additionalHtml';

    /**
     * Renders 'label' part of visual row of controls.
     * @param  IFormControl
     * @return string
     */
    public function renderLabel(IFormControl $control) {
        $label = parent::renderLabel($control);

        $options = $control->getOption(self::ADDITIONAL_HTML, array());

        if (count($options) > 0) {
            $html = '';

            foreach ($options as $option) {
                $html .= $option;
            }

            $dd = NHtml::el('div')->class('label_with_tooltip')->setHtml($label);

            return $dd . $html;
        } else {
            return $label;
        }
    }

}