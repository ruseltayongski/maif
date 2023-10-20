<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fundsource;
use App\Models\Facility;
use App\Models\Proponent;
use App\Models\ProponentInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FundSourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fundSource(Request $request) {
        $fundsources = Fundsource::              
                        with([
                            'proponents' => function ($query) {
                                $query->with([
                                    'proponentInfo' => function ($query) {
                                        $query->with('facility');
                                    }
                                ]);
                            },
                            'encoded_by' => function ($query) {
                                $query->select(
                                    'id',
                                    'name'
                                );
                            }
                        ]);

        if($request->viewAll) {
            $request->keyword = '';
        }
        else if($request->keyword) {
            $fundsources = $fundsources->where('saa', 'LIKE', "%$request->keyword%");
        } 
        
        $fundsources = $fundsources
                        ->orderBy('id','desc')
                        ->paginate(15);
                        
        
        return view('fundsource.fundsource',[
            'fundsources' => $fundsources,
            'keyword' => $request->keyword
        ]);
    }

    public function createFundSource() {
        $user = Auth::user();
        $fundsources = Fundsource::get();
        return view('fundsource.create_fundsource',[
            'facilities' => Facility::where('hospital_type','private')->get(),
            'user' => $user,
            'fundsources' => $fundsources
        ]);
    }

    public function createFundSourceSave(Request $request) {
        $user = Auth::user();
        //return $request->all();
        if(isset($request->saa_exist)) {
            $fundsource = Fundsource::find($request->saa_exist);
        } else {
            $fundsource = new Fundsource();
            $fundsource->saa = $request->saa;
            $fundsource->created_by = $user->id;
            $fundsource->save();
        }

        $proponent = new Proponent();
        $proponent->fundsource_id = $fundsource->id;
        $proponent->proponent = $request->proponent;
        $proponent->proponent_code = $request->proponent_code;
        $proponent->created_by = $user->id;
        $proponent->save();

        $index = 0;
        foreach ($request->facility_id as $facilityId) {
            $proponentInfo = new ProponentInfo();
            $proponentInfo->fundsource_id = $fundsource->id;
            $proponentInfo->proponent_id = $proponent->id;
            $proponentInfo->facility_id = $request->facility_id[$index];
            $proponentInfo->alocated_funds = $request->alocated_funds[$index];
            $proponentInfo->created_by = $user->id;
            $proponentInfo->save();
            $index++;
        }

        //return $request->all();
        // $data = $request->all();
        // Fundsource::create($request->all());
        // $fundsource = new Fundsource();
        // $fundsource->saa = $request->saa;
        // $fundsource->created_by = $request->created_by;
        // $fundsource->save();

        // $saaInfo = new SaaInfo();
        // $saaInfo->saaId_unique = $fundsouce->id;
        // $saaInfo->saaId = $fundsource->saa_exist;
        
        // $saaInfo->proponent = $saaInfo->proponent;
        // $saaInfo->code_proponent = $saaInfo->code_proponent;
        // $saaInfo->facility_id = $saaInfo->facility_id;
        // $saaInfo->alocated_funds = $saaInfo->alocated_funds;
        // $saaInfo->save();

        session()->flash('fundsource_save', true);
        return redirect()->back();
    }

    public function proponentGet(Request $request) {
        return Proponent::where('fundsource_id',$request->fundsource_id)->get();
    }

    public function facilityProponentGet(Request $request) {
        return ProponentInfo::where('proponent_id',$request->proponent_id)->with([
            'facility' => function ($query) {
                $query->select(
                    'id',
                    DB::raw('name as description')
                );
            }
        ])
        ->get();
    }

    public function getAcronym($str) {
        $words = explode(' ', $str); // Split the string into words
        $acronym = '';
        
        foreach ($words as $word) {
            $acronym .= strtoupper(substr($word, 0, 1)); // Take the first letter of each word and convert to uppercase
        }
        
        return $acronym;
    }

    public function forPatientCode(Request $request) {
        $user = Auth::user();
        $proponent = Proponent::find($request->proponent_id);
        $facility = Facility::find($request->facility_id);
        $patient_code = $proponent->proponent_code.'-'.$this->getAcronym($facility->name).date('YmdHi').$user->id;
        return $patient_code;
    }

    public function transactionGet() {
        $randomBytes = random_bytes(16); // 16 bytes (128 bits) for a reasonably long random code
        $uniqueCode = bin2hex($randomBytes);
        $facilities = Facility::where('hospital_type','private')->get();
        return view('fundsource.transaction',[
            'facilities' => $facilities,
            'uniqueCode' => $uniqueCode
        ]);
    }

}
