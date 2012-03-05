<?php

/**
 * Error presenter.
 *
 * @author     John Doe
 * @package    MyApplication
 */
require_once dirname(__FILE__) . '/Base/BasePresenter.php';

class Front_FilePresenter extends Front_BasePresenter {

    
    public function actionDownload($id) {
        try {
            $file = $this->modelFiles->find($id);

            $action = new Action('download', $this->modelFiles, array('id'=>$id));

            if ($action->isPossible()) {
                $downloader = new FileDownload();
                $downloader->sourceFile = $this->modelFiles->getDirectory() .'/'. $file->filename;
                $downloader->transferFileName = $file->name;

                $downloader->download();
                
            } else {
                $this->flashMessage('Nemáte oprávnění tento soubor stáhnout, požádejte o něj jeho vlastníka.');
            }
        } catch (NotFoundException $e) {
            $this->flashMessage('Záznam souboru v databázi nenalezen', 'error');
        } catch (NBadRequestException $e) {
            $this->flashMessage('Soubor nenalezen', 'error');
        }
    }
}
