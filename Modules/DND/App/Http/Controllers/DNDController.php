<?php

namespace Modules\DND\App\Http\Controllers;

use App\DataTables\DndListDataTable;
use App\Http\Controllers\Controller;
use App\Models\UserRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DNDController extends Controller
{

    public function index(DndListDataTable $dataTable, $type)
    {
        return $dataTable->with('type', $type)->render('dnd::index');
    }

    public function processCSV(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        // Get mobile numbers from CSV
        $file = $request->file('csv_file');
        $mobileNumbers = [];

        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
            $header = fgetcsv($handle);
            $mobileColumnIndex = array_search('mobile', array_map('strtolower', $header));

            if ($mobileColumnIndex === false) {
                return response()->json(['error' => 'Mobile number column not found'], 400);
            }

            while (($row = fgetcsv($handle)) !== false) {
                if (isset($row[$mobileColumnIndex])) {
                    $mobileNumbers[] = trim($row[$mobileColumnIndex]);
                }
            }
            fclose($handle);
        }

        // Update records
        $updatedCount = DB::table('user_registrations')
            ->whereIn('mobile', $mobileNumbers)
            ->update(['isDnd' => 1]); // Change 'status' to your column name

        return response()->json([
            'message' => "$updatedCount records updated successfully!",
            'updated_count' => $updatedCount
        ]);
    }

    public function destroy(Request $request){
        try {
            //code...
            $inputs = $request->all();
            $rec = UserRegistration::where('id',$inputs['id'])->first();
            if($rec){
                $updRec = UserRegistration::where('id', $inputs['id'])->update(['isDnd'=>0]);
                if($updRec){
                    return response()->json(['type'=>'SUCCESS','message'=>'Record removed from DND successfully!']);        
                } else {
                    return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong while removing the record.']);    
                }
            } else {
                return response()->json(['type'=>'ERROR','message'=>'Record not found to remove from DND.']);    
            }
        } catch (\Exception $e) {
            //throw $th;
            Log::info($e->getMessage());
            return response()->json(['type'=>'ERROR','message'=>'Oops! Something went wrong.']);
        }
    }
}
