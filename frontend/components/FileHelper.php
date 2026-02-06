<?php

namespace frontend\components;

use PhpOffice\PhpWord\TemplateProcessor;
use yii\web\ForbiddenHttpException;

class FileHelper
{

    /**
     * @param $filePath
     * @param $data (values to replace ['cc_name' => 'Client name'])
     * @param array $cloneRows (['l_number' => 5, ..])
     * @param bool $toFileName (filename to save)
     * @return bool|string
     * @throws ForbiddenHttpException
     */
    public static function templateDocx($filePath, $data)
    {

        $tmpName = uniqid('docxtemplate', true) . '.docx';

        $templateProcessor = new TemplateProcessor($filePath);

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        $savePath = \Yii::getAlias('@frontend/web/upload/' . $tmpName);

        // Берем /tmp/ файл
        $savePath = $templateProcessor->save($savePath);


        $content = file_get_contents($savePath);
//        unlink(\Yii::getAlias('@frontend/web/upload/' . $tmpName));  // remove temp file

//        var_dump($content);
//        die();
        return $content;
    }

    public static function downloadFile($fileName, $content)
    {
        ob_start();
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Disposition:attachment;filename*=UTF-8''" . rawurlencode("{$fileName}"));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . mb_strlen($content, '8bit'));
        echo $content;
        exit(0);
    }

}