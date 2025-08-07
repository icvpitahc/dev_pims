<?php

namespace App\Http\Livewire\Pages\Css\Results;
use Illuminate\Support\Facades\DB;
use App\Models\CssResponse;
use NumberToWords\NumberToWords;

use Livewire\Component;

class CssResults extends Component
{
    public $firstLargestClientTypeName;
    public $firstLargestClientTypeCount;
    public $secondLargestClientTypeName;
    public $secondLargestClientTypeCount;
    public $thirdLargestClientTypeName;
    public $thirdLargestClientTypeCount;

    public $firstLargestTransactingOfficeName;
    public $firstLargestTransactingOfficeCount;
    public $secondLargestTransactingOfficeName;
    public $secondLargestTransactingOfficeCount;
    public $thirdLargestTransactingOfficeName;
    public $thirdLargestTransactingOfficeCount;
    
    public $firstLowestTransactingOfficeName;
    public $firstLowestTransactingOfficeCount;
    public $secondLowestTransactingOfficeName;
    public $secondLowestTransactingOfficeCount;
    public $thirdLowestTransactingOfficeName;
    public $thirdLowestTransactingOfficeCount;
    public $PITAHCOverallRating;
    public $param;
    public $transacting_office_id;
    public $year;
    public $report_type_id;
    
    public function mount($param)
    {
        $this->year = $param;
        $client_type = DB::table('v_css_responses_detailed')->select('client_type_name', DB::raw('count(*) as `count`'))->whereYear('date_transacted', $this->year)->groupBy('client_type_id')->orderBy('count', 'DESC')->take(3)->get();
        $transacting_office_desc = DB::table('v_css_responses_detailed')->select('transacting_office_name', DB::raw('count(*) as `count`'))->whereYear('date_transacted', $this->year)->groupBy('transacting_office_id')->orderBy('count', 'DESC')->take(3)->get();
        $transacting_office_asc = DB::table('v_css_responses_detailed')->select('transacting_office_name', DB::raw('count(*) as `count`'))->whereYear('date_transacted', $this->year)->groupBy('transacting_office_id')->orderBy('count', 'ASC')->take(3)->get();
        $pitahc_overall_rating = DB::table('v_average')->select(DB::raw('DISTINCT ROUND(overall_rating, 2) AS `overall_rating`'))->where('year_transacted', $this->year)->get();

        $this->firstLargestClientTypeName = $client_type[0]->client_type_name;
        $this->firstLargestClientTypeCount = $client_type[0]->count;
        $this->secondLargestClientTypeName = $client_type[1]->client_type_name;
        $this->secondLargestClientTypeCount = $client_type[1]->count;
        $this->thirdLargestClientTypeName = $client_type[2]->client_type_name;
        $this->thirdLargestClientTypeCount = $client_type[2]->count;

        $this->firstLargestTransactingOfficeName = $transacting_office_desc[0]->transacting_office_name;
        $this->firstLargestTransactingOfficeCount = $transacting_office_desc[0]->count;
        $this->secondLargestTransactingOfficeName = $transacting_office_desc[1]->transacting_office_name;
        $this->secondLargestTransactingOfficeCount = $transacting_office_desc[1]->count;
        $this->thirdLargestTransactingOfficeName = $transacting_office_desc[2]->transacting_office_name;
        $this->thirdLargestTransactingOfficeCount = $transacting_office_desc[2]->count;

        $this->firstLowestTransactingOfficeName = $transacting_office_asc[0]->transacting_office_name;
        $this->firstLowestTransactingOfficeCount = $transacting_office_asc[0]->count;
        $this->secondLowestTransactingOfficeName = $transacting_office_asc[1]->transacting_office_name;
        $this->secondLowestTransactingOfficeCount = $transacting_office_asc[1]->count;
        $this->thirdLowestTransactingOfficeName = $transacting_office_asc[2]->transacting_office_name;
        $this->thirdLowestTransactingOfficeCount = $transacting_office_asc[2]->count;
        
        $this->PITAHCOverallRating = $pitahc_overall_rating[0]->overall_rating;
    }


    public function convertNumberToWords($number)
    {
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en'); // Choose the desired locale
        $words = $numberTransformer->toWords($number);
        return $words;
    }
    


