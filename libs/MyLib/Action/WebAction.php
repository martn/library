<?php

//require_once LIBS_DIR.'/dibi/dibi.php';
require_once dirname(__FILE__) . '/Action.php';
require_once dirname(__FILE__) . '/IWebAction.php';

/**
 * @author martin
 *
 */
class WebAction extends Action implements IWebAction {
    const BASE64_ENCODE = false;

    /**
     * @var IActionContainer
     */
    protected $container = NULL;

    /**
     * @var boolean
     */
    protected $isSignal = false;
    
    /**
     * @var string
     */
    protected $link;

    /**
     * @param IActionContainer $container
     * @param string $link
     * @param mixed $args
     * @return unknown_type
     */
    public function __construct($link, // action name - refers to model action and component signal/action,
            IActionModel $model, IActionContainer $container = NULL, array $args = array()) { // arguments array
        
        if($container) $this->setContainer($container);

        $name = $this->link = trim($link);

        // signal!
        if (NString::endsWith($link, "!")) {
            $name = trim($link, " !");
            $this->isSignal = true;
        }

        // presenter:view
        $expl = explode(":", $link);
        if (count($expl) > 1)
            $name = end($expl);

        parent::__construct($name, $model, $args);
    }

    
    public function getContainer() {
        return $this->container;
    }


    public function setContainer(NPresenterComponent $container) {
        $this->container = $container;
    }

    
    /**
     *  returns new clone of the object
     * @return self
     */
    function getClone() {
        return new self($this->link, $this->model, $this->container, $this->getArgs());
    }

    /**
     * returns action link if it's possible
     * @return string
     * @throws ActionNotPossibleException
     */
    function getLink() {
       // if ($this->isPossible()) {
            if ($this->isSignal) {
                return $this->container->link($this->link, array($this->container->getActionVariableName() => $this->getString()));
            } else {
                return $this->container->link($this->link, $this->getArgs());
            }
     /*   } else {
            throw new ActionNotPossibleException();
        }*/
    }


    
    /**
     * @return string
     */
    function getString() {
        // Create Params Array
        $p = $this->getArgs();

        // Join Params
        array_walk($p, create_function('&$i,$k', '$i="$k;$i;";'));

        $str = get_class($this->getModel()) . '|' . implode($p, "");

        if (self::BASE64_ENCODE)
            $str = base64_encode($str);

        return $str;
    }

    
    /**
     * returns new Action object from PresenterComponent (implementing IActionContainer)
     * from Action-generated signal
     * @param IActionContainer $container
     * @return Action
     * @throws InvalidSignalException
     */
    static function fromSignal(IActionContainer $container) {
        list($receiver, $signal) = $container->getSignal();

        $aString = $container->getActionString();

        // base64 coding ?
        if (self::BASE64_ENCODE)
            $aString = base64_decode($aString, true);


        if ($aString === false) {

            throw new InvalidSignalException();
        } else {

            $ar = explode("|", $aString);

            $rawArgs = explode(";", $ar[1]);
            array_pop($rawArgs);

            $args = array();
            for ($i = 0; $i < count($rawArgs); $i = $i + 2) {
                $args[$rawArgs[$i]] = $rawArgs[$i + 1];
            }

            return new self($signal, new $ar[0], $container, $args);
        }
    }

}

class InvalidSignalException extends Exception {

}
