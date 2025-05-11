<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NoteList extends Model
{
    public function getAll() {
        $noteLists = DB::table('note_lists')
        ->join('users', 'users.id_user', '=', 'note_lists.id_user')
        ->get();
        return $noteLists;
    }
}