    public function render()
    {
        return view('livewire.pages.css.results.css-results', [
            'sex_types' => DB::table('v_css_responses_detailed')->select('sex_type_name', DB::raw('count(*) as `count`'))->whereYear('date_transacted', $this->year)->groupBy('sex_type_id')->orderBy('sex_type_id', 'ASC')->get(),
            'client_groups' => DB::table('v_css_responses_detailed')->select('client_group_name', DB::raw('count(*) as `count`'))->whereYear('date_transacted', $this->year)->groupBy('client_group_id')->orderBy('client_group_id', 'ASC')->get(),
            'client_types' => DB::table('v_css_responses_detailed')->select('client_type_name', DB::raw('count(*) as `count`'))->whereYear('date_transacted', $this->year)->groupBy('client_type_id')->orderBy('client_type_id', 'ASC')->get(),
            'regions' => DB::table('v_css_responses_detailed')->select('region_name', DB::raw('count(*) as `count`'))->whereYear('date_transacted', $this->year)->groupBy('region_id')->orderBy('region_id', 'ASC')->get(),
            'awareness_responses' => DB::table('v_css_responses_detailed')->select('awareness_response_name', DB::raw('count(*) as `count`'))->whereYear('date_transacted', $this->year)->groupBy('awareness_response_id')->orderBy('awareness_response_id', 'ASC')->get(),
            'visibility_responses' => DB::table('v_css_responses_detailed')->select('visibility_response_name', DB::raw('count(*) as `count`'))->whereYear('date_transacted', $this->year)->groupBy('visibility_response_id')->orderBy('visibility_response_id', 'ASC')->get(),
            'helpfulness_responses' => DB::table('v_css_responses_detailed')->select('helpfulness_response_name', DB::raw('count(*) as `count`'))->whereYear('date_transacted', $this->year)->groupBy('helpfulness_response_id')->orderBy('helpfulness_response_id', 'ASC')->get(),
            'availed_services' => DB::table('v_css_responses_detailed')->select('availed_service_name_short', DB::raw('count(*) as `count`'))->whereYear('date_transacted', $this->year)->groupBy('availed_service_id')->orderBy('availed_service_id', 'ASC')->get(),
            'transacting_offices' => DB::table('v_css_responses_detailed')->select('transacting_office_name', DB::raw('count(*) as `count`'))->whereYear('date_transacted', $this->year)->groupBy('transacting_office_id')->orderBy('transacting_office_id', 'ASC')->get(),
            'services' => DB::table('v_ratings')->select('criteria', 'year_transacted', DB::raw('SUM(total_responses) `total_responses`'), DB::raw('SUM(rating_6) AS `raw_6`'), DB::raw('SUM(rating_6)/SUM(total_responses)*100 AS `rating_6`'), DB::raw('SUM(rating_5) AS `raw_5`'), DB::raw('SUM(rating_5)/SUM(total_responses)*100 AS `rating_5`'), DB::raw('SUM(rating_4) AS `raw_4`'), DB::raw('SUM(rating_4)/SUM(total_responses)*100 AS `rating_4`'), DB::raw('SUM(rating_3) AS `raw_3`'), DB::raw('SUM(rating_3)/SUM(total_responses)*100 AS `rating_3`'), DB::raw('SUM(rating_2) AS `raw_2`'), DB::raw('SUM(rating_2)/SUM(total_responses)*100 AS `rating_2`'), DB::raw('SUM(rating_1) AS `raw_1`'), DB::raw('SUM(rating_1)/SUM(total_responses)*100 AS `rating_1`'))->where('year_transacted', $this->year)->groupBy('criteria', 'year_transacted')->get(),
            'averages' => DB::table('v_average')->select('criteria', 'year_transacted', DB::raw('ROUND(average_rating, 2) AS `average_rating`'), DB::raw('ROUND(overall_rating, 2) AS `overall_rating`'))->where('year_transacted', $this->year)->get(),
            'total_css_responses' => CssResponse::whereYear('date_transacted', $this->year)->where('status_type_id', 1)->count(),
            'total_male_css_responses' => CssResponse::whereYear('date_transacted', $this->year)->where('status_type_id', 1)->where('sex_type_id', '1')->count(),
            'total_female_css_responses' => CssResponse::whereYear('date_transacted', $this->year)->where('status_type_id', 1)->where('sex_type_id', '2')->count(),
        ]);
    }
}
