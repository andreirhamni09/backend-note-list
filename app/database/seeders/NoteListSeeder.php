<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class NoteListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $id_user = [1, 2];
        for ($i=0; $i < count($id_user); $i++) {
            $id_user_val                = $id_user[$i];

            for ($j=1; $j <= 50 ; $j++) { 
                $title_note_lists       = "TITLE ".$j. " ".$id_user_val;
                $deskripsi_note_lists   = "DESKRIPSI ".$j." ".$id_user_val;
                $created_at             = Carbon::now();
                DB::table('note_lists')->insert([
                    'id_user'                   => $id_user_val,
                    'title_note_lists'          => $title_note_lists,        
                    'deskripsi_note_lists'      => $deskripsi_note_lists,            
                    'created_at'                => $created_at    
                ]);
            }
        }
    }
}
