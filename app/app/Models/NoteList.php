<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NoteList extends Model
{
    public function getAll() {
        $noteLists = DB::table('note-lists')->get();
        return $noteLists;
    }
}
