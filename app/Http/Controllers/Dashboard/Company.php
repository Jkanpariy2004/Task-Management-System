<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company As dbcompany;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class Company extends Controller
{
    public function index(){
        if (!Session::has('email')) {
            return redirect('/admin')->with('error', 'Please login to access this page.');
        }
        
        return view('Dashboard.Company');
    }

    public function FetchCompany()
    {
        $companys = dbcompany::all();
        
        return response()->json([
            'companys' => $companys,
        ]);
    }
    
    public function AddCompany()
    {
        if (!Session::has('email')) {
            return redirect('/admin')->with('error', 'Please login to access this page.');
        }
        
        return view('Dashboard.Add-Company');
    }

    public function SubmitCompany(Request $request){
        $message = [
            'c_name.required' => 'Please Enter Company Name.',
            'c_email.required' => 'Please Enter Company Name.,',
            'c_mobile.required' => 'Please Enter Company Name.',
            'c_address.required' => 'Please Enter Company Address.',
            'city.required' => 'Please Enter Company Name.',
            'country.required' => 'Please Select Country.',
        ];

        $validator = Validator::make($request->all(), [
            'c_name' => 'required',
            'c_email' => 'required|email',
            'c_mobile' => 'required|digits:10',
            'c_address' => 'required',
            'city' => 'required',
            'country' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $company = new dbcompany();
        $company->c_name = $request->input('c_name');
        $company->c_email = $request->input('c_email');
        $company->c_phone_no = $request->input('c_mobile');
        $company->c_address = $request->input('c_address');
        $company->city = $request->input('city');
        $company->country = $request->input('country');

        $company->save();

        return response()->json(['message' => 'Company created successfully!'], 200);
    }

    public function edit($id)
    {
        if (!Session::has('email')) {
            return redirect('/admin')->with('error', 'Please login to access this page.');
        }
        
        $show = dbcompany::all();
        $new = dbcompany::find($id);
        $url = url('/company-update/' . $id);
        $com = compact('show', 'new', 'url');
        return view('Dashboard.Company_edit', $com);
    }

    public function CompanyUpdate(Request $request , $id){
        $message = [
            'c_name.required' => 'Please Enter Company Name.',
            'c_email.required' => 'Please Enter Company Name.,',
            'c_mobile.required' => 'Please Enter Company Name.',
            'c_address.required' => 'Please Enter Company Address.',
            'city.required' => 'Please Enter Company Name.',
            'country.required' => 'Please Select Country.',
        ];

        $validator = Validator::make($request->all(), [
            'c_name' => 'required',
            'c_email' => 'required|email',
            'c_mobile' => 'required|digits:10',
            'c_address' => 'required',
            'city' => 'required',
            'country' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $company = dbcompany::find($id);
        $company->c_name = $request->input('c_name');
        $company->c_email = $request->input('c_email');
        $company->c_phone_no = $request->input('c_mobile');
        $company->c_address = $request->input('c_address');
        $company->city = $request->input('city');
        $company->country = $request->input('country');

        $company->save();

        return response()->json(['message' => 'Company Updated successfully!'], 200);
    }

    public function CompanyDelete($id)
    {
        $company = dbcompany::find($id);
        if ($company) {
            $company->delete();
            return response()->json(['status' => 'success', 'message' => 'Company deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Company not found.'], 404);
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!is_array($ids)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid IDs'], 400);
        }
        $ids = array_filter($ids, 'is_numeric');
        dbcompany::destroy($ids);
        return response()->json(['status' => 'success', 'message' => 'Companys deleted successfully']);
    }
}
