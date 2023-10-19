<!DOCTYPE html>
<html>
    <head>
        <title>Maip Report</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}"> -->
        <style>
            .header-container {
                clear: both;
            }

             .img-wrap {
                display: inline-block;
                float: left;
                vertical-align: top;
                /* margin-right: 10px; */
            } 

            .header {
                font-size: 11px;
                text-align: center;
                margin: 10px;
            }

            .left-align {
                text-align: right;
            }

            p {
                font-size: 11px;
            }
            td {
                font-size: 11px; 
                padding: 8px; 
                border: 1px solid #ccc; 
            }
 
    .static-data {
        display: inline-block;
      min-width: 42%; 
      text-align: right; 
    }
    .static-data1 {
        display: inline-block;
      min-width: 16%; 
      text-align: right; 
    }
    #certifacate{
     font-size: 13px;
     margin-top:15px;
    }
    .date{
        /* float: right; */
        text-align: right;
    }
        </style>
    </head>
    <body>
    <div class="row align-items-start ml-1"> 
        <div class="col-1 d-flex align-items-center">
            <div class="img-wrap">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/doh-logo.png'))) }}" alt="Logo" width="50" height="50">
            </div>
        </div>
        <div class="col-11 text-center" style="font-size: 10px">
            <div class="ml-2">
                <p>Republic of the Philippines<br>
                    Department of Health<br>
                    <span class="col text-center" style="font-size: 13px"><strong>MALASAKIT PROGRAM OFFICE</strong></span>
                </p>
            </div>
        </div>
    </div>

    <div class="form-group ml-1">
        <p class="date">{{ $date }}</p>
        <p class="col text-center" id="certificate"><strong>CERTIFICATION</strong></p> <!-- Corrected typo in ID -->
    </div>

    <div class="form-group ml-1">
        <p>This is to certify that patient <strong>{{ $patient->fname . ' ' . $patient->mname . ' ' . $patient->lname}}</strong>, 65 y/o, of CITY OF PASIG NCR SECOND DISTRICT, was extended by this office, a total of Php3,000.00 medical assistance stated below based on the existing guidelines of Administrative Order No. 2020 - 0060, dated December 23, 2020:</p>
    </div>

    <table class="table table-white ml-1">
        <thead>
            <tr>
                <th scope="col" style="font-size: 12px">Type of Assistance</th>
                <th scope="col" style="font-size: 12px">Utilization</th>
                <th scope="col" style="font-size: 12px">Remaining Balance</th>
                <th scope="col" style="font-size: 12px">Date/Time</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Hospital Bills / laboratory /Procedures/ Medicine()</td>
                <td class="text-center">3,000.00</td>
                <td class="text-center">0.00</td>
                <td>2023-07-14 16:47:42</td>
            </tr>
        </tbody>
    </table>

    <p class="ml-3" ><strong>Total Amount:</strong>
        <span class="static-data"><strong>3,000.00</strong></span>
        <span class="static-data1"><strong>P0.00</strong></span>
    </p>
    <div class="row align-items-start ml-1"> 
        <p class="ml-1">EAMC-230630-1674341E9DD<br><br>
            Notes:<br>
            <i>50% maximum applicable for PF</i><br>
            Non-Convertible to cash<br><br>
            Encoded by: sat19.ncr
        </p>
    </div>
    <div class="col text-center">
        <p>STA CRUZ MANILA, 651-7800 Local: 1807, 1810, 1811, 1805, and 2908, <a href="https://doh.gov.ph">doh.gov.ph</a></p>
    </div>
 
       <hr> <!-- Horizontal line representing the footer -->
            <div class="row align-items-start"> 
                    <div class="col-1 d-flex align-items-center">
                        <div class="img-wrap">
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/doh-logo.png'))) }}" alt="Logo" width="50" height="50">
                        </div>
                    </div>
                    <div class="col-11 text-center" style="font-size: 10px">
                        <div class="ml-2">
                            <p>Republic of the Philippines<br>
                                Department of Health<br>
                                <span class="col text-center" style="font-size: 13px"><strong>MALASAKIT PROGRAM OFFICE</strong></span>
                            </p>
                        </div>
                    </div>
            </div>

                <div class="form-group">
                    <p class="date">{{ $date }}</p>
                    <p class="col text-center" id="certificate"><strong>CERTIFICATION</strong></p> <!-- Corrected typo in ID -->
                </div>

                <div class="form-group">
                    <p>This is to certify that patient <strong>{{ $patient->fname . ' ' . $patient->mname . ' ' . $patient->lname}}</strong>, 65 y/o, of CITY OF PASIG NCR SECOND DISTRICT, was extended by this office, a total of Php3,000.00 medical assistance stated below based on the existing guidelines of Administrative Order No. 2020 - 0060, dated December 23, 2020:</p>
                </div>

                <table class="table table-white">
                    <thead>
                        <tr>
                            <th scope="col" style="font-size: 12px">Type of Assistance</th>
                            <th scope="col" style="font-size: 12px">Utilization</th>
                            <th scope="col" style="font-size: 12px">Remaining Balance</th>
                            <th scope="col" style="font-size: 12px">Date/Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Hospital Bills / laboratory /Procedures/ Medicine()</td>
                            <td class="text-center">3,000.00</td>
                            <td class="text-center">0.00</td>
                            <td>2023-07-14 16:47:42</td>
                        </tr>
                    </tbody>
                </table>

                <p class="ml-3"><strong>Total Amount:</strong>
                    <span class="static-data"><strong>3,000.00</strong></span>
                    <span class="static-data1"><strong>P0.00</strong></span>
                </p>
              <div class="row align-items-start ml-1"> 
                    <p class="ml-1">EAMC-230630-1674341E9DD<br><br>
                        Notes:<br>
                        <i>50% maximum applicable for PF</i><br>
                        Non-Convertible to cash<br><br>
                        Encoded by: sat19.ncr
                    </p>
               </div>
               <div class="col text-center">
                    <p>STA CRUZ MANILA, 651-7800 Local: 1807, 1810, 1811, 1805, and 2908, <a href="https://doh.gov.ph">doh.gov.ph</a></p>
               </div>       
      
    </body>
</html>
