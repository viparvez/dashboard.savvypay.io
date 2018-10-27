<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Merchantdocument;
use Illuminate\Support\Facades\DB;
use Validator;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $docdetails = Merchantdocument::where(['deleted' => '0', 'user_id' => Auth::user()->id])->get();

        if (count($docdetails) > 0) {            
            
            $docsArr = array(
                            'Certificate of Incorporation',
                            'Trade License',
                            'TIN',
                            'NID or Passport' 
                        );

            $availableDocs = array();

            foreach ($docdetails as $key => $value) {
                array_push($availableDocs, $value->fileType);
            }


            foreach ($docsArr as $key => $value) {
                if (!in_array($value, $availableDocs)) {
                    $file = $value;
                } else {
                    $file = 'false';
                }
            }
            
        } else {
            $file =  "Certificate of Incorporation";
        }

        return view('layouts.pages.documents', compact('file'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'fileType' => 'required|Regex:/^[\D]+$/i|max:255',
            "file" => "required|mimes:pdf|max:6000"
        ]);


        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        DB::beginTransaction();

        try {

            $file = $request->file('file');
            $fileName = $request->fileType."-".time()."-".Auth::user()->id.'.'.$file->getClientOriginalExtension();
            $file->move('public/uploads/documents', $fileName);
            
            DB::table('merchantdocuments')->insert(
                [
                    'fileType' => $request->fileType,
                    'fileName' => $fileName,
                    'user_id' => Auth::user()->id,
                    'createdbyuser_id' => Auth::user()->id,
                    'updatedbyuser_id' => Auth::user()->id,
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]
            );
            DB::commit();

            return redirect()->route('documents.index');

        } catch (Exception $e) {
            DB::rollback();
          return response()->json(['error'=>array('Could not upload')]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
