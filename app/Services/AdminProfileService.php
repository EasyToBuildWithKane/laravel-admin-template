<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class AdminProfileService
{
    /**
     * Update user profile with extended fields.
     */
    public function updateProfile(
        User $user,
        array $data,
        ?UploadedFile $photo = null,
        bool $removeCurrentPhoto = false
    ): User {
        DB::beginTransaction();

        try {
            $user->name       = $data['name'] ?? $user->name;
            $user->first_name = $data['first_name'] ?? $user->first_name;
            $user->last_name  = $data['last_name'] ?? $user->last_name;
            $user->phone      = $data['phone'] ?? $user->phone;
            $user->link_social = $data['link_social'] ?? $user->link_social;

            // Handle photo
            if ($removeCurrentPhoto) {
                $this->deletePhoto($user);
                $user->photo = null;
            }

            if ($photo && $photo->isValid()) {
                $this->deletePhoto($user);
                $user->photo = $this->uploadPhoto($photo);
            }

            $user->save();
            DB::commit();

            return $user;
        } catch (Throwable $e) {
            DB::rollback();
            Log::error('Admin profile update failed', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    private function uploadPhoto(UploadedFile $file): string
    {
        $filename = now()->format('YmdHis') . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/admin_images'), $filename);
        return $filename;
    }

    private function deletePhoto(User $user): void
    {
        if (!empty($user->photo)) {
            $path = public_path('uploads/admin_images/' . $user->photo);
            if (file_exists($path)) {
                @unlink($path);
            }
        }
    }
}
