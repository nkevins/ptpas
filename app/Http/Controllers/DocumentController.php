<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Document;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::all();
        return view('admin/document/index', compact('documents'));
    }
    
    public function download($hash)
    {
        $document = Document::where('hash', $hash)->first();
        
        if ($document == null) {
            abort(404);
        }
        
        return Storage::download($document->file_path, $document->file_name);
    }
    
    public function create()
    {
        return view('admin/document/create');
    }
    
    public function save(Request $request)
    {
        $file = $request->file('file');
        
        // File Details
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();
        
        // Check if file already exist
        $existingDoc = Document::where('file_name', $filename)->get();
        if (count($existingDoc) != 0) {
            flash()->error('Document with same file name already exist')->important();
            return redirect()->back()->withInput();
        }
        
        // Store file into disk
        $path = $request->file('file')->store('documents');
        
        $doc = new Document;
        $doc->name = $request->input('name');
        $doc->file_name = $filename;
        $doc->file_path = $path;
        if (trim($request->input('revision')) == '')
            $doc->revision = '';
        else
            $doc->revision = $request->input('revision');
        $doc->hash = md5_file($tempPath);
        if (trim($request->input('remarks')) == '')
            $doc->remarks = '';
        else
            $doc->remarks = $request->input('remarks');
        $doc->save();
        
        flash()->success('Document Added')->important();
        return redirect()->action('DocumentController@index');
    }
    
    public function edit($id)
    {
        $document = Document::find($id);
        
        if ($document == null) {
            abort(404);
        }
        
        return view('admin/document/edit', compact('document'));
    }
    
    public function update(Request $request, $id)
    {
        $doc = Document::find($id);
        
        if ($doc == null) {
            abort(404);
        }
        
        $file = $request->file('file');
        
        // File Details
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();
        
        // Delete current file
        Storage::delete($doc->file_path);
        
        // Store file into disk
        $path = $request->file('file')->store('documents');
        
        $doc->name = $request->input('name');
        $doc->file_name = $filename;
        $doc->file_path = $path;
        if (trim($request->input('revision')) == '')
            $doc->revision = '';
        else
            $doc->revision = $request->input('revision');
        $doc->hash = md5_file($tempPath);
        if (trim($request->input('remarks')) == '')
            $doc->remarks = '';
        else
            $doc->remarks = $request->input('remarks');
        $doc->save();
        
        flash()->success('Document Updated')->important();
        return redirect()->action('DocumentController@index');
    }
    
    public function delete(Request $request)
    {
        $document = Document::find($request->input('documentId'));
        
        if ($document == null) {
            abort(404);
        }
        
        $filePath = $document->file_path;
        
        $document->delete();
        
        Storage::delete($filePath);
        
        flash()->success('Document Deleted')->important();
        return redirect()->action('DocumentController@index');
    }
}
