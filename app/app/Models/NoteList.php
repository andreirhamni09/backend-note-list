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
        ->paginate(6);
        return $noteLists;
    }
# -- Get Note List by id user

# -- Get Note List by id note list
    public function GetByIdNoteList($id_user, $id_note_lists) {
        $noteLists = DB::table('note_lists')
        ->where('id_note_lists', '=', $id_note_lists)
        ->where('id_user', '=', $id_user)
        ->where('deleted_at', '=', null)
        ->first();
        return $noteLists;
    }
# -- Get Note List by id note list

# -- Add Note List
    public function AddNoteList($id_user,$title_note_lists,$deskripsi_note_lists,$created_at){        
        $id     =   DB::table('note_lists')->insertGetId([
            'id_user'                   => $id_user,
            'title_note_lists'          => $title_note_lists,        
            'deskripsi_note_lists'      => $deskripsi_note_lists,            
            'created_at'                => $created_at    
        ]);

        $note_list  = DB::table('note_lists')->where("id_note_lists", '=', $id)->first();
        return $note_list;
    } 
# -- Add Note List

# -- Update Note List
    public function UpdateNoteList($id_note_lists, $id_user, $title_note_lists,$deskripsi_note_lists,$updated_at){
        DB::table('note_lists')
        ->where('id_note_lists', '=', $id_note_lists)
        ->update([
            'title_note_lists'          => $title_note_lists,        
            'deskripsi_note_lists'      => $deskripsi_note_lists,            
            'updated_at'                => $updated_at    
        ]);
    } 
# -- Update Note List

# -- Delete Note List
    public function DeleteNoteList($id_user, $id_note_lists, $deleted_at){
        DB::table('note_lists')
        ->where('id_note_lists', '=', $id_note_lists)
        ->where('id_user', '=', $id_user)
        ->update([
            'deleted_at' => $deleted_at
        ]);
    } 
# -- Delete Note List
}
