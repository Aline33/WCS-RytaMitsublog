<?php

namespace App\Controller;

use App\Model\PictureManager;

class PictureController extends AbstractController
{
    public function add(int $id): void
    {
        $uploadDir = 'assets/images/';
        if (isset($_FILES)) {
            foreach ($_FILES as $picture) {
                if ($picture['error'] == UPLOAD_ERR_NO_FILE) {
                    continue;
                }
                $extension = pathinfo($picture['name'], PATHINFO_EXTENSION);
                $authorizedExtensions = ['jpg', 'png', 'gif', 'webp'];
                $maxFileSize = 2097152;

                $file = $picture['name'] . uniqid('', false) . "." . $extension;
                $files[] = $file;
                $uploadFile = $uploadDir . $file;

                if (!in_array($extension, $authorizedExtensions)) {
                    $errors[] = "Veuillez sélectionner une image de type jpg, png, gif ou webp";
                }
                if (file_exists($picture['tmp_name']) && filesize($picture['tmp_name']) > $maxFileSize) {
                    $errors[] = "Votre fichier doit faire moins de 2MO !";
                }
                if (empty($errors)) {
                    move_uploaded_file($picture['tmp_name'], $uploadFile);
                }
            }
            echo '<pre>';
            var_dump($files);
            echo '</pre>';

            $pictureManager = new PictureManager();
            $pictureManager->insert($files, $id);
        }
    }
}
