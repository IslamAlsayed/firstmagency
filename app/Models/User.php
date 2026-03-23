<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, SoftDeletes, HasRoles, Notifiable, HasRichText;
    protected $richTextAttributes = [
        'bio',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'address',
        'bio',
        'mobile',
        'phone',
        'photo',
        'role',
        'last_login_ip',
        'last_login_at',
        'password_changed_at',
        'button_display_mode',
        'status',
        'is_active',
        'created_by',
        'updated_by',
        'website_locale',
        'dashboard_locale',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'password_changed_at' => 'datetime',
        ];
    }

    /**
     * ✨ Helper Methods للتحقق من الأدوار والصلاحيات
     */

    /**
     * هل المستخدم Super Admin؟
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    /**
     * هل المستخدم Admin؟
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * هل المستخدم Content Manager؟
     */
    public function isContentManager(): bool
    {
        return $this->role === 'content_manager';
    }

    /**
     * هل يمكنه الوصول للـ Dashboard؟
     */
    public function canAccessDashboard(): bool
    {
        return in_array($this->role, ['superadmin', 'admin', 'content_manager']);
    }

    /**
     * هل يمكنه الوصول للإعدادات (Colors/Fonts)؟
     */
    public function canManageSettings(): bool
    {
        return in_array($this->role, ['superadmin', 'admin']);
    }

    /**
     * هل يمكنه تغيير الـ Sections (Padding)؟
     */
    public function canManageSections(): bool
    {
        return in_array($this->role, ['superadmin', 'admin']);
    }

    /**
     * هل يمكنه إدارة المحتوى؟
     */
    public function canManageContent(): bool
    {
        return in_array($this->role, ['superadmin', 'admin', 'content_manager']);
    }

    /**
     * هل يمكنه عرض جميع المراجعات Revisions؟
     */
    public function canViewAllRevisions(): bool
    {
        return in_array($this->role, ['superadmin', 'admin']);
    }

    /**
     * هل يمكنه الـ Rollback؟
     */
    public function canRollback(): bool
    {
        return in_array($this->role, ['superadmin', 'admin']);
    }

    /**
     * هل يمكنه إدارة المستخدمين؟
     */
    public function canManageUsers(): bool
    {
        return in_array($this->role, ['superadmin', 'admin']);
    }

    /**
     * الحصول على اسم الدور بالعربية
     */
    public function getRoleNameArabic(): string
    {
        return match ($this->role) {
            'superadmin' => 'المسؤول الأعلى',
            'admin' => 'المسؤول',
            'content_manager' => 'مدير المحتوى',
            'support' => 'الدعم الفني',
            default => 'غير معروف'
        };
    }

    /**
     * الحصول على اسم الدور بالإنجليزية
     */
    public function getRoleNameEnglish(): string
    {
        return match ($this->role) {
            'superadmin' => 'Super Admin',
            'admin' => 'Admin',
            'content_manager' => 'Content Manager',
            'support' => 'Support',
            default => 'Unknown'
        };
    }

    /**
     * الحصول على لغة الموقع
     */
    public function getWebsiteLocale(): string
    {
        return $this->website_locale ?? config('app.locale', 'ar');
    }

    /**
     * الحصول على لغة الداشبورد
     */
    public function getDashboardLocale(): string
    {
        return $this->dashboard_locale ?? config('app.locale', 'ar');
    }

    /**
     * Get the department for this support user
     */
    public function department()
    {
        return $this->hasOne(Department::class, 'user_id');
    }

    /**
     * Get the sidebar preferences for this user
     */
    public function sidebarPreference()
    {
        return $this->hasOne(UserSidebarPreference::class);
    }
}
