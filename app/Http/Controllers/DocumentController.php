<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DocumentController extends Controller
{
    public function print(Document $document)
    {
        $document->load(['document_type', 'document_sub_type', 'division', 'logs.fromDivision', 'logs.toDivision', 'logs.userCreated', 'logs.userReceived', 'logs.userForwarded']);
        return view('documents.print', compact('document'));
    }

    public function publicShow($tracking_number)
    {
        try {
            $decrypted_tracking_number = Crypt::decryptString($tracking_number);
            $document = Document::where('document_reference_code', $decrypted_tracking_number)->firstOrFail();
            $document->load(['document_type', 'document_sub_type', 'division', 'logs.fromDivision', 'logs.toDivision', 'logs.userCreated', 'logs.userReceived', 'logs.userForwarded']);
            return view('documents.public-show', compact('document'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404);
        }
    }
}
