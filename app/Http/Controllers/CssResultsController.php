<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CssResultsController extends Controller
{
    public function respondents_sex($year)
    {
        $result = DB::table('v_css_responses_detailed')
            ->select(
                'sex_type_name',
                DB::raw('count(*) as `count`')
            )
        ->whereYear('date_transacted', $year)
        ->groupBy('sex_type_id')
        ->orderBy('sex_type_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_sex'=>$result], 200);
    }

    public function respondents_sex_filter($year, $report_type_id)
    {
        if($report_type_id==2){
            $start_date = $year.'-01-01';
            $end_date = $year.'-06-30';
        }else{
            $start_date = $year.'-01-01';
            $end_date = $year.'-12-31';
        }
        
        $result = DB::table('v_css_responses_detailed')
            ->select(
                'sex_type_name',
                DB::raw('count(*) as `count`')
            )
        ->whereBetween('date_transacted', [$start_date, $end_date])
        ->whereYear('date_transacted', $year)
        ->groupBy('sex_type_id')
        ->orderBy('sex_type_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_sex_filter'=>$result], 200);
    }

    public function respondents_client_group($year)
    {
        $result = DB::table('v_css_responses_detailed')
        ->select(
            'client_group_name',
            DB::raw('count(*) as `count`')
            )
            ->whereYear('date_transacted', $year)
        ->groupBy('client_group_id')
        ->orderBy('client_group_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_client_group'=>$result], 200);
    }

    public function respondents_client_group_filter($year, $report_type_id)
    {
        if($report_type_id==2){
            $start_date = $year.'-01-01';
            $end_date = $year.'-06-30';
        }else{
            $start_date = $year.'-01-01';
            $end_date = $year.'-12-31';
        }
        $result = DB::table('v_css_responses_detailed')
        ->select(
            'client_group_name',
            DB::raw('count(*) as `count`')
            )
            ->whereBetween('date_transacted', [$start_date, $end_date])
            ->whereYear('date_transacted', $year)
        ->groupBy('client_group_id')
        ->orderBy('client_group_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_client_group_filter'=>$result], 200);
    }

    public function respondents_client_type($year)
    {
        $result = DB::table('v_css_responses_detailed')
        ->select(
            'client_type_name',
            DB::raw('count(*) as `count`')
            )
            ->whereYear('date_transacted', $year)
        ->groupBy('client_type_id')
        ->orderBy('client_type_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_client_type'=>$result], 200);
    }

    public function respondents_client_type_filter($year, $report_type_id)
    {
        if($report_type_id==2){
            $start_date = $year.'-01-01';
            $end_date = $year.'-06-30';
        }else{
            $start_date = $year.'-01-01';
            $end_date = $year.'-12-31';
        }
        $result = DB::table('v_css_responses_detailed')
        ->select(
            'client_type_name',
            DB::raw('count(*) as `count`')
            )
            ->whereBetween('date_transacted', [$start_date, $end_date])
            ->whereYear('date_transacted', $year)
        ->groupBy('client_type_id')
        ->orderBy('client_type_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_client_type_filter'=>$result], 200);
    }

    public function respondents_region($year)
    {
        $result = DB::table('v_css_responses_detailed')
        ->select(
            'region_name',
            DB::raw('count(*) as `count`')
            )
            ->whereYear('date_transacted', $year)
        ->groupBy('region_id')
        ->orderBy('region_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_region'=>$result], 200);
    }

    public function respondents_region_filter($year, $report_type_id)
    {
        if($report_type_id==2){
            $start_date = $year.'-01-01';
            $end_date = $year.'-06-30';
        }else{
            $start_date = $year.'-01-01';
            $end_date = $year.'-12-31';
        }
        $result = DB::table('v_css_responses_detailed')
        ->select(
            'region_name',
            DB::raw('count(*) as `count`')
            )
            ->whereBetween('date_transacted', [$start_date, $end_date])
            ->whereYear('date_transacted', $year)
        ->groupBy('region_id')
        ->orderBy('region_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_region_filter'=>$result], 200);
    }

    public function respondents_awareness_response($year)
    {
        $result = DB::table('v_css_responses_detailed')
        ->select(
            'awareness_response_name',
            DB::raw('count(*) as `count`')
            )
            ->whereYear('date_transacted', $year)
        ->groupBy('awareness_response_id')
        ->orderBy('awareness_response_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_awareness_response'=>$result], 200);
    }

    public function respondents_awareness_response_filter($year, $report_type_id)
    {
        if($report_type_id==2){
            $start_date = $year.'-01-01';
            $end_date = $year.'-06-30';
        }else{
            $start_date = $year.'-01-01';
            $end_date = $year.'-12-31';
        }
        $result = DB::table('v_css_responses_detailed')
        ->select(
            'awareness_response_name',
            DB::raw('count(*) as `count`')
            )
            ->whereBetween('date_transacted', [$start_date, $end_date])
            ->whereYear('date_transacted', $year)
        ->groupBy('awareness_response_id')
        ->orderBy('awareness_response_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_awareness_response_filter'=>$result], 200);
    }

    public function respondents_visibility_response($year)
    {
        $result = DB::table('v_css_responses_detailed')
        ->select(
            'visibility_response_name',
            DB::raw('count(*) as `count`')
            )
            ->whereYear('date_transacted', $year)
        ->groupBy('visibility_response_id')
        ->orderBy('visibility_response_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_visibility_response'=>$result], 200);
    }

    public function respondents_visibility_response_filter($year, $report_type_id)
    {
        if($report_type_id==2){
            $start_date = $year.'-01-01';
            $end_date = $year.'-06-30';
        }else{
            $start_date = $year.'-01-01';
            $end_date = $year.'-12-31';
        }
        $result = DB::table('v_css_responses_detailed')
        ->select(
            'visibility_response_name',
            DB::raw('count(*) as `count`')
            )
            ->whereBetween('date_transacted', [$start_date, $end_date])
            ->whereYear('date_transacted', $year)
        ->groupBy('visibility_response_id')
        ->orderBy('visibility_response_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_visibility_response_filter'=>$result], 200);
    }

    public function respondents_helpfulness_response($year)
    {
        $result = DB::table('v_css_responses_detailed')
        ->select(
            'helpfulness_response_name',
            DB::raw('count(*) as `count`')
            )
            ->whereYear('date_transacted', $year)
        ->groupBy('helpfulness_response_id')
        ->orderBy('helpfulness_response_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_helpfulness_response'=>$result], 200);
    }

    public function respondents_helpfulness_response_filter($year, $report_type_id)
    {
        if($report_type_id==2){
            $start_date = $year.'-01-01';
            $end_date = $year.'-06-30';
        }else{
            $start_date = $year.'-01-01';
            $end_date = $year.'-12-31';
        }
        $result = DB::table('v_css_responses_detailed')
        ->select(
            'helpfulness_response_name',
            DB::raw('count(*) as `count`')
            )
            ->whereBetween('date_transacted', [$start_date, $end_date])
            ->whereYear('date_transacted', $year)
        ->groupBy('helpfulness_response_id')
        ->orderBy('helpfulness_response_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_helpfulness_response_filter'=>$result], 200);
    }

    public function respondents_availed_service($year)
    {
        $result = DB::table('v_css_responses_detailed')
        ->select(
            'availed_service_name_short',
            DB::raw('count(*) as `count`')
            )
            ->whereYear('date_transacted', $year)
        ->groupBy('availed_service_id')
        ->orderBy('availed_service_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_availed_service'=>$result], 200);
    }

    public function respondents_availed_service_filter($year, $report_type_id)
    {
        if($report_type_id==2){
            $start_date = $year.'-01-01';
            $end_date = $year.'-06-30';
        }else{
            $start_date = $year.'-01-01';
            $end_date = $year.'-12-31';
        }
        $result = DB::table('v_css_responses_detailed')
        ->select(
            'availed_service_name_short',
            DB::raw('count(*) as `count`')
            )
            ->whereBetween('date_transacted', [$start_date, $end_date])
            ->whereYear('date_transacted', $year)
        ->groupBy('availed_service_id')
        ->orderBy('availed_service_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_availed_service_filter'=>$result], 200);
    }

    public function respondents_transacting_office($year)
    {
        $result = DB::table('v_css_responses_detailed')
        ->select(
            'transacting_office_name',
            DB::raw('count(*) as `count`')
            )
        ->whereYear('date_transacted', $year)
        ->groupBy('transacting_office_id')
        ->orderBy('transacting_office_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_transacting_office'=>$result], 200);
    }

    public function respondents_transacting_office_filter($year, $report_type_id)
    {
        if($report_type_id==2){
            $start_date = $year.'-01-01';
            $end_date = $year.'-06-30';
        }else{
            $start_date = $year.'-01-01';
            $end_date = $year.'-12-31';
        }
        $result = DB::table('v_css_responses_detailed')
        ->select(
            'transacting_office_name',
            DB::raw('count(*) as `count`')
            )
            ->whereBetween('date_transacted', [$start_date, $end_date])
            ->whereYear('date_transacted', $year)
        ->groupBy('transacting_office_id')
        ->orderBy('transacting_office_id', 'ASC')
        ->get();
        
        return response()->json(['respondents_transacting_office_filter'=>$result], 200);
    }

    public function ratings($year)
    {
        $result = DB::table('v_ratings')
        ->select(
            'criteria',
            'year_transacted',
            DB::raw('ROUND(SUM(rating_6)/SUM(total_responses)*100, 2) AS `rating_6`'),
            DB::raw('ROUND(SUM(rating_5)/SUM(total_responses)*100, 2) AS `rating_5`'),
            DB::raw('ROUND(SUM(rating_4)/SUM(total_responses)*100, 2) AS `rating_4`'),
            DB::raw('ROUND(SUM(rating_3)/SUM(total_responses)*100, 2) AS `rating_3`'),
            DB::raw('ROUND(SUM(rating_2)/SUM(total_responses)*100, 2) AS `rating_2`'),
            DB::raw('ROUND(SUM(rating_1)/SUM(total_responses)*100, 2) AS `rating_1`')
            )
        ->where('year_transacted', $year)
        ->groupBy('criteria', 'year_transacted')
        ->get();
        
        return response()->json(['ratings'=>$result], 200);
    }

    public function average($year)
    {

        $result = DB::table('v_average')
        ->select(
            'criteria',
            'year_transacted',
            DB::raw('ROUND(average_rating, 2) AS `average_rating`'),
            DB::raw('ROUND(overall_rating, 2) AS `overall_rating`')
            )
        ->where('year_transacted', $year)
        ->get();
        
        return response()->json(['average'=>$result], 200);
    }
}
