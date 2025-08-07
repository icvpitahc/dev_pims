<div>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
  
<div>    
    <div>
        <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1 class="m-0 text-dark"><span class="text-primary">Client Satisfaction Measurement Results</span><br>Philippine Institute of Traditional and Alternative Health Care</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                      <li class="breadcrumb-item"><a href="{{ route('module-selector') }}">Module</a></li>
                      <li class="breadcrumb-item active">Client Satisfaction Measurement</li>
                      </ol>
                  </div>
              </div>
          </div>
          <div class="row">
          </div>
        </div>
        <div class="content" wire:ignore>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-filter mr-2"></i>Filters</h3> 
                            </div>
                            <div class="card-body" style="display: none">
                                <label class="my-1 mr-2">Year</label>
                                <select class="custom-select my-1 mr-sm-2" id="year" wire:model="year">
                                    <option selected>Please select</option>
                                    @php
                                    $currentYear = date("Y");
                                    @endphp
                                    @for ($year = $currentYear; $year >= 2021; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                                <label class="my-1 mr-2">Report Type</label>
                                <select class="custom-select my-1 mr-sm-2" id="report_type_id" wire:model="report_type_id">
                                    <option selected>Please select</option>
                                    <option value="1">Mid-year</option>
                                    <option value="2">Year-end</option>
                                </select>
                                <br><br>
                                <button class="btn btn-primary float-right" onclick="generateChart()"><i class="fas fa-cog mr-2"></i>Generate</button>
                                <button class="btn btn-success float-right mr-2"><i class="fas fa-sync-alt mr-2"></i>Reset</button>
                            </div>
                            <div class="card-body">
                              <label class="my-1 mr-2">Year</label>
                              <a href="{{ route('css-results', ['param' => 2025]) }}" class="btn {{ $param==2025 ? 'btn-success' : 'btn-secondary' }} btn-lg btn-block">2025</a>
                              <a href="{{ route('css-results', ['param' => 2024]) }}" class="btn {{ $param==2024 ? 'btn-success' : 'btn-secondary' }} btn-lg btn-block">2024</a>
                              <a href="{{ route('css-results', ['param' => 2023]) }}" class="btn {{ $param==2023 ? 'btn-success' : 'btn-secondary' }} btn-lg btn-block">2023</a>
                              <a href="{{ route('css-results', ['param' => 2022]) }}" class="btn {{ $param==2022 ? 'btn-success' : 'btn-secondary' }} btn-lg btn-block">2022</a>
                              <hr>
                              <label class="my-1 mr-2">Central Office</label>
                              <a href="{{ route('css-results', ['param' => 2025]) }}" class="btn btn-success btn-lg btn-block">PITAHC Overall</a>                  
                              <a href="{{ route('css-results-transacting-office', ['param1' => 2025, 'param2' => 0]) }}" class="btn btn-secondary btn-lg btn-block">PITAHC Central Office Only</a>
                              <hr>
                              <label class="my-1 mr-2">Divisions and Department</label>
                              <a href="{{ route('css-results-transacting-office', ['param1' => 2025, 'param2' => 1]) }}" class="btn btn-secondary btn-lg btn-block">Research and Development Division</a>
                              <a href="{{ route('css-results-transacting-office', ['param1' => 2025, 'param2' => 2]) }}" class="btn btn-secondary btn-lg btn-block">Standards and Accreditation Division</a>
                              <a href="{{ route('css-results-transacting-office', ['param1' => 2025, 'param2' => 3]) }}" class="btn btn-secondary btn-lg btn-block">Social Advocacy and Training Division</a>
                              <a href="{{ route('css-results-transacting-office', ['param1' => 2025, 'param2' => 4]) }}" class="btn btn-secondary btn-lg btn-block">Finance Division</a>
                              <a href="{{ route('css-results-transacting-office', ['param1' => 2025, 'param2' => 5]) }}" class="btn btn-secondary btn-lg btn-block">Management Services Division</a>
                              <a href="{{ route('css-results-transacting-office', ['param1' => 2025, 'param2' => 6]) }}" class="btn btn-secondary btn-lg btn-block">Administrative Division</a>
                              <a href="{{ route('css-results-transacting-office', ['param1' => 2025, 'param2' => 10]) }}" class="btn btn-secondary btn-lg btn-block">Bids and Awards Committee</a>
                              <a href="{{ route('css-results-transacting-office', ['param1' => 2025, 'param2' => 11]) }}" class="btn btn-secondary btn-lg btn-block">Office of the Director General</a>
                              <a href="{{ route('css-results-transacting-office', ['param1' => 2025, 'param2' => 12]) }}" class="btn btn-secondary btn-lg btn-block">Business Development Department</a>
                              <hr>
                              <label class="my-1 mr-2">Herbal Processing Plants</label>
                              <a href="{{ route('css-results-transacting-office', ['param1' => 2025, 'param2' => 7]) }}" class="btn btn-secondary btn-lg btn-block">Cagayan Valley Herbal Processing Plants</a>
                              <a href="{{ route('css-results-transacting-office', ['param1' => 2025, 'param2' => 8]) }}" class="btn btn-secondary btn-lg btn-block">Tacloban Herbal Processing Plants</a>
                              <a href="{{ route('css-results-transacting-office', ['param1' => 2025, 'param2' => 9]) }}" class="btn btn-secondary btn-lg btn-block">Davao Herbal Processing Plants</a>
                          </div>

                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                  
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-chart-line mr-2"></i>Dashboard</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                              <h2 style="text-align:center">CY {{ $param }}</h2>
                                                <h3>Respondent’s Demographic</h3>
                                            </div>
                                            <div class="col-lg-6">
                                                <p class="indent">
                                                    A total of {{ App\Http\Livewire\Pages\Css\Results\CssResults::convertNumberToWords($total_css_responses)  }} ({{$total_css_responses}}) respondents served by PITAHC from January to {{ $param == date("Y") ? date("M") : "December" }} {{ $param }} have submitted accomplished PITAHC CSS forms. There were no age group included in the survey forms only the sex and profession/identification of the respondents were reflected.
                                                </p>
                                                <table class="table table-hover table-sm" style="text-align:center">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Sex</th>
                                                        <th scope="col">Number of Respondents</th>
                                                        <th scope="col">Percent</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      @foreach($sex_types as $sex_type)
                                                        <tr>
                                                        <th style="font-style:italic; text-align:left">{{ $sex_type->sex_type_name }}</th>
                                                        <td>{{ $sex_type->count }}</td>
                                                        <td>{{ number_format($sex_type->count/$total_css_responses*100, 0) }}%</td>
                                                        </tr>
                                                      @endforeach
                                                        <th>Total</th>
                                                        <th>{{ $total_css_responses }}</th>
                                                        <th>100%</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                @if( $total_male_css_responses > $total_female_css_responses )
                                                <p>Based on the data collected, this year there were more male ({{ number_format($total_male_css_responses/$total_css_responses*100, 0) }}%) respondents than female ({{ number_format($total_female_css_responses/$total_css_responses*100, 0) }}%) clients served by PITAHC with {{$total_male_css_responses}} respondents out of the {{$total_css_responses}} total survey population.</p>
                                                @else
                                                <p>Based on the data collected, this year there were more female ({{ number_format($total_female_css_responses/$total_css_responses*100, 0) }}%) respondents than male ({{ number_format($total_male_css_responses/$total_css_responses*100, 0) }}%) clients served by PITAHC with {{$total_female_css_responses}} respondents out of the {{$total_css_responses}} total survey population.</p>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <button class="btn btn-secondary float-sm-right" onclick="download('chartA')"><i class="fas fa-download mr-2"></i>Download</button>
                                                <canvas id="chartA"></canvas>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-6">
                                              <table class="table table-hover table-sm" style="text-align:center">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Client Group</th>
                                                        <th scope="col">Number of Respondents</th>
                                                        <th scope="col">Percent</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      @foreach( $client_groups as $client_group )
                                                        <tr>
                                                        <th style="font-style:italic; text-align:left">{{ $client_group->client_group_name }}</th>
                                                        <td>{{ $client_group->count }}</td>
                                                        <td>{{ number_format($client_group->count/$total_css_responses*100, 0) }}%</td>
                                                        </tr>
                                                      @endforeach
                                                        <tr>
                                                        <th>Total</th>
                                                        <th>{{ $total_css_responses }}</th>
                                                        <th>100%</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-6">
                                                <button class="btn btn-secondary float-sm-right" onclick="download('chartG')"><i class="fas fa-download mr-2"></i>Download</button>
                                                <canvas id="chartG"></canvas>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>For the profession or identification of the respondents, the approved CSS forms have pre-listed the possible clients that PITAHC will be serving. Among the {{ App\Http\Livewire\Pages\Css\Results\CssResults::convertNumberToWords($total_css_responses)  }} ({{$total_css_responses}}) respondents, {{ $firstLargestClientTypeCount }} of them ({{ number_format($firstLargestClientTypeCount/$total_css_responses*100, 0) }}%) were {{ $firstLargestClientTypeName == 'Others' ? 'Other' : $firstLargestClientTypeName }}s. It was the followed by “{{ $secondLargestClientTypeName == 'Others' ? 'Other' : $secondLargestClientTypeName }}s” with {{ $secondLargestClientTypeCount }} clients. Third most number of respondents were classified themselves as {{ $thirdLargestClientTypeName == 'Others' ? 'Other' : $thirdLargestClientTypeName }}s with a total of {{ $thirdLargestClientTypeCount }} clients or {{ number_format($thirdLargestClientTypeCount/$total_css_responses*100, 0) }}% of the population.</p>
                                                <table class="table table-hover table-sm" style="text-align:center">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Type of Client</th>
                                                        <th scope="col">Number of Respondents</th>
                                                        <th scope="col">Percent</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      @foreach( $client_types as $client_type )
                                                        <tr>
                                                        <th style="font-style:italic; text-align:left">{{ $client_type->client_type_name }}</th>
                                                        <td>{{ $client_type->count }}</td>
                                                        <td>{{ number_format($client_type->count/$total_css_responses*100, 0) }}%</td>
                                                        </tr>
                                                      @endforeach
                                                        <tr>
                                                        <th>Total</th>
                                                        <th>{{ $total_css_responses }}</th>
                                                        <th>100%</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-6">
                                                <button class="btn btn-secondary float-sm-right" onclick="download('chartB')"><i class="fas fa-download mr-2"></i>Download</button>
                                                <canvas id="chartB"></canvas>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <table class="table table-hover table-sm" style="text-align:center">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Region</th>
                                                        <th scope="col">Number of Respondents</th>
                                                        <th scope="col">Percent</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      @foreach( $regions as $region )
                                                        <tr>
                                                        @if( $region->region_name )
                                                        <th style="font-style:italic; text-align:left">{{ $region->region_name }}</th>
                                                        @else
                                                        <td style="font-style:italic; text-align:center">(Not Provided)</td>
                                                        @endif
                                                        <td>{{ $region->count }}</td>
                                                        <td>{{ number_format($region->count/$total_css_responses*100, 0) }}%</td>
                                                        </tr>
                                                      @endforeach
                                                        <tr>
                                                        <th>Total</th>
                                                        <th>{{ $total_css_responses }}</th>
                                                        <th>100%</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-6">
                                                <button class="btn btn-secondary float-sm-right" onclick="download('chartH')"><i class="fas fa-download mr-2"></i>Download</button>
                                                <canvas id="chartH"></canvas>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <table class="table table-hover table-sm" style="text-align:center">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Awareness</th>
                                                        <th scope="col">Number of Respondents</th>
                                                        <th scope="col">Percent</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      @foreach( $awareness_responses as $awareness_response )
                                                        <tr>
                                                        <th style="font-style:italic; text-align:left">{{ $awareness_response->awareness_response_name }}</th>
                                                        <td>{{ $awareness_response->count }}</td>
                                                        <td>{{ number_format($awareness_response->count/$total_css_responses*100, 0) }}%</td>
                                                        </tr>
                                                      @endforeach
                                                        <tr>
                                                        <th>Total</th>
                                                        <th>{{ $total_css_responses }}</th>
                                                        <th>100%</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-6">
                                                <button class="btn btn-secondary float-sm-right" onclick="download('chartI')"><i class="fas fa-download mr-2"></i>Download</button>
                                                <canvas id="chartI"></canvas>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <table class="table table-hover table-sm" style="text-align:center">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Visibility</th>
                                                        <th scope="col">Number of Respondents</th>
                                                        <th scope="col">Percent</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      @foreach( $visibility_responses as $visibility_response )
                                                        <tr>
                                                        @if( $visibility_response->visibility_response_name )
                                                        <th style="font-style:italic; text-align:left">{{ $visibility_response->visibility_response_name }}</th>
                                                        @else
                                                        <td style="font-style:italic; text-align:center">(Not Applicable)</td>
                                                        @endif
                                                        <td>{{ $visibility_response->count }}</td>
                                                        <td>{{ number_format($visibility_response->count/$total_css_responses*100, 0) }}%</td>
                                                        </tr>
                                                      @endforeach
                                                        <tr>
                                                        <th>Total</th>
                                                        <th>{{ $total_css_responses }}</th>
                                                        <th>100%</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-6">
                                                <button class="btn btn-secondary float-sm-right" onclick="download('chartJ')"><i class="fas fa-download mr-2"></i>Download</button>
                                                <canvas id="chartJ"></canvas>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <table class="table table-hover table-sm" style="text-align:center">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Helpfulness</th>
                                                        <th scope="col">Number of Respondents</th>
                                                        <th scope="col">Percent</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      @foreach( $helpfulness_responses as $helpfulness_response )
                                                        <tr>
                                                        @if( $helpfulness_response->helpfulness_response_name )
                                                        <th style="font-style:italic; text-align:left">{{ $helpfulness_response->helpfulness_response_name }}</th>
                                                        @else
                                                        <td style="font-style:italic; text-align:center">(Not Applicable)</td>
                                                        @endif
                                                        <td>{{ $helpfulness_response->count }}</td>
                                                        <td>{{ number_format($helpfulness_response->count/$total_css_responses*100, 0) }}%</td>
                                                        </tr>
                                                      @endforeach
                                                        <tr>
                                                        <th>Total</th>
                                                        <th>{{ $total_css_responses }}</th>
                                                        <th>100%</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-6">
                                                <button class="btn btn-secondary float-sm-right" onclick="download('chartK')"><i class="fas fa-download mr-2"></i>Download</button>
                                                <canvas id="chartK"></canvas>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-0">
                                                <table class="table table-hover table-sm" style="text-align:center">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col">Availed Services</th>
                                                        <th scope="col">Number of Respondents</th>
                                                        <th scope="col">Percent</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      @foreach( $availed_services as $availed_service )
                                                        <tr>
                                                        <th style="font-style:italic; text-align:left">{{ $availed_service->availed_service_name_short }}</th>
                                                        <td>{{ $availed_service->count }}</td>
                                                        <td>{{ number_format($availed_service->count/$total_css_responses*100, 0) }}%</td>
                                                        </tr>
                                                      @endforeach
                                                        <tr>
                                                        <th>Total</th>
                                                        <th>{{ $total_css_responses }}</th>
                                                        <th>100%</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-12">
                                                <button class="btn btn-secondary float-sm-right" onclick="download('chartF')"><i class="fas fa-download mr-2"></i>Download</button>
                                                <canvas id="chartF"></canvas>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-12">
                                              <p>Based on the data gathered, the most number of respondents for this year survey was from the {{ $firstLargestTransactingOfficeName }} with {{ $firstLargestTransactingOfficeCount }} respondents out of the {{ $total_css_responses }} total respondents ({{ number_format($firstLargestTransactingOfficeCount/$total_css_responses*100, 0) }}%) from January to {{ $param == date("Y") ? date("M") : "December" }} {{ $param }}. It was then followed by {{ App\Http\Livewire\Pages\Css\Results\CssResults::convertNumberToWords(number_format($secondLargestTransactingOfficeCount/$total_css_responses*100, 0))  }} ({{number_format($secondLargestTransactingOfficeCount/$total_css_responses*100, 0)}}%) or {{$secondLargestTransactingOfficeCount}} of the respondents have their services availed through the {{$secondLargestTransactingOfficeName}}. The third most number of client served with accomplished CSS forms was from the {{$thirdLargestTransactingOfficeName}} with {{$thirdLargestTransactingOfficeCount}} respondents. While the {{$firstLowestTransactingOfficeName}} ({{$firstLowestTransactingOfficeCount}}), {{$secondLowestTransactingOfficeName}} ({{$secondLowestTransactingOfficeCount}}) and {{$thirdLowestTransactingOfficeName}} ({{$thirdLowestTransactingOfficeCount}}) had the least number of respondents.</p>
                                            </div>
                                            <div class="col-lg-12">
                                              <table class="table table-hover table-sm" style="text-align:center">
                                                  <thead>
                                                      <tr>
                                                      <th scope="col">Transacting Office</th>
                                                      <th scope="col">Number of Respondents</th>
                                                      <th scope="col">Percent</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                    @foreach( $transacting_offices as $transacting_office )
                                                      <tr>
                                                      <th style="font-style:italic; text-align:left">{{ $transacting_office->transacting_office_name }}</th>
                                                      <td>{{ $transacting_office->count }}</td>
                                                      <td>{{ number_format($transacting_office->count/$total_css_responses*100, 0) }}%</td>
                                                      </tr>
                                                    @endforeach
                                                      <tr>
                                                      <th>Total</th>
                                                      <th>{{ $total_css_responses }}</th>
                                                      <th>100%</th>
                                                      </tr>
                                                  </tbody>
                                              </table>
                                          </div>
                                          <div class="col-lg-12">
                                            <button class="btn btn-secondary float-sm-right" onclick="download('chartC')"><i class="fas fa-download mr-2"></i>Download</button>
                                            <canvas id="chartC"></canvas>
                                        </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                          <div class="col-lg-12">
                                            <h3>Measurement of Service Quality Dimension (SQD) or Criteria</h3>
                                          </div>
                                          <div class="col-lg-12"  style="display: flex; justify-content: space-between;">
                                              <table class="table table-hover table-sm" style="text-align:center; width: 65%;">
                                                  <thead>
                                                      <tr>
                                                      <th scope="col" style="vertical-align: middle">Criteria</th>
                                                      <th scope="col" style="white-space: nowrap;">Very<br>Satisfied</th>
                                                      <th scope="col" style="vertical-align: middle">Satisfied</th>
                                                      <th scope="col" style="white-space: nowrap;">Neither satisfied<br>nor dissatisfied</th>
                                                      <th scope="col" style="vertical-align: middle">Dissatisfied</th>
                                                      <th scope="col" style="white-space: nowrap;">Very<br>dissatisfied</th>
                                                      <th scope="col" style="white-space: nowrap;">Not<br>applicable</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                    @foreach( $services as $service )
                                                      <tr>
                                                      <th style="font-style:italic; text-align:left; white-space: nowrap;">{{ $service->criteria }}</th>
                                                      <td>{{ number_format($service->rating_5, 2) }}%</td>
                                                      <td>{{ number_format($service->rating_4, 2) }}%</td>
                                                      <td>{{ number_format($service->rating_3, 2) }}%</td>
                                                      <td>{{ number_format($service->rating_2, 2) }}%</td>
                                                      <td>{{ number_format($service->rating_1, 2) }}%</td>
                                                      <td>{{ number_format($service->rating_6, 2) }}%</td>
                                                      </tr>
                                                    @endforeach
                                                  </tbody>
                                              </table>
                                              <table class="table table-hover table-sm" style="text-align:center; width: 35%;">
                                                <thead>
                                                    <tr>
                                                    <th scope="col" style="white-space: nowrap;">PITAHC Average<br>Rating/SQD</th>
                                                    <th scope="col" style="white-space: nowrap;">PITAHC Overall<br>Rating</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  @foreach( $averages as $average )
                                                  <tr>
                                                    @if( $average->average_rating >= $PITAHCOverallRating )
                                                    <td class="text-success font-weight-bold">{{  $average->average_rating }}</td>
                                                    @else
                                                    <td class="text-danger font-weight-bold">{{  $average->average_rating }}</td>
                                                    @endif
                                                  <td class="font-weight-bold">{{  $PITAHCOverallRating }}</td>
                                                  </tr>
                                                  @endforeach
                                                </tbody>
                                            </table>
                                          </div>
                                          <br>
                                          <div class="col-lg-12"  style="display: flex; justify-content: space-between;">
                                            <table class="table table-hover table-sm" style="text-align:center; width: 90%;">
                                                <thead>
                                                    <tr>
                                                    <th scope="col" style="vertical-align: middle">Criteria</th>
                                                    <th scope="col" style="white-space: nowrap;">Very<br>Satisfied</th>
                                                    <th scope="col" style="vertical-align: middle">Satisfied</th>
                                                    <th scope="col" style="white-space: nowrap;">Neither satisfied<br>nor dissatisfied</th>
                                                    <th scope="col" style="vertical-align: middle">Dissatisfied</th>
                                                    <th scope="col" style="white-space: nowrap;">Very<br>dissatisfied</th>
                                                    <th scope="col" style="white-space: nowrap;">Not<br>applicable</th>
                                                    <th scope="col" style="vertical-align: middle;">Responses</th>
                                                    {{-- <th scope="col">PITAHC Average Rating/SQD</th>
                                                    <th scope="col">PITAHC Overall Rating</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  @foreach( $services as $service )
                                                    <tr>
                                                    <th style="font-style:italic; text-align:left; white-space: nowrap;">{{ $service->criteria }}</th>
                                                    <td>{{ number_format($service->raw_5, 0) }}</td>
                                                    <td>{{ number_format($service->raw_4, 0) }}</td>
                                                    <td>{{ number_format($service->raw_3, 0) }}</td>
                                                    <td>{{ number_format($service->raw_2, 0) }}</td>
                                                    <td>{{ number_format($service->raw_1, 0) }}</td>
                                                    <td>{{ number_format($service->raw_6, 0) }}</td>
                                                    <td>{{ number_format($service->total_responses, 0) }}</td>
                                                    </tr>
                                                  @endforeach
                                                </tbody>
                                            </table>
                                            <table class="table table-hover table-sm" style="text-align:center; width: 10%;">
                                              <thead>
                                                  <tr>
                                                    <th scope="col" style="vertical-align: middle;">Overall<br>Rating</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                @foreach( $averages as $average )
                                                <tr>
                                                  @if( $average->average_rating >= $PITAHCOverallRating )
                                                  <td class="text-success font-weight-bold">{{  $average->average_rating }}</td>
                                                  @else
                                                  <td class="text-danger font-weight-bold">{{  $average->average_rating }}</td>
                                                  @endif
                                                </tr>
                                                @endforeach
                                              </tbody>
                                          </table>
                                        </div>
                                          <div class="col-lg-12">
                                              <button class="btn btn-secondary float-sm-right" onclick="download('chartD')"><i class="fas fa-download mr-2"></i>Download</button>
                                              <canvas id="chartD"></canvas>
                                          </div>
                                          <div class="col-lg-12">
                                              <button class="btn btn-secondary float-sm-right" onclick="download('chartE')"><i class="fas fa-download mr-2"></i>Download</button>
                                              <canvas id="chartE"></canvas>
                                          </div>
                                      </div>
                                      <hr>
                                      <div class="row" style="display:none">
                                        <div class="col-lg-12">
                                            <button class="btn btn-secondary float-sm-right" onclick="download('chartF')"><i class="fas fa-download mr-2"></i>Download</button>
                                            <canvas id="chartF"></canvas>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div> 
</div>

<script>

window.onload = function() {
    updateChartA();
    updateChartB();
    updateChartC();
    updateChartD();
    updateChartE();
    updateChartF();
    updateChartG();
    updateChartH();
    updateChartI();
    updateChartJ();
    updateChartK();
  };

function generateChart() {
  generateChartA();
  generateChartB();
  generateChartC();
  generateChartD();
  generateChartE();
  generateChartF();
  generateChartG();
  generateChartH();
  generateChartI();
  generateChartJ();
  generateChartK();
}

    // Start Chart A
  function updateChartA() {
      async function fetchData() {    
        const urlString = window.location.href;
        // Create a URL object
        const url = new URL(urlString);
        // Get the pathname from the URL
        const path = url.pathname;
        // Split the pathname by '/'
        const segments = path.split('/');
        // Get the last segment, which should be the year
        const year = segments[segments.length - 1];
        const app_url = '{{ env('APP_URL') }}';
        const set_url = app_url+'/pages/css/results/respondents_sex/'+year;
        const response = await fetch(set_url);
        const datapoints = await response.json();
        return datapoints;
      };

    fetchData().then(datapoints => {
        const Sex = datapoints.respondents_sex.map(
          function(index){
            return index.sex_type_name;
          })
        const SexCount = datapoints.respondents_sex.map(
          function(index){
            return index.count;
          })

          console.log(Sex);
          console.log(SexCount);
          myChartA.config.data.labels = Sex;
          myChartA.config.data.datasets[0].data = SexCount;
          myChartA.update();
      });
    }

    function generateChartA() {
      async function fetchData() {    
        const year = $param;
        const report_type_id = document.getElementById("report_type_id");
        const app_url = '{{ env('APP_URL') }}';
        const url = app_url+'/pages/css/results/respondents_sex_filter/'+year+'/'+report_type_id;
        const response = await fetch(url);
        const datapoints = await response.json();
        return datapoints;
      };

    fetchData().then(datapoints => {
        const Sex = datapoints.respondents_sex_filter.map(
          function(index){
            return index.sex_type_name;
          })
        const SexCount = datapoints.respondents_sex_filter.map(
          function(index){
            return index.count;
          })

          console.log(Sex);
          console.log(SexCount);
          myChartA.config.data.labels = Sex;
          myChartA.config.data.datasets[0].data = SexCount;
          myChartA.update();
      });
    }
const dataA = {
  labels: ['', ''],
  datasets: [
    {
      label: 'Sex',
      data: [0, 0],
      backgroundColor: ['#4285f4', '#EA4335'],
    }
  ]
};

const configA = {
  type: 'doughnut',
  data: dataA,
  options: {
    plugins: {
      datalabels: {
        formatter: (value, context) => {
          return value + ' (' +((value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(0) + '%)';
        },
        color: '#fff', // You can customize the font color
        anchor: 'end',
        align: 'start',
        offset: 25,
      font: {
        weight: 'bold',
        size: '15'
      } 
      },
      legend: {
        position: 'bottom', 
        labels: {
          font: {
            size: 14
          }
        }
      },
      title: {
        display: true,
        text: 'Number of Respondents: by Sex',
        position: 'top',
        font: {
          size: 18
        }
      },
    },
  },
  plugins: [ChartDataLabels]
};

    const myChartA = new Chart(
    document.getElementById('chartA'),
    configA
    );
    // End Chart A
    // Start Chart B
    function updateChartB() {
      async function fetchData() {  
        const urlString = window.location.href;
        // Create a URL object
        const url = new URL(urlString);
        // Get the pathname from the URL
        const path = url.pathname;
        // Split the pathname by '/'
        const segments = path.split('/');
        // Get the last segment, which should be the year
        const year = segments[segments.length - 1];
        const app_url = '{{ env('APP_URL') }}';
        const set_url = app_url+'/pages/css/results/respondents_client_type/'+year;
        const response = await fetch(set_url);
        const datapoints = await response.json();
        return datapoints;
      };

    fetchData().then(datapoints => {
        const ClientType = datapoints.respondents_client_type.map(
          function(index){
            return index.client_type_name;
          })
        const ClientTypeCount = datapoints.respondents_client_type.map(
          function(index){
            return index.count;
          })

          console.log(ClientType);
          console.log(ClientTypeCount);
          myChartB.config.data.labels = ClientType;
          myChartB.config.data.datasets[0].data = ClientTypeCount;
          myChartB.update();
      });
    }

    function generateChartB() {
      async function fetchData() {    
        const year = $param;
        const report_type_id = document.getElementById("report_type_id");
        const app_url = '{{ env('APP_URL') }}';
        const url = app_url+'/pages/css/results/respondents_client_type_filter/'+year+'/'+report_type_id;
        const response = await fetch(url);
        const datapoints = await response.json();
        return datapoints;
      };

    fetchData().then(datapoints => {
        const ClientType = datapoints.respondents_client_type_filter.map(
          function(index){
            return index.client_type_name;
          })
        const ClientTypeCount = datapoints.respondents_client_type_filter.map(
          function(index){
            return index.count;
          })

          console.log(ClientType);
          console.log(ClientTypeCount);
          myChartB.config.data.labels = ClientType;
          myChartB.config.data.datasets[0].data = ClientTypeCount;
          myChartB.update();
      });
    }
const dataB = {
  labels: ['', '', '', '', '', '', ''],
  datasets: [
    {
      label: 'Client Type',
      data: [0, 0, 0, 0, 0, 0, 0],
      backgroundColor: ['#4083f1', '#e74234', '#f7b902', '#32a552', '#fb6c00', '#44bbc3', '#0848ad'],
      datalabels: {
        color: ['#fff', '#fff', '#000', '#fff', '#fff', '#000', '#fff'],
        font: {
          weight: 'bold',
          size: '15'
        } 
      },
    }
  ]
};

const configB = {
  type: 'pie',
  data: dataB,
  options: {
    plugins: {
      datalabels: {
        formatter: (value, context) => {
          if( ((value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(0) > 2 ){
            return value + ' (' +((value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(0) + '%)';
          }else{
            return '';
          } 
        },
        color: '#fff', // You can customize the font color
        anchor: 'end',
        align: 'start',
        offset: 60,
        font: {
          weight: 'bold',
          size: '15'
        } 
      },
      legend: {
        position: 'bottom', 
        labels: {
          font: {
            size: 14
          }
        }
      },
      title: {
        display: true,
        text: 'Number of Respondents: by Type of Client',
        position: 'top',
        font: {
          size: 18
        }
      },
    },
  },
  plugins: [ChartDataLabels]
};

    const myChartB = new Chart(
    document.getElementById('chartB'),
    configB
    );
    // End Chart B
    // Start Chart C
    function updateChartC() {
      async function fetchData() {  
        const urlString = window.location.href;
        // Create a URL object
        const url = new URL(urlString);
        // Get the pathname from the URL
        const path = url.pathname;
        // Split the pathname by '/'
        const segments = path.split('/');
        // Get the last segment, which should be the year
        const year = segments[segments.length - 1];
        const app_url = '{{ env('APP_URL') }}';
        const set_url = app_url+'/pages/css/results/respondents_transacting_office/'+year;
        const response = await fetch(set_url);
        const datapoints = await response.json();
        return datapoints;
      };

    fetchData().then(datapoints => {
        const Office = datapoints.respondents_transacting_office.map(
          function(index){
            return index.transacting_office_name;
          })
        const OfficeCount = datapoints.respondents_transacting_office.map(
          function(index){
            return index.count;
          })

          console.log(Office);
          console.log(OfficeCount);
          myChartC.config.data.labels = Office;
          myChartC.config.data.datasets[0].data = OfficeCount;
          myChartC.update();
      });
    }

    function generateChartC() {
      async function fetchData() {    
        const year = $param;
        const report_type_id = document.getElementById("report_type_id");
        const app_url = '{{ env('APP_URL') }}';
        const url = app_url+'/pages/css/results/respondents_transacting_office_filter/'+year+'/'+report_type_id;
        const response = await fetch(url);
        const datapoints = await response.json();
        return datapoints;
      };

    fetchData().then(datapoints => {
        const Office = datapoints.respondents_transacting_office_filter.map(
          function(index){
            return index.transacting_office_name;
          })
        const OfficeCount = datapoints.respondents_transacting_office_filter.map(
          function(index){
            return index.count;
          })

          console.log(Office);
          console.log(OfficeCount);
          myChartC.config.data.labels = Office;
          myChartC.config.data.datasets[0].data = OfficeCount;
          myChartC.update();
      });
    }
const dataC = {
  labels: ['', '', '', '', '', '', '', '', '', ''],
  datasets: [
    {
      label: 'Transacting Office',
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
      backgroundColor: ['#4285f4'],
    }
  ]
};

const configC = {
  type: 'bar',
  data: dataC,
  options: {
    indexAxis: 'y',
    // Elements options apply to all of the options unless overridden in a dataset
    // In this case, we are setting the border of each horizontal bar to be 2px wide
    elements: {
      bar: {
        borderWidth: 2,
      }
    },
    responsive: true,
    plugins: {
      
    datalabels: {
      formatter: (value, context) => {
        return value + ' (' +((value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(0) + '%)';
      },
      anchor: 'end',
      align: 'right',
      font: {
        weight: 'bold',
        size: '15'
      } 
    },
      legend: {
        display: true
      },
      title: {
        display: true,
        text: 'Number of Respondents: Transacting Office',
        position: 'top',
          font: {
              size: 18
          }
      }
    },
    scales: {
      y: {
        grid: {
          display: false, // Remove horizontal grid lines
        },
      }
    }
  },
  plugins: [ChartDataLabels]
};

    const myChartC = new Chart(
    document.getElementById('chartC'),
    configC
    );
    // End Chart C
    // Start Chart D
    function updateChartD() {
      async function fetchData() {  
        const urlString = window.location.href;
        // Create a URL object
        const url = new URL(urlString);
        // Get the pathname from the URL
        const path = url.pathname;
        // Split the pathname by '/'
        const segments = path.split('/');
        // Get the last segment, which should be the year
        const year = segments[segments.length - 1];
        const app_url = '{{ env('APP_URL') }}';
        const set_url = app_url+'/pages/css/results/ratings/'+year;
        const response = await fetch(set_url);
        const datapoints = await response.json();
        return datapoints;
      };

    fetchData().then(datapoints => {
        const Criteria = datapoints.ratings.map(
          function(index){
            return index.criteria;
          })
        const Rating5 = datapoints.ratings.map(
          function(index){
            return index.rating_5;
          })
        const Rating4 = datapoints.ratings.map(
          function(index){
            return index.rating_4;
          })
        const Rating3 = datapoints.ratings.map(
          function(index){
            return index.rating_3;
          })
        const Rating2 = datapoints.ratings.map(
          function(index){
            return index.rating_2;
          })
        const Rating1 = datapoints.ratings.map(
          function(index){
            return index.rating_1;
          })
        const Rating6 = datapoints.ratings.map(
          function(index){
            return index.rating_6;
          })

          console.log(Criteria);
          console.log(Rating5);
          console.log(Rating4);
          console.log(Rating3);
          console.log(Rating2);
          console.log(Rating1);
          console.log(Rating6);
          myChartD.config.data.labels = Criteria;
          myChartD.config.data.datasets[0].data = Rating5;
          myChartD.config.data.datasets[1].data = Rating4;
          myChartD.config.data.datasets[2].data = Rating3;
          myChartD.config.data.datasets[3].data = Rating2;
          myChartD.config.data.datasets[4].data = Rating1;
          myChartD.config.data.datasets[5].data = Rating6;
          myChartD.update();
      });
    }

    function generateChartD() {
      async function fetchData() {   
        const year = $param;
        const report_type_id = document.getElementById("report_type_id");
        const app_url = '{{ env('APP_URL') }}';
        const url = app_url+'/pages/css/results/ratings/'+year+'/'+report_type_id;
        const response = await fetch(url);
        const datapoints = await response.json();
        return datapoints;
      };

    fetchData().then(datapoints => {
        const Criteria = datapoints.ratings.map(
          function(index){
            return index.criteria;
          })
        const Rating5 = datapoints.ratings.map(
          function(index){
            return index.rating_5;
          })
        const Rating4 = datapoints.ratings.map(
          function(index){
            return index.rating_4;
          })
        const Rating3 = datapoints.ratings.map(
          function(index){
            return index.rating_3;
          })
        const Rating2 = datapoints.ratings.map(
          function(index){
            return index.rating_2;
          })
        const Rating1 = datapoints.ratings.map(
          function(index){
            return index.rating_1;
          })
        const Rating6 = datapoints.ratings.map(
          function(index){
            return index.rating_6;
          })

          console.log(Criteria);
          console.log(Rating5);
          console.log(Rating4);
          console.log(Rating3);
          console.log(Rating2);
          console.log(Rating1);
          console.log(Rating6);
          myChartD.config.data.labels = Criteria;
          myChartD.config.data.datasets[0].data = Rating5;
          myChartD.config.data.datasets[1].data = Rating4;
          myChartD.config.data.datasets[2].data = Rating3;
          myChartD.config.data.datasets[3].data = Rating2;
          myChartD.config.data.datasets[4].data = Rating1;
          myChartD.config.data.datasets[5].data = Rating6;
          myChartD.update();
      });
    }
const dataD = {
  labels: ['', '', '', '', '', '', '', '', ''],
  datasets: [
    {
      label: 'Very Satisfied',
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0],
      backgroundColor: ['#00b71d'],
    },
    {
      label: 'Satisfied',
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0],
      backgroundColor: ['#93b518'],
    },
    {
      label: 'Neither satisfied nor dissatisfied',
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0],
      backgroundColor: ['#ffeb01'],
      datalabels: {
        color: '#000',
        font: {
          weight: 'bold',
          size: '15'
        } 
      },
    },
    {
      label: 'Dissatisfied',
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0],
      backgroundColor: ['#ff9000'],
    },
    {
      label: 'Very Dissatisfied',
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0],
      backgroundColor: ['#ff4330'],
    },
    {
      label: 'Not Applicable',
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0],
      backgroundColor: ['#636664'],
    }
  ]
};

const configD = {
  type: 'bar',
  data: dataD,
  options: {
    indexAxis: 'y',
    // Elements options apply to all of the options unless overridden in a dataset
    // In this case, we are setting the border of each horizontal bar to be 2px wide
    elements: {
      bar: {
        borderWidth: 2,
      }
    },
    responsive: true,
    plugins: {
      datalabels: {
        formatter: (value, context) => {
          if( value > 2 ){
            return value + '%';
          }else{
            return '';
          }
        },
        color: '#fff',
        clamp: 'true',
        font: {
          weight: 'bold',
          size: '15'
        } 
      },

      title: {
        display: true,
        text: 'Distribution of Client\'s Rating',
        position: 'top',
          font: {
              size: 18
          }
      },
          legend: {
            position: 'bottom',
            labels: {
              font: {
                style: 'italic',
              },
              color: '#000000'
            }
          },
    },
    scales: {
      x: {
        stacked: true, 
        beginAtZero: true, // Start y-axis from minimum value
        max: 100, // Minimum value for y-axis
        min: 50, // Minimum value for y-axis
        ticks: {
          stepSize: 2, // Adjust step size as needed
        },
      },
      y: {
        stacked: true,
        grid: {
          display: false, // Remove horizontal grid lines
        },
      }
    }
  },
  plugins: [ChartDataLabels]
};

    const myChartD = new Chart(
    document.getElementById('chartD'),
    configD
    );
    // End Chart D

    // Start Chart E
    function updateChartE() {
      async function fetchData() {  
        const urlString = window.location.href;
        // Create a URL object
        const url = new URL(urlString);
        // Get the pathname from the URL
        const path = url.pathname;
        // Split the pathname by '/'
        const segments = path.split('/');
        // Get the last segment, which should be the year
        const year = segments[segments.length - 1];
        const app_url = '{{ env('APP_URL') }}';
        const set_url = app_url+'/pages/css/results/average/'+year;
        const response = await fetch(set_url);
        const datapoints = await response.json();
        return datapoints;
      };

    fetchData().then(datapoints => {
        const Criteria = datapoints.average.map(
          function(index){
            return index.criteria;
          })
        const AverageRating = datapoints.average.map(
          function(index){
            return index.average_rating;
          })
        const OverallRating = datapoints.average.map(
          function(index){
            return index.overall_rating;
          })

          console.log(Criteria);
          console.log(AverageRating);
          console.log(OverallRating);
          myChartE.config.data.labels = Criteria;
          myChartE.config.data.datasets[0].data = AverageRating;
          myChartE.config.data.datasets[1].data = OverallRating;
          myChartE.update();
      });
    }

    function generateChartE() {
      async function fetchData() {    
        const year = $param;
        const report_type_id = document.getElementById("report_type_id");
        const app_url = '{{ env('APP_URL') }}';
        const url = app_url+'/pages/css/results/average/'+year+'/'+report_type_id;
        const response = await fetch(url);
        const datapoints = await response.json();
        return datapoints;
      };

    fetchData().then(datapoints => {
        const Criteria = datapoints.average.map(
          function(index){
            return index.criteria;
          })
        const AverageRating = datapoints.average.map(
          function(index){
            return index.average_rating;
          })
        const OverallRating = datapoints.average.map(
          function(index){
            return index.overall_rating;
          })

          console.log(Criteria);
          console.log(AverageRating);
          console.log(OverallRating);
          myChartE.config.data.labels = Criteria;
          myChartE.config.data.datasets[0].data = AverageRating;
          myChartE.config.data.datasets[1].data = OverallRating;
          myChartE.update();
      });
    }
const dataE = {
  labels: ['', '', '', '', '', '', '', '', ''],
  datasets: [
    {
      datalabels: {
        color: '#fff',
        font: {
          weight: 'bold',
          size: '15'
        } 
      },
      label: 'PITAHC Average Rating/SQD',
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0],
      backgroundColor: ['#4285f4'],
      order: 1
    },
    {
      datalabels: {
        color: '#000',     
        align: 'end',
        offset: 0,
        font: {
          weight: 'bold',
          size: '15'
        } 
      },
      label: 'PITAHC Overall Rating',
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0],
      borderColor: ['#EA4335'],
      backgroundColor: ['#EA4335'],
      type: 'line',
      order: 0,
    }
  ]
};

const configE = {
  type: 'bar',
  data: dataE,
  options: {
    scales: {
      x: {
        grid: {
          display: false, // Remove vertical grid lines
        },
      },
      y: {
        beginAtZero: false, // Start y-axis from minimum value
        max: 5, // Minimum value for y-axis
        //min: 3.50, // Minimum value for y-axis
        ticks: {
          stepSize: 0.05, // Adjust step size as needed
        },
      },
    },
    elements: {
      bar: {
        borderWidth: 2,
      }
    },
    responsive: true,
    plugins: {
      title: {
        display: true,
        text: 'PITAHC Average Rating: By SQD',
        position: 'top',
          font: {
              size: 18
          }
      },
      legend: {
        position: 'bottom',
        labels: {
          font: {
            style: 'italic',
          },
          color: '#000000'
        }
      },
      datalabels: {
      color: '#fff',
      clamp: 'true',
      display: function(context) {
          return context.dataset.data[context.dataIndex] > 0;
      },
      align: 'center'
    }
},
  },
  plugins: [ChartDataLabels]
};

    const myChartE = new Chart(
    document.getElementById('chartE'),
    configE
    );
    // End Chart E

    // Start Chart F
    function updateChartF() {
      async function fetchData() {  
        const urlString = window.location.href;
        // Create a URL object
        const url = new URL(urlString);
        // Get the pathname from the URL
        const path = url.pathname;
        // Split the pathname by '/'
        const segments = path.split('/');
        // Get the last segment, which should be the year
        const year = segments[segments.length - 1];
        const app_url = '{{ env('APP_URL') }}';
        const set_url = app_url+'/pages/css/results/respondents_availed_service/'+year;
        const response = await fetch(set_url);
        const datapoints = await response.json();
        return datapoints;
      };

    fetchData().then(datapoints => {
        const AvailedService = datapoints.respondents_availed_service.map(
          function(index){
            return index.availed_service_name_short;
          })
        const AvailedServiceCount = datapoints.respondents_availed_service.map(
          function(index){
            return index.count;
          })

          console.log(AvailedService);
          console.log(AvailedServiceCount);
          myChartF.config.data.labels = AvailedService;
          myChartF.config.data.datasets[0].data = AvailedServiceCount;
          myChartF.update();
      });
    }

    function generateChartF() {
      async function fetchData() {    
        const year = $param;
        const report_type_id = document.getElementById("report_type_id");
        const app_url = '{{ env('APP_URL') }}';
        const url = app_url+'/pages/css/results/respondents_availed_service_filter/'+year+'/'+report_type_id;
        const response = await fetch(url);
        const datapoints = await response.json();
        return datapoints;
      };

    fetchData().then(datapoints => {
        const AvailedService = datapoints.respondents_availed_service_filter.map(
          function(index){
            return index.availed_service_name_short;
          })
        const AvailedServiceCount = datapoints.respondents_availed_service_filter.map(
          function(index){
            return index.count;
          })

          console.log(AvailedService);
          console.log(AvailedServiceCount);
          myChartF.config.data.labels = AvailedService;
          myChartF.config.data.datasets[0].data = AvailedServiceCount;
          myChartF.update();
      });
    }
const dataF = {
  labels: ['', '', '', '', '', '', ''],
  datasets: [
    {
      label: 'Service Availed',
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
      datalabels: {
        font: {
          weight: 'bold',
          size: '15'
        } 
      },
    }
  ]
};

const configF = {
  type: 'pie',
  data: dataF,
  options: {
    plugins: {
      datalabels: {
        formatter: (value, context) => {
          if( ((value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(0) > 2 ){
            return value + ' (' +((value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(0) + '%)';
          }else{
            return '';
          } 
        },
        color: '#fff', // You can customize the font color
        anchor: 'end',
        align: 'start',
        offset: 60,
        font: {
          weight: 'bold',
          size: '15'
        } 
      },
      legend: {
        position: 'bottom', 
        labels: {
          font: {
            size: 14
          }
        }
      },
      title: {
        display: true,
        text: 'Number of Respondents: by Availed Service',
        position: 'top',
        font: {
          size: 18
        }
      },
    },
  },
  plugins: [ChartDataLabels]
};

    const myChartF = new Chart(
    document.getElementById('chartF'),
    configF
    );
    // End Chart F
    // Start Chart G
    function updateChartG() {
  async function fetchData() {  
    const urlString = window.location.href;
    // Create a URL object
    const url = new URL(urlString);
    // Get the pathname from the URL
    const path = url.pathname;
    // Split the pathname by '/'
    const segments = path.split('/');
    // Get the last segment, which should be the year
    const year = segments[segments.length - 1];
    const app_url = '{{ env('APP_URL') }}';
    const set_url = app_url+'/pages/css/results/respondents_client_group/'+year;
    const response = await fetch(set_url);
    const datapoints = await response.json();
    return datapoints;
  };

fetchData().then(datapoints => {
    const ClientGroup = datapoints.respondents_client_group.map(
      function(index){
        return index.client_group_name;
      })
    const ClientGroupCount = datapoints.respondents_client_group.map(
      function(index){
        return index.count;
      })

      console.log(ClientGroup);
      console.log(ClientGroupCount);
      myChartG.config.data.labels = ClientGroup;
      myChartG.config.data.datasets[0].data = ClientGroupCount;
      myChartG.update();
  });
}

function generateChartG() {
  async function fetchData() {    
    const year = $param;
    const report_type_id = document.getElementById("report_type_id");
    const app_url = '{{ env('APP_URL') }}';
    const url = app_url+'/pages/css/results/respondents_client_group_filter/'+year+'/'+report_type_id;
    const response = await fetch(url);
    const datapoints = await response.json();
    return datapoints;
  };

fetchData().then(datapoints => {
    const ClientGroup = datapoints.respondents_client_group_filter.map(
      function(index){
        return index.client_type_name;
      })
    const ClientGroupCount = datapoints.respondents_client_group_filter.map(
      function(index){
        return index.count;
      })

      console.log(ClientGroup);
      console.log(ClientGroupCount);
      myChartG.config.data.labels = ClientGroup;
      myChartG.config.data.datasets[0].data = ClientGroupCount;
      myChartG.update();
  });
}
const dataG = {
labels: ['', '', ''],
datasets: [
{
  label: 'Client Group',
  data: [0, 0, 0],
}
]
};

const configG = {
type: 'pie',
data: dataG,
options: {
plugins: {
  datalabels: {
    formatter: (value, context) => {
      if( ((value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(0) > 2 ){
        return value + ' (' +((value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(0) + '%)';
      }else{
        return '';
      } 
    },
    color: '#fff', // You can customize the font color
    anchor: 'end',
    align: 'start',
    offset: 60,
    font: {
      weight: 'bold',
      size: '15'
    } 
  },
  legend: {
    position: 'bottom', 
    labels: {
      font: {
        size: 14
      }
    }
  },
  title: {
    display: true,
    text: 'Number of Respondents: by Client Group',
    position: 'top',
    font: {
      size: 18
    }
  },
},
},
plugins: [ChartDataLabels]
};

const myChartG = new Chart(
document.getElementById('chartG'),
configG
);
// End Chart G
// Start Chart H
function updateChartH() {
  async function fetchData() {  
    const urlString = window.location.href;
    // Create a URL object
    const url = new URL(urlString);
    // Get the pathname from the URL
    const path = url.pathname;
    // Split the pathname by '/'
    const segments = path.split('/');
    // Get the last segment, which should be the year
    const year = segments[segments.length - 1];
    const app_url = '{{ env('APP_URL') }}';
    const set_url = app_url+'/pages/css/results/respondents_region/'+year;
    const response = await fetch(set_url);
    const datapoints = await response.json();
    return datapoints;
  };

fetchData().then(datapoints => {
    const Region = datapoints.respondents_region.map(
      function(index){
        return ( index.region_name ) ? index.region_name : 'Not Provided';
      })
    const RegionCount = datapoints.respondents_region.map(
      function(index){
        return index.count;
      })

      console.log(Region);
      console.log(RegionCount);
      myChartH.config.data.labels = Region;
      myChartH.config.data.datasets[0].data = RegionCount;
      myChartH.update();
  });
}

function generateChartH() {
  async function fetchData() {    
    const year = $param;
    const report_type_id = document.getElementById("report_type_id");
    const app_url = '{{ env('APP_URL') }}';
    const url = app_url+'/pages/css/results/respondents_region_filter/'+year+'/'+report_type_id;
    const response = await fetch(url);
    const datapoints = await response.json();
    return datapoints;
  };

fetchData().then(datapoints => {
    const RegionGroup = datapoints.respondents_region_filter.map(
      function(index){
        return ( index.region_name ) ? index.region_name : 'Not Provided';
      })
    const RegionCount = datapoints.respondents_region_filter.map(
      function(index){
        return index.count;
      })

      console.log(RegionGroup);
      console.log(RegionCount);
      myChartH.config.data.labels = RegionGroup;
      myChartH.config.data.datasets[0].data = RegionCount;
      myChartH.update();
  });
}
const dataH = {
labels: ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
datasets: [
{
  label: 'Region',
  data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
}
]
};

const configH = {
type: 'pie',
data: dataH,
options: {
plugins: {
  datalabels: {
    formatter: (value, context) => {
      if( ((value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(0) > 2 ){
        return value + ' (' +((value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(0) + '%)';
      }else{
        return '';
      } 
    },
    color: '#fff', // You can customize the font color
    anchor: 'end',
    align: 'start',
    offset: 60,
    font: {
      weight: 'bold',
      size: '15'
    } 
  },
  legend: {
    position: 'bottom', 
    labels: {
      font: {
        size: 14
      }
    }
  },
  title: {
    display: true,
    text: 'Number of Respondents: by Region',
    position: 'top',
    font: {
      size: 18
    }
  },
},
},
plugins: [ChartDataLabels]
};

const myChartH = new Chart(
document.getElementById('chartH'),
configH
);
// End Chart H
// Start Chart I
function updateChartI() {
  async function fetchData() {  
    const urlString = window.location.href;
    // Create a URL object
    const url = new URL(urlString);
    // Get the pathname from the URL
    const path = url.pathname;
    // Split the pathname by '/'
    const segments = path.split('/');
    // Get the last segment, which should be the year
    const year = segments[segments.length - 1];
    const app_url = '{{ env('APP_URL') }}';
    const set_url = app_url+'/pages/css/results/respondents_awareness_response/'+year;
    const response = await fetch(set_url);
    const datapoints = await response.json();
    return datapoints;
  };

fetchData().then(datapoints => {
    const AwarenessResponse = datapoints.respondents_awareness_response.map(
      function(index){
        return index.awareness_response_name;
      })
    const AwarenessResponseCount = datapoints.respondents_awareness_response.map(
      function(index){
        return index.count;
      })

      console.log(AwarenessResponse);
      console.log(AwarenessResponseCount);
      myChartI.config.data.labels = AwarenessResponse;
      myChartI.config.data.datasets[0].data = AwarenessResponseCount;
      myChartI.update();
  });
}

function generateChartI() {
  async function fetchData() {    
    const year = $param;
    const report_type_id = document.getElementById("report_type_id");
    const app_url = '{{ env('APP_URL') }}';
    const url = app_url+'/pages/css/results/respondents_awareness_response_filter/'+year+'/'+report_type_id;
    const response = await fetch(url);
    const datapoints = await response.json();
    return datapoints;
  };

fetchData().then(datapoints => {
    const AwarenessResponse = datapoints.respondents_awareness_response_filter.map(
      function(index){
        return index.awareness_response_name;
      })
    const AwarenessResponseCount = datapoints.respondents_awareness_response_filter.map(
      function(index){
        return index.count;
      })

      console.log(AwarenessResponse);
      console.log(AwarenessResponseCount);
      myChartI.config.data.labels = AwarenessResponse;
      myChartI.config.data.datasets[0].data = AwarenessResponseCount;
      myChartI.update();
  });
}
const dataI = {
labels: ['', '', '', ''],
datasets: [
{
  label: 'Awareness',
  data: [0, 0, 0, 0],
}
]
};

const configI = {
type: 'pie',
data: dataI,
options: {
plugins: {
  datalabels: {
    formatter: (value, context) => {
      if( ((value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(0) > 2 ){
        return value + ' (' +((value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(0) + '%)';
      }else{
        return '';
      } 
    },
    color: '#fff', // You can customize the font color
    anchor: 'end',
    align: 'start',
    offset: 60,
    font: {
      weight: 'bold',
      size: '15'
    } 
  },
  legend: {
    position: 'bottom', 
    labels: {
      font: {
        size: 14
      }
    }
  },
  title: {
    display: true,
    text: 'Number of Respondents: CC1 Awareness Response',
    position: 'top',
    font: {
      size: 18
    }
  },
},
},
plugins: [ChartDataLabels]
};

const myChartI = new Chart(
document.getElementById('chartI'),
configI
);
// End Chart I
// Start Chart J
function updateChartJ() {
  async function fetchData() {  
    const urlString = window.location.href;
    // Create a URL object
    const url = new URL(urlString);
    // Get the pathname from the URL
    const path = url.pathname;
    // Split the pathname by '/'
    const segments = path.split('/');
    // Get the last segment, which should be the year
    const year = segments[segments.length - 1];
    const app_url = '{{ env('APP_URL') }}';
    const set_url = app_url+'/pages/css/results/respondents_visibility_response/'+year;
    const response = await fetch(set_url);
    const datapoints = await response.json();
    return datapoints;
  };

fetchData().then(datapoints => {
    const VisibilityResponse = datapoints.respondents_visibility_response.map(
      function(index){
        return ( index.visibility_response_name ) ? index.visibility_response_name : 'Not Applicable';
      })
    const VisibilityResponseCount = datapoints.respondents_visibility_response.map(
      function(index){
        return index.count;
      })

      console.log(VisibilityResponse);
      console.log(VisibilityResponseCount);
      myChartJ.config.data.labels = VisibilityResponse;
      myChartJ.config.data.datasets[0].data = VisibilityResponseCount;
      myChartJ.update();
  });
}

function generateChartJ() {
  async function fetchData() {    
    const year = $param;
    const report_type_id = document.getElementById("report_type_id");
    const app_url = '{{ env('APP_URL') }}';
    const url = app_url+'/pages/css/results/respondents_visibility_response_filter/'+year+'/'+report_type_id;
    const response = await fetch(url);
    const datapoints = await response.json();
    return datapoints;
  };

fetchData().then(datapoints => {
    const VisibilityResponse = datapoints.respondents_visibility_response_filter.map(
      function(index){
        return ( index.visibility_response_name ) ? index.visibility_response_name : 'Not Applicable';
      })
    const VisibilityResponseCount = datapoints.respondents_visibility_response_filter.map(
      function(index){
        return index.count;
      })

      console.log(VisibilityResponse);
      console.log(VisibilityResponseCount);
      myChartJ.config.data.labels = VisibilityResponse;
      myChartJ.config.data.datasets[0].data = VisibilityResponseCount;
      myChartJ.update();
  });
}
const dataJ = {
labels: ['', '', '', '', ''],
datasets: [
{
  label: 'Visibility',
  data: [0, 0, 0, 0, 0],
}
]
};

const configJ = {
type: 'pie',
data: dataJ,
options: {
plugins: {
  datalabels: {
    formatter: (value, context) => {
      if( ((value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(0) > 2 ){
        return value + ' (' +((value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(0) + '%)';
      }else{
        return '';
      } 
    },
    color: '#fff', // You can customize the font color
    anchor: 'end',
    align: 'start',
    offset: 60,
    font: {
      weight: 'bold',
      size: '15'
    } 
  },
  legend: {
    position: 'bottom', 
    labels: {
      font: {
        size: 14
      }
    }
  },
  title: {
    display: true,
    text: 'Number of Respondents: CC2 Visibility Response',
    position: 'top',
    font: {
      size: 18
    }
  },
},
},
plugins: [ChartDataLabels]
};

const myChartJ = new Chart(
document.getElementById('chartJ'),
configJ
);
// End Chart J
// Start Chart K
function updateChartK() {
  async function fetchData() {  
    const urlString = window.location.href;
    // Create a URL object
    const url = new URL(urlString);
    // Get the pathname from the URL
    const path = url.pathname;
    // Split the pathname by '/'
    const segments = path.split('/');
    // Get the last segment, which should be the year
    const year = segments[segments.length - 1];
    const app_url = '{{ env('APP_URL') }}';
    const set_url = app_url+'/pages/css/results/respondents_helpfulness_response/'+year;
    const response = await fetch(set_url);
    const datapoints = await response.json();
    return datapoints;
  };

fetchData().then(datapoints => {
    const HelpfulnessResponse = datapoints.respondents_helpfulness_response.map(
      function(index){
        return ( index.helpfulness_response_name ) ? index.helpfulness_response_name : 'Not Applicable';
      })
    const HelpfulnessResponseCount = datapoints.respondents_helpfulness_response.map(
      function(index){
        return index.count;
      })

      console.log(HelpfulnessResponse);
      console.log(HelpfulnessResponseCount);
      myChartK.config.data.labels = HelpfulnessResponse;
      myChartK.config.data.datasets[0].data = HelpfulnessResponseCount;
      myChartK.update();
  });
}

function generateChartK() {
  async function fetchData() {    
    const year = $param;
    const report_type_id = document.getElementById("report_type_id");
    const app_url = '{{ env('APP_URL') }}';
    const url = app_url+'/pages/css/results/respondents_helpfulness_response_filter/'+year+'/'+report_type_id;
    const response = await fetch(url);
    const datapoints = await response.json();
    return datapoints;
  };

fetchData().then(datapoints => {
    const HelpfulnessResponse = datapoints.respondents_helpfulness_response_filter.map(
      function(index){
        return ( index.helpfulness_response_name ) ? index.helpfulness_response_name : 'Not Applicable';
      })
    const HelpfulnessResponseCount = datapoints.respondents_helpfulness_response_filter.map(
      function(index){
        return index.count;
      })

      console.log(HelpfulnessResponse);
      console.log(HelpfulnessResponseCount);
      myChartK.config.data.labels = HelpfulnessResponse;
      myChartK.config.data.datasets[0].data = HelpfulnessResponseCount;
      myChartK.update();
  });
}
const dataK = {
labels: ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
datasets: [
{
  label: 'Helpfulness',
  data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
}
]
};

const configK = {
type: 'pie',
data: dataK,
options: {
plugins: {
  datalabels: {
    formatter: (value, context) => {
      if( ((value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(0) > 2 ){
        return value + ' (' +((value / context.dataset.data.reduce((a, b) => a + b, 0)) * 100).toFixed(0) + '%)';
      }else{
        return '';
      } 
    },
    color: '#fff', // You can customize the font color
    anchor: 'end',
    align: 'start',
    offset: 60,
    font: {
      weight: 'bold',
      size: '15'
    } 
  },
  legend: {
    position: 'bottom', 
    labels: {
      font: {
        size: 14
      }
    }
  },
  title: {
    display: true,
    text: 'Number of Respondents: CC3 Helpfulness Response',
    position: 'top',
    font: {
      size: 18
    }
  },
},
},
plugins: [ChartDataLabels]
};

const myChartK = new Chart(
document.getElementById('chartK'),
configK
);
// End Chart K
    function download(id) {
      const imageLink = document.createElement('a')
      const canvas = document.getElementById(id);
      imageLink.download = 'canvas.png';
      imageLink.href = canvas.toDataURL('image/png', 1);
      imageLink.click();
    }
</script>
</div>
