<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MFUUIHTML4SingleUpload
 *
 * @author Jan Kuchař
 */
class MFUUIUploadify extends MFUUIBase {

	/**
	 * Is this upload your upload? (upload from this interface)
	 */
	public function isThisYourUpload() {
		return (
			NEnvironment::getHttpRequest()->getHeader('user-agent') === 'Shockwave Flash'
			AND isSet($_POST["sender"])
			AND $_POST["sender"] == "MFU-Uploadify"
		);
	}

    	/**
	 * Handles uploaded files
	 * forwards it to model
	 */
	public function handleUploads() {
		if(!isset($_POST["token"])) {
			return;
		}

		/* @var $token string */
		$token = $_POST["token"];

		/* @var $file HttpUploadedFile */
		foreach(NEnvironment::getHttpRequest()->getFiles() AS $file) {
			self::processFile($token, $file);
		}

		// Response to client
		echo "1";

		// End the script
		exit;
	}

	/**
	 * Renders interface to <div>
	 */
	public function render(MultipleFileUpload $upload) {
		$template = $this->createTemplate(dirname(__FILE__)."/html.phtml");
		$template->uploadifyId = $upload->getHtmlId() . "-uploadifyBox";
		return $template->__toString(TRUE);
	}

	/**
	 * Renders JavaScript body of function.
	 */
	public function renderInitJavaScript(MultipleFileUpload $upload) {
		$tpl = $this->createTemplate(dirname(__FILE__)."/initJS.js");
		$tpl->sizeLimit = $upload->maxFileSize;
		$tpl->token = $upload->getToken();
		$tpl->maxFiles = $upload->maxFiles;
		$tpl->backLink = (string) $upload->form->action;
		$tpl->uploadifyId = $upload->getHtmlId() . "-uploadifyBox";
		$tpl->simUploadFiles = $upload->simUploadThreads;
		return $tpl->__toString(TRUE);
	}

	/**
	 * Renders JavaScript body of function.
	 */
	public function renderDestructJavaScript(MultipleFileUpload $upload) {
		return $this->createTemplate(dirname(__FILE__)."/destructJS.js")->__toString(TRUE);
	}

	/**
	 * Renders set-up tags to <head> attribute
	 */
	public function renderHeadSection() {
		return $this->createTemplate(dirname(__FILE__)."/head.phtml")->__toString(TRUE);
	}
}