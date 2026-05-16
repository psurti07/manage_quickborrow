<?php

namespace Modules\ContactEnquiry\App\Http\Controllers;

use App\DataTables\ContactEnquiryDataTable;
use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactEnquiryController extends Controller
{
    public function index(ContactEnquiryDataTable $dataTable)
    {
        return $dataTable->render('contactenquiry::index');
    }

    public function destroy(Request $request){
        $input = $request->all();
        $result = ContactEnquiry::find($input['id'])->delete();
        if ($result) {
            $message = 'Contact enquiry remove successfully!';
            return response()->json(array('type' => 'SUCCESS', 'message' => $message, 'data' => []));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Oops! Something went wrong.', 'data' => []));
        }
    }

}
