<?php

namespace App\Observers;

use App\Models\Uatmetric;
use App\Models\User;
use Filament\Notifications\Notification;

class UatmetricObserver
{
    /**
     * Triggered when a new Uatmetric is created.
     */
    public function created(Uatmetric $uatmetric): void
    {
        $this->sendAlertIfNeeded($uatmetric, 'Data baru Uatmetric ditambahkan');
    }

    /**
     * Triggered when a Uatmetric is updated.
     */
    public function updated(Uatmetric $uatmetric): void
    {
        $this->sendAlertIfNeeded($uatmetric, 'Data Uatmetric diperbarui');
    }

    /**
     * Shared logic to send alert notification to all users.
     */
    protected function sendAlertIfNeeded(Uatmetric $uatmetric, string $context): void
    {
        if (
            $uatmetric->CPU > 90 ||
            $uatmetric->Memory > 90 ||
            $uatmetric->DiskDataAvg > 90 ||
            $uatmetric->LongQueryCount > 100
        ) {
            $users = User::all(); // Kirim ke semua user

            foreach ($users as $user) {
                Notification::make()
                    ->title('🚨 Alert Kritis: ' . $uatmetric->Hostname)
                    ->body("{$context}:\nCPU: {$uatmetric->CPU}%, Memory: {$uatmetric->Memory}%, Disk: {$uatmetric->DiskDataAvg}%, LongQuery: {$uatmetric->LongQueryCount}")
                    ->danger()
                    ->persistent()
                    ->sendToDatabase($user);
            }
        }
    }
}
