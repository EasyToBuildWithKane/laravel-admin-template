<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminPasswordRequest;
use App\Http\Requests\Admin\AdminProfileRequest;
use App\Models\User;
use App\Services\AdminProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class AdminController extends Controller
{
    protected AdminProfileService $profileService;

    public function __construct(AdminProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Logout admin user.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have successfully logged out.');
    }

    /**
     * Show admin profile form.
     */
    public function showProfile()
    {
        $data = Auth::user();
        return view('admin.profile.admin_profile', compact('data'));
    }

    /**
     * Update admin profile.
     */
    public function updateProfile(AdminProfileRequest $request)
    {
        try {
            $user = $this->profileService->updateProfile(
                Auth::user(),
                $request->only(['name', 'first_name', 'last_name', 'phone', 'link_social']),
                $request->file('photo'),
                $request->boolean('remove_current_photo')
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully.',
                'data' => [
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'link_social' => $user->link_social,
                    'photo_url' => $user->photo ? asset('uploads/admin_images/' . $user->photo) : asset('uploads/no_image.jpg'),
                ]
            ]);


        } catch (Throwable $e) {
            Log::error('Profile update failed in controller', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Profile update failed. Please try again.'
            ], 500);
        }
    }

    public function removePhoto(Request $request)
    {
        $user = Auth::user();

        if (!$user || empty($user->photo)) {
            return response()->json([
                'status' => 'error',
                'message' => 'No photo to remove.'
            ], 400);
        }

        try {
            $this->profileService->updateProfile($user, [], null, true);

            return response()->json([
                'status' => 'success',
                'message' => 'Avatar has been removed.',
                'photo' => asset('uploads/no_image.jpg')
            ]);

        } catch (Throwable $e) {
            Log::error('Remove avatar failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove avatar.'
            ], 500);
        }
    }

    /**
     * Show change password form.
     */
    public function showChangePassword()
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        return view('admin.profile.change_pass', compact('data'));
    }

    /**
     * Update admin password.
     */
    public function updatePassword(AdminPasswordRequest $request)
    {
        $user = User::find(Auth::id());

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mật khẩu cũ điền không đúng.'
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status' => 'success',
            'message' => 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại!'
        ]);
    }


}
