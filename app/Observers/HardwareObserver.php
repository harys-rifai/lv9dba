<?php

namespace App\Observers;

use App\Models\Hardware;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
class HardwareObserver
{
    /**
     * Triggered when a Hardware record is updated.
     */
    public function updated(Hardware $hardware): void
    {
        $this->sendUpdateNotification($hardware);
    }
    /**
     * Send notification to all users when Hardware is updated.
     */
    protected function sendUpdateNotification(Hardware $hardware): void
    {
        $before = $hardware->getOriginal(); // Data sebelum update
        $after = $hardware->getChanges();   // Data yang berubah
        $updatedBy = Auth::user()?->name ?? 'System';
        // Ambil status sebelum dan sesudah dengan fallback
        $statusBefore = $before['status'] ?? '(unknown)';
        $statusAfter = $after['status'] ?? $hardware->status;
        User::chunk(100, function ($users) use ($hardware, $statusBefore, $statusAfter, $updatedBy) {
            foreach ($users as $user) {
                Notification::make()
                    ->title('🛠️ Update: ' . $hardware->model)
                    ->body(
                        "Device {$hardware->make} - {$hardware->model}successfully updated by:{$updatedBy}.\n" .
                        "Host: {$hardware->serial}\n" .
                        "Status: {$statusBefore} → {$statusAfter}"
                    )
                    ->success()
                    ->persistent()
                    ->sendToDatabase($user);
            }
        });
    }
}
