<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;
use App\Methodtype;
use App\Merchantrule;
use App\Settlementrule;


class MerchantrulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::select("
                                SELECT
                                    *
                                FROM
                                    users
                                WHERE
                                    deleted = '0'
                                AND id NOT IN (
                                    SELECT DISTINCT
                                        (users.id)
                                    FROM
                                        users
                                    INNER JOIN merchantrules ON merchantrules.user_id = users.id
                                    WHERE
                                        merchantrules.deleted = '0'
                                )
                            ");

        $availed_users = User::with('Merchantrule')
            ->select('users.name','users.id')
            ->distinct('users.id')
            ->join('merchantrules', 'merchantrules.user_id', '=', 'users.id')
            ->where(['merchantrules.deleted' => '0'])
            ->get();


        $methodtypes = Methodtype::all();
        $merchantrules = Merchantrule::where(['deleted' => '0']);
        return view('layouts.pages.merchantrule',compact('methodtypes','merchantrules','users','availed_users'))->with(['controller'=>$this]);
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
        $input = $request->all();

        $rows = $input['rows'];

        for ($i = 0; $i < count($rows); $i++) {

            $rules[] = [
                            'deleted' => '0',
                            'rule_id' => $rows[$i]['rule_id'],
                            'user_id' => $input['user_id'],
                            'created_at' => date('Y-m-d h:i:s'),
                            'updated_at' => date('Y-m-d h:i:s')
                    ];
        }


        $create = DB::table('merchantrules')->insert($rules);

        if ($create) {
            notify()->flash('Done', 'success', [
                'timer' => 3000,
                'text' => 'Rule Assigned',
            ]);
        } else {
            notify()->flash('Error', 'error', [
                'timer' => 3000,
                'text' => 'Something Went Wrong',
            ]);
        }

        return redirect()->route('merchantrules.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $merchantrule = DB::select("
                                SELECT
                                    merchantrules.id AS merchantrule_id,
                                    users.id AS user_id,
                                    users.`name` AS user_name,
                                    settlementrules.id AS rule_id,
                                    settlementrules.`name` AS rule_name
                                FROM
                                    merchantrules
                                INNER JOIN users ON users.id = merchantrules.user_id
                                INNER JOIN settlementrules ON merchantrules.rule_id = settlementrules.id
                                WHERE
                                    users.id = '$id'
                                AND merchantrules.deleted = '0'
                            ");

        $mersetrules = array();

        foreach ($merchantrule as $key => $val) {
            array_push($mersetrules,$val->rule_id);
        }


        $methodtypes = Methodtype::all();

        $editOps = "";

        foreach ($methodtypes as $key => $value) {

            $settlementrules = Settlementrule::where(['methodtype_id' => $value->id])->get();

            $setruleOps = "";

            foreach ($settlementrules as $k => $v) {
                $setruleOps .= "<option value='{$v->id}' ".(in_array($v->id, $mersetrules) == true ? 'selected':'').">{$v->name}</option>";    
            }

            $editOps .= "
                <div class='form-group'>
                  <label>".$value->name."</label>
                  <select class='form-control' name='rule_id[]'>
                    $setruleOps
                  </select>
                </div>
            ";    
        }

        $form = "
            <div class='modal-body'>
                <form method='POST' id='editForm' action='".route('merchantrules.update',$id)."'>
                ".csrf_field()."
                  <input type='hidden' name='_method' value='PUT'>

                  <div class='form-group'>
                    <h4>Merchant: ".$merchantrule[0]->user_name."</h4>
                    <input type='hidden' name='user_id' class='form-control' value='{$id}'>
                  </div>

                  $editOps

                  <button class='btn btn-block btn-success btn-sm' id='submitEdit' type='submit'>SAVE</button>
                  <button class='btn btn-block btn-success btn-sm' id='loadingEdit' style='display: none' disabled=''>Working...</button>
                </form>
            </div>
        ";

        return $form;
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
        DB::beginTransaction();

        try {

            DB::select("
                    DELETE FROM merchantrules WHERE user_id = '$id'
                ");

            foreach ($request->rule_id as $key => $value) {
                Merchantrule::create(
                    [
                        'user_id' => $id,
                        'rule_id' => $value,
                        'deleted' => '0',
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                    ]
                );
            }

            DB::commit();

            return response()->json(['success'=>'Rules updated.']);       

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error'=>'Rules cannot be updated.']);     
        }
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
