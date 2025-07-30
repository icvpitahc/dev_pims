<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function print(Document $document)
    {
        $document->load(['document_type', 'document_sub_type', 'division', 'logs.fromDivision', 'logs.toDivision', 'logs.userCreated']);
        return view('documents.print', compact('document'));
    }
}
