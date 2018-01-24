<?php
namespace MyApp;

class ImgUpload
{

    //画像アップ
    public function upload()
    {
        try {
            // error check
            $this->_validateUpload();

            // type check
            $ext = $this->_validateImageType();
            // var_dump($ext);
            // exit;

            // save
            $savePath = $this->_save($ext);
            return $savePath;


        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }
        // redirect
    }


    private function _save($ext)
    {
        $this->_imageFileName = sprintf(
            '%s_%s.%s',
            time(),
            sha1(uniqid(mt_rand(), true)),
            $ext
        );
        $savePath = 'images/' . $this->_imageFileName;
        $res = move_uploaded_file($_FILES['image']['tmp_name'], $savePath);
        if ($res === false) {
            throw new \Exception('Could not upload!');
        }
        return $savePath;
    }

    private function _validateImageType()
    {
        $imageType = exif_imagetype($_FILES['image']['tmp_name']);
        switch ($imageType) {
            case IMAGETYPE_GIF:
                return 'gif';
            case IMAGETYPE_JPEG:
                return 'jpg';
            case IMAGETYPE_PNG:
                return 'png';
            default:
                throw new \Exception('PNG/JPEG/GIF only!');
        }
    }

    private function _validateUpload()
    {
        // var_dump($_FILES);
        // exit;

        if (!isset($_FILES['image']) || !isset($_FILES['image']['error'])) {
            throw new \Exception('Upload Error!');
        }

        switch ($_FILES['image']['error']) {
            case UPLOAD_ERR_OK:
                return true;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new \Exception('File too large!');
            default:
                throw new \Exception('Err: ' . $_FILES['image']['error']);
        }

    }
}