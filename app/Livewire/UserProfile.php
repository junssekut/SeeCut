<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ProfileImage;

class UserProfile extends Component
{
    use WithFileUploads;

    public $first_name;
    public $last_name;
    public $email;
    public $gender;
    public $birth_date;
    public $photo;
    public $current_photo;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'gender' => 'nullable|in:male,female',
        'birth_date' => 'nullable|date',
        'photo' => 'nullable|image|max:2048', // 2MB max
    ];

    protected $messages = [
        'first_name.required' => 'Nama depan wajib diisi.',
        'last_name.required' => 'Nama belakang wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan.',
        'photo.image' => 'File harus berupa gambar.',
        'photo.max' => 'Ukuran foto maksimal 2MB.',
    ];

    public function mount()
    {
        $user = Auth::user();
        $profile = $user->profile;

        // Create profile if it doesn't exist
        if (!$profile) {
            $profile = $user->profile()->create();
        }

        $this->first_name = $profile->first_name ?? '';
        $this->last_name = $profile->last_name ?? '';
        $this->email = $user->email;
        $this->gender = $profile->gender;
        $this->birth_date = $profile->birth_date;
        
        // Get current profile image
        if ($profile->image) {
            $this->current_photo = $profile->image->type === 'local' 
                ? Storage::url($profile->image->source)
                : $profile->image->source;
        }
    }

    public function updatedEmail()
    {
        $this->validateOnly('email', [
            'email' => 'required|email|unique:users,email,' . Auth::id()
        ]);
    }

    public function save()
    {
        // Update email validation to exclude current user
        $this->rules['email'] = 'required|email|unique:users,email,' . Auth::id();
        
        $this->validate();

        $user = Auth::user();
        $profile = $user->profile;

        // Update user email
        $user->update(['email' => $this->email]);

        // Handle photo upload
        if ($this->photo) {
            // Delete old photo if exists
            if ($profile->image && $profile->image->type === 'local') {
                Storage::delete($profile->image->source);
                $profile->image->delete();
            }

            // Store new photo
            $photoPath = $this->photo->store('profile-photos', 'public');
            
            $profileImage = ProfileImage::create([
                'type' => 'local',
                'source' => $photoPath
            ]);

            $profile->update(['image_id' => $profileImage->id]);
            
            $this->current_photo = Storage::url($photoPath);
            $this->photo = null;
        }

        // Update profile
        $profile->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
        ]);

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => 'Profil berhasil diperbarui!'
        ]);
    }

    public function getInitials()
    {
        if ($this->first_name || $this->last_name) {
            return strtoupper(substr($this->first_name ?? '', 0, 1) . substr($this->last_name ?? '', 0, 1));
        }
        return strtoupper(substr(Auth::user()->email, 0, 2));
    }

    public function render()
    {
        return view('livewire.profile')->layout('layouts.app');
    }
}

