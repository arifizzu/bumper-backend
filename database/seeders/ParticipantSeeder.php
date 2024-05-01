<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Participant;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Participant::create([
        //     'type' => "role",
        //     'activity_id' => 1,
        // ]);

        // Participant::create([
        //     'type' => "user",
        //     'activity_id' => 2,
        // ]);

        $roleParticipant = Participant::create([
            'type' => 'user',
            'activity_id' => 1,
        ]);
        $roleParticipant->users()->attach(2);

        $userParticipant = Participant::create([
            'type' => 'role',
            'activity_id' => 2,
        ]);
        $userParticipant->roles()->attach(2);
    }
}
