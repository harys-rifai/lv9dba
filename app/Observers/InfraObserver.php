<?php

namespace App\Observers;

use App\Models\Infra;
use App\Models\User;
use Filament\Notifications\Notification;

class InfraObserver
{
    /**
     * Triggered when an Infra record is updated.
     */
    public function updated(Infra $infra): void
    {
        $this->sendUpdateNotification($infra);
    }

    /**
     * Send notification to all users when Infra is updated.
     */
    protected function sendUpdateNotification(Infra $infra): void
    {
        $users = User::all(); // Kirim ke semua user

        foreach ($users as $user) {
            Notification::make()
                ->title('📡 Update Data Infra: ' . $infra->Hostname)
                ->body("Data {$infra->Hostname} updated.\nIP: {$infra->IP_Address}\nManaged by: {$infra->Managedby}")
                ->success()
                ->persistent()
                ->sendToDatabase($user);
        }
    }
}
