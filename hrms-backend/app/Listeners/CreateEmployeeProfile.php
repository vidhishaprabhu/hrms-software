<?php

namespace App\Listeners;

use App\Models\Employee;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateEmployeeProfile
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Registered $event): void
    {
        // Get the newly registered user from the event
        $user = $event->user;

        // Ensure the user has a name before attempting to create an employee record.
        if (empty($user->name)) {
            Log::warning('User registration attempted without a name. Skipping employee creation.');
            return;
        }

        try {
            // Try to find an existing employee with the same email address
            $employee = Employee::where('email', $user->email)->first();

            // Check if an existing employee was found
            if ($employee) {
                // If an employee exists, link the new user account to it
                $employee->user_id = $user->id;
                $employee->save();
                Log::info('Existing employee record updated with new user_id: ' . $user->id);
            } else {
                // If no employee exists, create a new record
                // Generate a simple employee_id based on the user's ID.
                $employeeId = 'EMP' . str_pad($user->id, 4, '0', STR_PAD_LEFT);

                Employee::create([
                    'user_id' => $user->id,
                    'employee_id' => $employeeId,
                    'first_name' => $user->name,
                    'last_name' => '',
                    'email' => $user->email,
                    // Add other default employee fields here
                ]);
                Log::info('New employee record created for user_id: ' . $user->id);
            }
        } catch (\Exception $e) {
            // Log any errors that occur during the database operation
            Log::error('Failed to create/update employee for user_id ' . $user->id . '. Error: ' . $e->getMessage());
        }
    }
}
