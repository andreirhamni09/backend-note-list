<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\NoteList\NoteListRepositoryInterface;

class NoteListController extends Controller
{
    protected $noteListRepositoryInterface;

    public function __construct(NoteListRepositoryInterface $noteListRepositoryInterface)
    {
        $this->noteListRepositoryInterface = $noteListRepositoryInterface;        
    }
    
    public function index()
    {
        return response()->json($this->noteListRepositoryInterface->GetAll());
    }
}
