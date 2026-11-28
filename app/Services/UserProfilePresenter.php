<?php

namespace App\Services;

use App\Models\User;

class UserProfilePresenter
{
    /**
     * Build the UI profile payload from the authenticated User model.
     *
     * @return array<string, mixed>
     */
    public static function forUser(?User $user): array
    {
        if (! $user) {
            return [
                'owner_name' => 'Pengguna BeliPas',
                'business_name' => 'Usaha Kuliner UMKM',
                'business_type' => 'Usaha Kuliner UMKM',
                'contact' => '-',
                'registered_at_label' => '-',
                'avatar_initials' => 'BP',
                'is_authenticated' => false,
            ];
        }

        $businessName = trim((string) ($user->getAttribute('business_name') ?? '')) ?: $user->name;
        $contact = trim((string) ($user->getAttribute('phone') ?? '')) ?: $user->email;

        return [
            'owner_name' => $user->name,
            'business_name' => $businessName,
            'business_type' => $user->isAdmin() ? 'Administrator' : 'Usaha Kuliner UMKM',
            'contact' => $contact,
            'email' => $user->email,
            'registered_at_label' => $user->created_at?->translatedFormat('d M Y') ?? '-',
            'avatar_initials' => self::initials($businessName),
            'is_authenticated' => true,
        ];
    }

    private static function initials(string $name): string
    {
        $words = preg_split('/\s+/', trim($name)) ?: [];
        $initials = '';

        foreach (array_slice($words, 0, 2) as $word) {
            if ($word !== '') {
                $initials .= mb_strtoupper(mb_substr($word, 0, 1));
            }
        }

        return $initials !== '' ? $initials : 'BP';
    }
}
