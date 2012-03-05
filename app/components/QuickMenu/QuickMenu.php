<?php

require_once COMPONENTS_DIR . '/Base/StorageControl.php';

class QuickMenu extends StorageControl {
    const SIZE_SMALL = 'small';
    const SIZE_MEDIUM = 'medium';
    const SIZE_BIG = 'big';

    protected $size;

    /**
     * @param IComponentContainer $parent
     * @param unknown_type $name
     * @return unknown_type
     */
    public function __construct(IComponentContainer $parent = NULL, $name = NULL) {
        parent::__construct($parent, $name);

        $this->setSizeSmall();
    }

    /**
     * @return unknown_type
     */
    function setSizeSmall() {
        return $this->size = self::SIZE_SMALL;
    }

    /**
     * @return unknown_type
     */
    function setSizeMedium() {
        return $this->size = self::SIZE_MEDIUM;
    }

    /**
     * @return unknown_type
     */
    function setSizeBig() {
        return $this->size = self::SIZE_BIG;
    }

    /**
     * returns menu size
     * @return string
     */
    function getSize() {
        return $this->size;
    }

    /**
     * adds new element to the menu
     * @param string $link
     * @param string $icon
     * @param string $text
     * @param string $attrs
     * @return Html
     */
    public function addElement($link, // anchor href
            $icon, // icon identifier
            $text = '', // additional text
            $attrs = '') {  // additional attributes

        // =======================

        $el = NHtml::el('a ' . $attrs)->href($link);

        $this->addObject(new HashTable(array('element' => $el,
                    'icon' => $icon,
                    'text' => $text)));

        $this->setAjax(false);

        return $this;
    }

    /**
     * makes it ajax
     * @param boolean $ajax
     * @return QuickMenu
     */
    function setAjax($ajax = true) {
        if ($this->getCurrent()->offsetExists('ajax')) {
            $this->getCurrent()->offsetSet('ajax', $ajax);
        } else {
            $this->getCurrent()->add('ajax', $ajax);
        }
        return $this;
    }

    /**
     * sets text to confirm
     * @param string $text
     * @return unknown_type
     */
    function setConfirm($text) {
        $this->getCurrent()->add('confirm', $text);
        return $this;
    }


    /**
     * sets title to img element of the icon
     * @param <type> $text
     * @return QuickMenu
     */
    function setIconTitle($text) {
        $this->getCurrent()->add('icontitle', $text);
        return $this;
    }


    /**
     * saves all elements
     * @return unknown_type
     */
    private function saveElements() {
        foreach ($this->getObjects() as $current) {

            $icon = $this->getElement($current['icon'] . '_icon_' . $this->getSize());

            if($current->offsetExists('icontitle')) {
                $icon->title = $current->offsetGet('icontitle');
                $icon->alt = $current->offsetGet('icontitle');
            }

            if ($icon === NULL)
                $icon = $current['icon'];

            $current['element']->setHtml($icon . $current['text']);


            if ($current['ajax']) {
                if (isset($current['confirm'])) {
                    $current['element']->class = 'ajaxconfirm';
                    $current['element']->title = $current['confirm'];
                } else {
                    $current['element']->class = 'ajax';
                }
            } else {

                if (isset($current['confirm'])) {
                    $current['element']->class = 'confirm';
                    $current['element']->title = $current['confirm'];
                }
            }
        }
    }

    protected function getElements() {
        return $this->getObjects();
    }

    
    /**
     * @desc renders the menu
     */
    public function render() {
        $this->saveElements();

        $template = $this->createTemplate();

        $template->data = $this->getElements();
        //$template->count = $this->data->count();

        $template->setFile(dirname(__FILE__) . '/menu.phtml');

        $template->render();
    }

}
