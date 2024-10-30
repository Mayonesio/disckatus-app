<?php

namespace App\Services;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Log;
use Exception;

class FirebaseStorageService
{
    private $storage;
    private $bucket;

    public function __construct()
    {
        try {
            $this->storage = new StorageClient([
                'keyFilePath' => storage_path('app/firebase/credentials.json'),
                'projectId' => config('firebase.project_id')
            ]);
            $this->bucket = $this->storage->bucket(config('firebase.storage.bucket'));
        } catch (Exception $e) {
            Log::error('Firebase Storage initialization error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function uploadAvatar($file, $userId)
    {
        try {
            // Crear nombre único para el archivo
            $extension = $file->getClientOriginalExtension();
            $fileName = 'avatars/' . $userId . '/' . uniqid() . '.' . $extension;

            // Configurar opciones de upload
            $options = [
                'name' => $fileName,
                'predefinedAcl' => 'publicRead',
                'metadata' => [
                    'contentType' => $file->getMimeType(),
                    'metadata' => [
                        'firebaseStorageDownloadTokens' => uniqid(),
                    ]
                ]
            ];

            // Subir el archivo
            $object = $this->bucket->upload(
                file_get_contents($file->getRealPath()),
                $options
            );

            Log::info('Avatar uploaded successfully', ['path' => $fileName]);

            // Retornar la URL pública
            return $this->getPublicUrl($object->name());
        } catch (Exception $e) {
            Log::error('Error uploading avatar to Firebase', [
                'error' => $e->getMessage(),
                'userId' => $userId
            ]);
            throw $e;
        }
    }

    public function deleteAvatar($url)
    {
        try {
            $fileName = $this->getFileNameFromUrl($url);
            if (!$fileName) {
                return false;
            }

            $object = $this->bucket->object($fileName);
            if ($object->exists()) {
                $object->delete();
                Log::info('Avatar deleted successfully', ['path' => $fileName]);
                return true;
            }
            return false;
        } catch (Exception $e) {
            Log::error('Error deleting avatar from Firebase', [
                'error' => $e->getMessage(),
                'url' => $url
            ]);
            return false;
        }
    }

    private function getPublicUrl($fileName)
    {
        return 'https://storage.googleapis.com/' . $this->bucket->name() . '/' . $fileName;
    }

    private function getFileNameFromUrl($url)
    {
        $pattern = "/storage\.googleapis\.com\/" . $this->bucket->name() . "\/(.+)/";
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
}