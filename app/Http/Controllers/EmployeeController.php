<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resultArr = Employee::all();
        return view('employee_list', compact('resultArr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add_edit_employee');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputDataArr = $request->validate([
            'emp_name' => 'required|max:100'
        ]);
        $inputDataArr['emp_status'] = 0;
        $empStatus = $request->get('emp_status');
        if($empStatus == 'on') {
            $inputDataArr['emp_status'] = 1;
        }
        $result = Employee::create($inputDataArr);
        return redirect('/employee')->with('success', 'Employee successfully saved');
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
        $resultArr = Employee::findOrFail($id);
        return view('add_edit_employee', compact('resultArr'));
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
        $updateArr = $request->validate([
            'emp_name' => 'required|max:100',
        ]);
        $updateArr['emp_status'] = 0;
        $empStatus = $request->get('emp_status');
        if($empStatus == 'on') {
            $updateArr['emp_status'] = 1;
        }
        Employee::whereId($id)->update($updateArr);
        return redirect('/employee')->with('success', 'ID - '.$id.' successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->get('id');
        $resultArr = ['ack'=>'error', 'msg'=>'Something went wrong!'];
        $res = Employee::destroy($id);
        if(!empty($res)) {
            $resultArr = ['ack'=>'ok', 'msg'=>'Record deleted successfully'];
        }
        echo json_encode($resultArr);exit;
    }
}
