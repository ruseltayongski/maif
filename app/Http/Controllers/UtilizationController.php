<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilization;
use App\Models\Proponent;
use App\Models\Fundsource;
use App\Models\User;
use App\Models\Dv;
use App\Models\Dv3;
use PDF;

class UtilizationController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function tracking($info_id){
        $utilization = Utilization::where('proponentinfo_id', $info_id)
            ->with(['user', 'proponentdata', 'fundSourcedata', 'facilitydata',
            'transfer' => function($query){
                $query->with([
                    'from_fundsource:id,saa',
                    'to_fundsource:id,saa',
                    'from_proponentInfo:id,proponent',
                    'to_proponentInfo:id,proponent'
                ]);
            }
            ])->get(); 
        return response()->json($utilization);
    }
   
    public function trackingBudget($fundsourceId, $type){

        // $utilization = Utilization::whereNotNull('obligated')->where('fundsource_id', $fundsourceId)
        //     ->with('proponentdata', 'fundSourcedata', 'facilitydata', 'user_budget')->orderBy('id', 'desc')->get();
        $utilization = Utilization::whereNotNull('obligated')
            ->where('fundsource_id', $fundsourceId)
            ->with('proponentdata', 'fundSourcedata', 'facilitydata', 'user_budget')
            ->orderByRaw("CAST(REPLACE(budget_bbalance, ',', '') AS DECIMAL(15,2)) DESC")
            ->get();

        if($type == 'for_modal'){
            return $utilization;
        }else if ($type == 'pdf'){
            $pdf = PDF::loadView('fundsource_budget.budget_pdf', $data=['utilization'=>$utilization->sortBy('id')]);
            $pdf->setPaper('A4');
            return $pdf->stream('fundsource_budget.budget_pdf');
        }
    }

    public function getDv($route_no){
        $dv = Dv::where('route_no', $route_no)->first();
        $dv3 = Dv3::where('route_no', $route_no)->first();
        if($dv){
            return redirect()->route('dv', ['keyword' => $route_no]);
        }else if($dv3){
            return redirect()->route('dv3', ['keyword' => $route_no]);
        }else{
            return redirect()->route('pre_dv2', ['keyword' => $route_no]);
        }
    }
}
