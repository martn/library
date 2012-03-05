<?php

/**
 * Form macros
 *
 * @author Jan Marek
 * @license MIT
 */
class FormMacros extends NObject {

    private static $form;

    public function __construct() {
        throw new InvalidStateException("Static class.");
    }

    public static function register() {
        /* LatteMacros::$defaultMacros["form"] = '<?php %Nette\Templates\FormMacros::macroBegin% ?>';
          LatteMacros::$defaultMacros["input"] = '<?php %Nette\Templates\FormMacros::macroInput% ?>';
          LatteMacros::$defaultMacros["label"] = '<?php %Nette\Templates\FormMacros::macroLabel% ?>';
          LatteMacros::$defaultMacros["/form"] = '<?php Nette\Templates\FormMacros::end() ?>'; */

        NLatteMacros::$defaultMacros["form"] = '<?php %FormMacros::macroBegin% ?>';
        NLatteMacros::$defaultMacros["input"] = '<?php %FormMacros::macroInput% ?>';
        NLatteMacros::$defaultMacros["label"] = '<?php %FormMacros::macroLabel% ?>';
        NLatteMacros::$defaultMacros["/form"] = '<?php FormMacros::end() ?>';
    }

    public static function macroBegin($content) {
        list($name, $modifiers) = self::fetchNameAndModifiers($content);
        return "\$formErrors = FormMacros::begin($name, \$control, $modifiers)->getErrors()";
    }

    public static function begin($form, $control, $modifiers = array()) {
        if ($form instanceof Form) {
            self::$form = $form;
        } else {
            self::$form = $control[$form];
        }

        if (isset($modifiers["class"])) {
            self::$form->getElementPrototype()->class[] = $modifiers["class"];
        }

        self::$form->render("begin");

        return self::$form;
    }

    public static function end() {
        self::$form->render("end");
    }

    public static function macroInput($content) {
        list($name, $modifiers) = self::fetchNameAndModifiers($content);
        return "FormMacros::input($name, $modifiers)";
    }

    public static function input($name, $modifiers = array()) {
        $input = self::$form[$name]->getControl();

        if (isset($modifiers["size"])) {
            $input->size($modifiers["size"]);
        }

        if (isset($modifiers["rows"])) {
            $input->rows($modifiers["rows"]);
        }

        if (isset($modifiers["cols"])) {
            $input->cols($modifiers["cols"]);
        }

        if (isset($modifiers["class"])) {
            $input->class[] = $modifiers["class"];
        }

        if (isset($modifiers["style"])) {
            $input->style($modifiers["style"]);
        }

        if (isset($modifiers["value"])) {
            $input->value($modifiers["value"]);
        }

        echo $input;
    }

    public static function macroLabel($content) {
        list($name, $modifiers) = self::fetchNameAndModifiers($content);
        return "FormMacros::label($name, $modifiers)";
    }

    public static function label($name, $modifiers = array()) {
        $label = self::$form[$name]->getLabel();

        if (isset($modifiers["text"])) {
            $label->setText($modifiers["text"]);
        }

        if (isset($modifiers["class"])) {
            $label->class[] = $modifiers["class"];
        }

        if (isset($modifiers["style"])) {
            $label->style($modifiers["style"]);
        }

        echo $label;
    }

    // helper

    private static function fetchNameAndModifiers($code) {
        $name = NLatteFilter::fetchToken($code);
        $modifiers = NLatteFilter::formatArray($code);

        $name = NString::startsWith($name, '$') ? $name : "'$name'";
        $modifiers = $modifiers ? $modifiers : "array()";

        return array($name, $modifiers);
    }

}