<!DOCTYPE html>
<html>
    <head>
        <title>Generate DV PDF</title>
        <link rel="stylesheet" href="{{ public_path('bootstrap.min.css') }}">
        <style>
      
          .header{
            font-size: 11px;
            font-weight: normal;
            text-align:center;
          }
          table td{
            font-size: 11px;
          }
          .box-container {
            display: flex;
          }
          .box {
              width: 20px;
              height: 10px;
              border: 1px solid black;
              margin-left: 7px;
              display: inline-block;
              vertical-align: middle;
              margin-top: 2px;
              margin-bottom: 2px;
          }
          .label {
              font-size: 11px;
              display: inline-block;
              margin-right: 8px;
              margin-left: 5px;
              line-height: 1;
          }
          
        
      </style>
    </head>
    <body>
      @if($result !== null)
        <div >
          <?php $div=[1,2];?>
            @foreach($div as $d)
              <table border= 1px solid black width= 100% style="table-layout: fixed;">
                  <div>
                      <table >
                              <tr>
                                  <td width="23%" style="text-align: center; border-right:none">
                                      <img src="{{realpath(__DIR__ . '/../../..').'/public/images/doh-logo.png'}}" style="width: 50%; max-width: 50%;" />
                                  </td>
                                  <td width="54%" style="border-left:none;padding: 2px; border-right:none; "><br>
                                    <div class="header" style="line-height: 1.2;">
                                      <span style="margin-top: 10px">Republic of the Philippines</span> <br>
                                      <strong> CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT</strong> <br>
                                      <small>Osmeña Boulevard, Cebu City, Philippines 6000</small> <br>
                                      <small>Regional Director's Office Tel. No (032) 253-6335 Fax No. (032) 254-0109</small><br>
                                      <small>Official Website <u>www.ro7.doh.gov.ph/</u> Email Address <u>dohro7@gmail.com</u></small><br><br>
                                    </div>
                                  </td>
                                  <td width="23%" style="text-align: right; border-left:none; vertical-align:bottom"><small><i>Appendix 32&nbsp;&nbsp;&nbsp;</i></small></td>
                              </tr>
                         
                          
                      </table>
                      <table width=100%>
                        <tr>
                          <td height=3% width =81% style="text-align:center;font-size:14px"> <strong>DISBURSEMENT VOUCHER</strong></td>
                          <td style="width:19%; font-size: 10px; line-height: 1.2;" >
                            <b>
                              <span style="margin-bottom: 20px">Fund Cluster :</span><br>
                              <span style="margin-top: 20px">Date: {{ date('F j, Y', strtotime($result->date))}}</span><br>
                              <span>DV No. :</span>   
                            </b>    
                          </td>
                        </tr>
                      </table>
                    
                      <table width=100% style="table-layout: fixed;">
                        <tr>
                          <td width =10% style="line-height: 1;"><b> Mode of Payment</td>
                          <td style="width:85%; border-left: 0; line-height: 1; " >
                              <div class="box-container">
                                <span class="box"></span>
                                <span class="label">MDS Check</span>

                                <span class="box"></span>
                                <span class="label">Commercial Check</span>

                                <span class="box"></span>
                                <span class="label">ADA</span>
                                <span class="box"></span>
                                <span class="label">Others (Please specify)</span>
                                <span style="margin-top:1px; margin-left:5px">______________</span>
                              </div>
                          </td>
                        </tr>
                      </table>
                      <table width=100%>
                        <tr>
                          <td width=10.4%><b> Payee</td>
                          <td style="width:39.6%; border-left: 0 "><b> {{$pre_dv->facility->name}}</td>
                          <td style="width:30%; border-left: 0; vertical-align:top; " >
                            <span style="vertical-align:top; " >Tin/Employee No. :</span>
                          </td>
                          <td style="width:19%; border-left: 0 " >
                          <span style="vertical-align:top; ">ORS/BURS No. :</span>
                          </td>
                        </tr>
                      </table>
                      <table width=100%>
                        <tr>
                          <td width=10.5%><b>Address</td>
                          <td style="width: 89.5%; border-left: 0 ;vertical-align:top; "><b>{{$pre_dv->facility->address}}</td>
                          
                        </tr>
                      </table>
                      <table width=100%>
                        <tr class="header">
                          <td width =50%> Particulars</td>
                          <td style="width:20%; border-left: 0 " >Responsibility Center</td>
                          <td style="width:10%; border-left: 0 " >MFO/PAP</td>
                          <td style="width:20%; border-left: 0 " >Amount</td>
                        </tr>
                        <tr>
                          <td style="width: 58%;vertical-align:top">
                              <p style="text-align:justify; margin-bottom:8px; line-height: 1.3;">For reimbursement of medical services rendered to patients under the Medical 
                              Assistance for Indigent Patient Program for {{$pre_dv->facility->name}}
                              per billing statement dated {{date('F Y', strtotime($result->date_from))}} {{!Empty($result->date_to)?date('F Y', strtotime($result->date_to)):''}}
                              in the amount of:</p>
                              
                              @foreach($fundsources as $index=> $fund_saa)
                                  <span class="saa" style="float: left; font-size:10px; padding:0px; margin:0; line-height: 1.2;">{{$fund_saa['saa']}}</span>
                                  <span class="amount" style="float: right; padding:0px; margin:0; line-height: 1.2;">{{ number_format(floatval(str_replace(',','',$fund_saa['amount'])), 2, '.', ',') }}</span>
                                  <div style="clear: both;"></div>
                              @endforeach
                              
                              <div style="width: 100%; margin-top:5px; line-height: 1.2;">   
                                @if(floor($info->vat) == 3)
                                  <span class="saa" style="margin-left:10px;">{{ floor($info->vat) . '%' . ' ' . 'Percentage Tax' }}</span>
                                @else
                                  <span class="saa" style="margin-left:10px;">{{ floor($info->vat) . '%' . ' ' . 'VAT' }}</span>
                                @endif
                                <span style="margin-left:50px;">{{number_format((($info->vat > 3)?$amount / 1.12 : $amount),2,'.',',')}}</span>
                                <span style="float: right;">{{number_format((($info->vat > 3)? $amount / 1.12 * $info->vat / 100: $amount * $info->vat / 100),2,'.',',')}}</span>
                                <div style="clear: both;"></div>
                              </div>
                              <div style="width: 100%;line-height: 1.2;">   
                                <span class="saa" style="margin-left:10px;"> {{floor($info->Ewt).'%'.' '.'EWT'}}</span>
                                @if(floor($info->vat) == 3)
                                  <span style="margin-left:105px;">{{number_format((($info->vat > 3)?$amount / 1.12 : $amount),2,'.',',')}}</span>
                                @else
                                  <span style="margin-left:48px;">{{number_format((($info->vat > 3)?$amount / 1.12 : $amount),2,'.',',')}}</span>
                                @endif
                                <span style="float: right;">{{number_format((($info->vat > 3)? $amount / 1.12 * $info->Ewt / 100: $amount * $info->Ewt / 100),2,'.',',')}}</span>
                                <div style="clear: both;"></div>
                              </div>
                              <span type="text" style="width:95%; margin-top:5px" class="saa">Control No:{{$control}}<span><br>
                              <span style="margin-left:150px; font-weight:bold">Amount Due</span>
                          
                          </td>
                          <td style="width:14%; border-left: 0 " ></td>
                          <td style="width:14%; border-left: 0 " ></td>
                          <td style="width:14%; border-left: 0 " >
                          <div class= "header">
                            <br><br><br><br>
                            <span style="text-align:center;">{{number_format($amount, 2, '.',',')}}</span>
                            <br><br><br><br>
                        
                            <span style="text-align:center;">{{number_format(((($info->vat > 3)? $amount / 1.12 * $info->vat / 100: $amount * $info->vat / 100) + (($info->vat > 3)? $amount / 1.12 * $info->Ewt / 100: $amount * $info->Ewt / 100)),2,'.',',')}}</span><br><br>
                            <span style="text-align:center;">_________________</span><br>
                            <span style="text-align:center;">{{number_format(($amount - ((($info->vat > 3)? $amount / 1.12 * $info->vat / 100: $amount * $info->vat / 100) + (($info->vat > 3)? $amount / 1.12 * $info->Ewt / 100: $amount * $info->Ewt / 100))),2,'.',',')}}</span>
                          </div> 
                        </td>
                        </tr>
                      </table>
                      <table width=100%>
                        <tr>
                          <td width =15% style="line-height: 1;">
                              <dv>  
                                <span>A. Certified: Expenses/Cash Advance necessary, lawful and incurred under my direct supervision.</span>
                                <br><br>
                                <div style="display:inline-block;"><br>
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  &nbsp;&nbsp;&nbsp;
                                  <span><strong><u>SOPHIA M. MANCAO, MD, DPSP, RN-MAN</u><strong></span>
                                </div>
                                <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span>Director III</span>
                              </dv>
                          </td>
                        </tr>
                      </table>
                      <table width=100%>
                        <tr>
                          <td width =15% style="line-height: 1.2;"><strong>B. Accounting Entry:</strong></td>
                        </tr>
                      </table>
                      <table width=100%>
                        <tr class="header" tyle="line-height: 1.2;">
                          <td width =50%>Account Title</td>
                          <td style="width:20%; border-left: 0; vertical-align:top " >Uacs Code</td>
                          <td style="width:15%; border-left: 0 " >Debit</td>
                          <td style="width:15%; border-left: 0 " >Credit</td>
                        </tr>
                        <tr class="header">
                          <td style="text-align : left;vertical-align:top; line-height: 1.2;">
                            &nbsp;&nbsp;&nbsp;&nbsp;<span>Subsidy / Others</span><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;<span>Accumulated Surplus</span><br>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Due to BIR</span><br> 
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CIB-MDS</span> 
                          </td>
                          <td style=" border-left: 0; line-height: 1.2;" >
                            <span>50214990</span><br>
                            <span>30101010</span><br>
                            <span>20201010</span><br> 
                            <span>10104040</span> 
                          </td>
                          <td style=" border-left: 0 ; text-align:right; vertical-align:top; line-height: 1.2;" >
                            <span>
                                {{number_format((($result)? $amount - $result->accumulated: $amount),2,'.',',')}}
                            </span><br>
                            <span>{{number_format(($result?$result->accumulated:0),2,'.',',')}}</span>
                          </td>
                          <td style=" border-left: 0 ; text-align:right; vertical-align:top; line-height: 1.2;" >
                            <br><br><span>{{number_format(((($info->vat > 3)? $amount / 1.12 * $info->vat / 100: $amount * $info->vat / 100) + (($info->vat > 3)? $amount / 1.12 * $info->Ewt / 100: $amount * $info->Ewt / 100)),2,'.',',')}}</span><br>
                            <span>{{number_format(($amount - ((($info->vat > 3)? $amount / 1.12 * $info->vat / 100: $amount * $info->vat / 100) + (($info->vat > 3)? $amount / 1.12 * $info->Ewt / 100: $amount * $info->Ewt / 100))),2,'.',',')}}</span>
                          </td>
                        </tr>
                      </table>
                      <table width=100%>
                        <tr>
                            <td width =50%><strong>C. Certified:</strong></td>
                            <td width =50%><strong>D. Approved for Payment:</strong></td>
                        </tr>
                        <tr>
                            <td>
                              <div style="display: inline-flex; align-items: center;margin-top:5px">
                                  <span class="box" style="display: inline-block;"></span>
                                  <p style="margin-left: 5px; display: inline;line-height: 1.2;">Cash Available</p>
                              </div>
                              <div style="display: inline-flex; align-items: center;">
                                  <span class="box" style="display: inline-block;"></span>
                                  <p style="margin-left: 5px; display: inline;line-height: 1.2;">Subject to Authority to Debit Account (when applicable)</p>
                              </div>
                              <div style="display: inline-flex; align-items: center;">
                                  <span class="box" style="display: inline-block;"></span>
                                  <p style="margin-left: 5px; display: inline;line-height: 1.2;">Supporting documents complete and amount claimed proper</p>
                              </div>
                            </td>
                            <td></td>  
                        </tr>
                      </table>
                      <table width=100%>
                        <tr class="header">
                            <td width =10%>Signature</td>
                            <td width =40%></td>
                            <td width =15%>Signature</td>
                            <td width =35%></td> 
                        </tr>
                        <tr class="header">
                            <td>Printed Name</td>
                            <td><b>ANGIELINE T. ADLAON, CPA, MBA</td>
                            <td>Printed Name</td>
                            <td><b>JAIME S. BERNADAS, MD, MGM, CESO III</td>
                        </tr>
                        <tr class="header">
                            <td>Position</td>
                            <td>
                              <table width=100% style="text-align:center" border=0>
                                <tr>
                                  <td  style="border-bottom: 1px solid black">Head, Accounting Section</td>
                                </tr>
                                <tr>
                                  <td>Head, Accounting Unit/Authorized Representative</td>
                                </tr>
                            </table>
                            </td>
                            <td>Position</td>
                            <td>
                              <table width=100% style="text-align:center" border=0>
                                  <tr>
                                    <td style="border-bottom: 1px solid black">Director IV</td>
                                  </tr>
                                  <tr>
                                    <td >Agency Head/Authorized Representative</td>
                                  </tr>
                              </table>
                            </td>
                        </tr>
                        <tr class="header">
                            <td>Date</td>
                            <td></td>
                            <td>Date</td>
                            <td></td>
                        </tr>
                      </table>
                      <table width=100%>
                        <tr>
                            
                            <td colspan="4" width =31% style="vertical-align:top"><b>E. Receipt of Payment</b></td>
                            <td width =19% style="vertical-align:top; border-bottom:none">JEV No.</td>
                        </tr>
                        <tr>
                            <td width =10.4% style="line-height: 1;">Check/ADA No.:</td>
                            <td width =25%></td>
                            <td width =15% style="vertical-align:top">Date:</td>
                            <td width =31% style="vertical-align:top">Bank Name & Account Number:</td>
                            <td width =19% style="vertical-align:top; border-top:none"></td>
                        </tr>
                        <tr>
                            <td >Signature:</td>
                            <td></td>
                            <td style="vertical-align:top">Date:</td>
                            <td style="vertical-align:top">Printed Name:</td>
                            <td style="vertical-align:top; border-bottom:none">Date</td>
                        </tr>
                        <tr>
                            <td colspan="4" width =31% style="vertical-align:top">Official Receipt No. & Date/Other Documents</td>
                            <td width =19% style="vertical-align:top; border-top:none"></td>
                        </tr>
                      </table>     
                      </div>
                </table>
                <div style="position:absolute; left: 50%; transform: translateX(-50%); margin-top:5px;" class="modal_footer">
                    {!! DNS1D::getBarcodeHTML($result->route_no, 'C39E', 1, 28) !!}
                    <div style="text-align: center;">
                        <font class="route_no">{{ $result->route_no }}</font>
                    </div>
                </div>  
                @if($d == 1)
                  <div style="page-break-before: always;"></div>
                @endif
            @endforeach
            @foreach($fundsources as $index => $fund_saa)
                @if($fund_saa['path'])
                    <div style="page-break-before: always;"></div>
                    <div style="margin-left: 1px; margin-right: 1px;">
                        <div style="text-align: center;">
                            <span>{{$fund_saa['saa']}}</span>
                            <br><br> <br><br> <br><br> <br><br> <br><br>
                            <img src="{{ url('storage/app/' . $fund_saa['path']) }}" 
                                style="width:1000px; height:700px; transform: rotate(270deg);">
                        </div>
                    </div>
                @endif
            @endforeach
            <div style="page-break-before: always;"></div>
            <div>
                <div style="width: 100%; text-align:center;margin-top:3%">
                    <h5><b>V1</b><h3>
                </div>
                <table border= 1px solid black width= 100%>
                    <tr>
                        <div style="width: 100%; text-align:center;margin-top:3%">
                            <span style="font-weight: bold">{{$pre_dv->facility->name}}</span>
                        </div>
                        <div style="display: inline-block; width: 100%; margin-top:30px;">
                            @foreach($pre_dv->extension as $index => $row)
                                @if($index == 0)
                                    <label style="display: inline-block; margin-left: 16%; width: 20%; font-weight: bold">SAA</label>
                                    <label style="display: inline-block; margin-left: 6%; width: 20%; font-weight: bold">AMOUNT</label>
                                    <label style="display: inline-block; margin-left: 8%; width: 20%; font-weight: bold">PROPONENT</label>

                                @endif
                                @foreach ($row->saas as $data)
                                    <span style="border: 1px solid black; padding: 2px;display: inline-block; width: 32%; height: 40px; margin-left: 2%; margin-top: 8px; text-align:center; font-size:12px">{{ $data->saa->saa }}</span>
                                    <span style="line-height: 30px; border: 1px solid black; padding: 2px;display: inline-block; width: 20%; height: 40px; text-align: center; margin-left: 2%; text-align:center; font-size:12px">{{ number_format(str_replace(',', '', $data->amount), 2, '.',',')}}</span>
                                    <span style="border: 1px solid black; padding: 2px;display: inline-block; width: 36%; height: 40px; text-align: center; margin-left: 2%; text-align:center; font-size:12px">{{ $row->proponent->proponent }}</span>
                                @endforeach
                            @endforeach
                        </div>
                    </tr>
                    <div style="width: 100%; margin-top: 5%; margin-bottom: 5%;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 61.5%;border:0"></td>
                                <td style="width: 36.5%; text-align: center; border: 1px solid black; padding: 2px; font-size: 12px; margin-right: 20%;">
                                    {{number_format(str_replace(',','', $amount), 2,'.',',')}}
                                </td>
                                <td style="width: 2%;border:0"></td>
                            </tr>
                        </table>
                    </div>
                </table>
            </div>
        @endif
    </body>
</html>
