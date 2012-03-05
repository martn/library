<?php

/**
 * My Application
 *
 * @copyright  Copyright (c) 2009 John Doe
 * @package    MyApplication
 * @version    $Id: FeedPresenter.php 215 2009-02-18 16:24:14Z david@grudl.com $
 */

/**
 * Feed channel presenter.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class Front_FeedPresenter extends BasePresenter
{

	/**
	 * @return void
	 */
	protected function startup()
	{
		// disables layout
		$this->setLayout(FALSE);
	}
    
    public function beforeRender() {
        parent::beforeRender();
        
        $this->template->language = $this->lang;
    }

}
