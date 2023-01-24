<?php

namespace App\Http\Controllers\Sapapps\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

####### Include
use Auth;
use DB;
use General;
use Image;
use Agent;
use Mail;

class ajaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        ### Request
        //General::print_r_($request->all());exit;
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        } 

        $return = [
            'status' => 'fail', //fail, success
            'text'   => ''
        ];

        ### sort, active, time
        try {    
            $data = [];

            $data = [
                $colunm => $val
            ];

            // ### เฉพาะ date_range
            // if(stristr($colunm,'_date_start')) { //Ex: banner_slide_date_start => _date_start
            //         ### Convert
            //     //Ex: 2019/03/20 - 2019/03/21
            //     $ex = explode('-',$val);

            //     $data[$colunm] = str_replace('/','-',trim(@$ex[0])); //2019/03/20 => 2019-03-20
            //     $data[stristr($colunm,'_date_start',1).'_date_end'] = str_replace('/','-',trim(@$ex[1])); //2019/03/21 => 2019-03-21
            // }
    
            $columns = DB::getSchemaBuilder()->getColumnListing($table);
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {
                    
                    ### At, Ref
                    if(stristr($name,'_updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                    ### Set Null
                    if(stristr($name,'_created_at')) {
                        unset($data[$name]);
                    }
                }
            }

            DB::table($table)->where($where,$id)->update($data);
            \App\Model\Log\log_backend_login::log('ajax/update-'.$table.'/ID: '.$id);
            DB::commit();
            $return['status'] = 'success';
            $return['text']   = 'Update Complete!';
        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log('ajax/update-'.$table.'/ID:'.$id.'/Error:'.substr($e->getMessage(),0,180) );
            // throw $e;ajax
            //echo $e->getMessage();
            // return abort(404);
            $return['status'] = 'fail';
            $return['text']   = 'ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code;        
        }  

        return json_encode($return);
      
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
