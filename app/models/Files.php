<?php

require_once dirname(__FILE__) . '/Base/BaseModel.php';

/**
 * Users authenticator.
 */
class FilesModel extends BaseModel {

    /**
     * (non-PHPdoc)
     * @see scripts/app/models/Base/BaseModel#getTable()
     */
    function getTable() {
        return self::TABLE_FILES;
    }

    /**
     * @desc returns directory where files are stored
     */
    public function getDirectory() {
        return $this->clearPath(DBFILE_DIR);
    }

    private function getFilePath($fileId) {
        return $this->getDirectory() . '/' . $this->getFileName($fileId);
    }

    private function getFileName($fileId) {
        return 'file' . $fileId;
    }


    function processDeleteFile($args) {
        $this->delete($args['id']);
    }

    /**
     * (non-PHPdoc)
     * @see scripts/libs/MyLib/Model/StandardModel#isActionPossible($action)
     */
    function isActionPossible(IAction $action) {
        $args = $action->getArgs();

        switch ($action->getName()) {
            case 'delete':
            case 'deleteFile':
            case 'download':
                if (!$this->exists($args['id'])) {
                    return false;
                } else {
                    $items = new ItemsModel();
                    return $items->isUserOwner($this->find($args['id'])->item_id);
                }
                break;
            default:
                break;
        }
        return $this->userAllowed('items', 'edit');
    }


    
    public function delete($id, $table = null) {
        $f = $this->find($id);
        if (file_exists($f->filename))
            unlink($f->filename);

        parent::delete($id);
    }

    /**
     * @desc returns cleared path ('/' vs '\' etc.)
     */
    private function clearPath($path) {
        return str_replace("\\", "/", $path);
    }

    /**
     * adds file to item
     * @param <type> $itemId
     * @param NHttpUploadedFile $file
     */
    public function addFile($itemId, NHttpUploadedFile $file) {
        if ($file->isOk()) {

            $fileId = parent::insert(array('name' => $file->getName(),
                        'size' => $file->getSize(),
                        'extension' => Utils::getFileExtension($file->getName()),
                        'mimetype' => $file->getContentType(),
                        'item_id' => $itemId,
                        'datetime_insert' => dibi::datetime()),
                            self::TABLE_FILES);

            parent::update(array('id' => $fileId,
                        'filename' => $this->getFileName($fileId)),
                            self::TABLE_FILES);

            $file->move($this->getFilePath($fileId));
        }
    }

    /**
     * @desc stores file to database
     */
    /*    public function insertUploadedFile(HttpUploadedFile $file, $itemId) {
      $filename = $this->clearPath($this->getDirectory() . '/' . $this->uniqueFilename($this->getFileExtension($file->getName())));

      //	print_r($file);
      //        print_r($filename);

      if (copy($this->clearPath($file->getTemporaryFile()), $filename) == false) {
      if (!file_exists($filename)) {
      $success = false;
      } else {
      $success = true;
      }
      } else {
      $success = true;
      }

      if (!$success) {

      throw new Exception('Error copying file.');
      } else {
      return dibi::insert(self::TABLE_FILES, array('id' => '',
      'size' => $file->size,
      'filename' => $filename,
      'name' => $file->name,
      'item_id' => $itemId,
      'datetime_insert' => dibi::datetime()))->execute();
      }
      } */
}

