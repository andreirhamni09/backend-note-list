<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NoteList extends Model
{

# -- Get Note List by id user
    public function GetAll($id_user) {
        $noteLists = DB::table('note_lists')
        ->where('id_user', '=', $id_user)
        ->where('deleted_at', '=', null)
        ->get();
        return $noteLists;
    }
# -- Get Note List by id user

# -- Get Note List by id note list
    public function GetByIdNoteList($id_user, $id_note_lists) {
        $noteLists = DB::table('note_lists')
        ->where('id_note_lists', '=', $id_note_lists)
        ->where('id_user', '=', $id_user)
        ->where('deleted_at', '=', null)
        ->get();
        return $noteLists;
    }
# -- Get Note List by id note list

# -- Add Note List
    public function AddNoteList($id_user,$title_note_lists,$deskripsi_note_lists,$created_at){
        DB::table('note_lists')->insert([
            'id_user'                   => $id_user,
            'title_note_lists'          => $title_note_lists,        
            'deskripsi_note_lists'      => $deskripsi_note_lists,            
            'created_at'                => $created_at    
        ]);
    } 
# -- Add Note List

# -- Update Note List
    public function UpdateNoteList($id_note_lists, $id_user, $title_note_lists,$deskripsi_note_lists,$updated_at){
        DB::table('note_lists')
        ->where('id_note_lists', '=', $id_note_lists)
        ->update([
            'id_user'                   => $id_user,
            'title_note_lists'          => $title_note_lists,        
            'deskripsi_note_lists'      => $deskripsi_note_lists,            
            'updated_at'                => $updated_at    
        ]);
    } 
# -- Update Note List
}
