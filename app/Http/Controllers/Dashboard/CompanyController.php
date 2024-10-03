<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Company as dbcompany;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\Snappy\Facades\SnappyPdf;

class CompanyController extends Controller
{
    public function index()
    {
        return view('Dashboard.Company.Company');
    }

    public function FetchCompany()
    {
        $companys = dbcompany::get();

        return response()->json([
            'companys' => $companys,
        ]);
    }

    public function AddCompany()
    {
        return view('Dashboard.Company.Add-Company');
    }

    public function SubmitCompany(Request $request)
    {
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
        $show = dbcompany::all();
        $new = dbcompany::find($id);
        $url = url('/company-update/' . $id);
        $com = compact('show', 'new', 'url');
        return view('Dashboard.Company.Company_edit', $com);
    }

    public function CompanyUpdate(Request $request, $id)
    {
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

    public function exportPDF()
    {
        ini_set('memory_limit', '20480M');
        ini_set('max_execution_time', 1000);

        $pdf = new Dompdf();
        $allHtml = '';

        dbcompany::chunk(500, function ($companies) use (&$allHtml) {
            $html = view('Dashboard.Company.pdf', compact('companies'))->render();
            $allHtml .= $html;
        });

        $pdf->loadHtml($allHtml);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        return $pdf->stream('companies.pdf');
    }

    public function importCSV(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $file = $request->file('csv_file');

        try {
            if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
                fgetcsv($handle);

                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    dbcompany::create([
                        'id' => $data[0],
                        'c_name' => $data[1],
                        'c_email' => $data[2],
                        'c_phone_no' => $data[3],
                        'c_address' => $data[4],
                        'city' => $data[5],
                        'country' => $data[6],
                    ]);
                }
                fclose($handle);
            }

            return response()->json(['success' => 'Data imported successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while importing the CSV file' . $e->getMessage()], 500);
        }
    }
}
