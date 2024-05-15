<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    public function getComment($id)
    {
        $document = Document::find($id);
        if($document)
        {
            $comment = $document->comments;
            return response()->json($comment);
        } else {
            return response()->json([
                'message'=>'المستند غير موجود'
            ],404);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $document = Document::all();
        return response()->json([
            'status'=>'success',
            'document'=>$document
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DocumentRequest $request)
    {
        // try {
            DB::beginTransaction();
                $validateData = $request-> validated();
                $validateData['user_id']= auth()->id();

            $document = Document::create($validateData);
            //     'title'=> $request->title,
            //     'description'=> $request->description
            // ]);
            DB::commit();
            return response()->json([
                'status'=>'success',
                'document'=> $document
            ], 201);
        // }
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     Log::error($th);
        //      return response()->json([
        //         'status'=>'error'
        //      ], 500);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return response()->json([
            'status'=>'success',
            'document'=>$document,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DocumentRequest $request, Document $document)
    {
        try {
            DB::beginTransaction();
              $newDoc = [];
              if(isset($request->title))
              {
                $newDoc['title'] = $request->title ;
              }
              if(isset($request->description))
              {
                $newDoc['description'] = $request->description ;
              }
              $document->update($newDoc);
            DB::commit();
            return response()->json([
                'status'=>'success',
                'document'=> $document
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
             return response()->json([
                'status'=>'error'
             ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        $document->delete();
        return response()->json([
            'status'=>'success'
        ]);
    }
    public function upload(Request $request)
    {
        $document = $request->file('document');
        $documentName = time().'.'. $document->getClientOriginalExtension();
        $document-> move(public_path('documents'), $documentName);
        return response()->json([
            'message'=>'success'
        ],200);
    }
}
