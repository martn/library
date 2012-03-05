<?php

/**
 * My Application
 *
 * @copyright  Copyright (c) 2009 John Doe
 * @package    MyApplication
 * @version    $Id: ErrorPresenter.php 204 2009-02-02 18:27:51Z david@grudl.com $
 */
require_once dirname(__FILE__) . '/BasePresenter.php';

/**
 * Error presenter.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class ErrorPresenter extends BasePresenter {

    /**
     * @return void
     */
    public function renderDefault($exception) {
        if ($this->isAjax()) {
            $this->getAjaxDriver()->events[] = array('error', $exception->getMessage());
            $this->terminate();
        } else {

          //  $this->redirect('Front:Default:default');

            $this->template->robots = 'noindex,noarchive';

            if ($exception instanceof BadRequestException) {
                NEnvironment::getHttpResponse()->setCode($exception->getCode());
                $this->template->title = '404 Not Found';
                $this->setView('404');
            } else {
                NEnvironment::getHttpResponse()->setCode(500);
                $this->template->title = '500 Internal Server Error';
                $this->setView('500');

                NDebug::processException($exception);
            }
        }
    }

}
