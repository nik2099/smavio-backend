 <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Smavio Player</title>
    
       <style>
        .card {
	          margin-bottom: 1.5rem;
	      }
	      
	      .card {
	          position: relative;
	          display: -ms-flexbox;
	          display: flex;
	          -ms-flex-direction: column;
	          flex-direction: column;
	          min-width: 0;
	          word-wrap: break-word;
	          background-color: #fff;
	          background-clip: border-box;
	          border: 1px solid #c8ced3;
	          border-radius: .25rem;
	      } 
	      strong {
			    display: inline-block;
			}
			.table {
                 margin-bottom: 0px;
			}
			
			.table {
			    margin-bottom: 0px;
			}
			.table {
			    margin-top: 0;
			}
		.table {
    --bs-table-color: var(--bs-body-color);
    --bs-table-bg: transparent;
    --bs-table-border-color: var(--bs-border-color);
    --bs-table-accent-bg: transparent;
    --bs-table-striped-color: var(--bs-body-color);
    --bs-table-striped-bg: rgba(0, 0, 0, 0.05);
    --bs-table-active-color: var(--bs-body-color);
    --bs-table-active-bg: rgba(0, 0, 0, 0.1);
    --bs-table-hover-color: var(--bs-body-color);
    --bs-table-hover-bg: rgba(0, 0, 0, 0.075);
    width: 100%;
    margin-bottom: 1rem;
    color: var(--bs-table-color);
    vertical-align: top;
    border-color: var(--bs-table-border-color);
}
.center{
	text-align:center;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgb(227 227 227 / 50%);
}
.left{
	text-align:left;
}
.right{
	text-align:right;
}

.table-striped > tbody > tr:nth-of-type(odd) > * {
    /* --bs-table-accent-bg: var(--bs-table-striped-bg); */
    color: var(--bs-table-striped-color);
}
.table th, .table td {
    padding: 20px;
}
			table {
			    caption-side: bottom;
			    border-collapse: collapse;
			}
			
			.table > thead {
    vertical-align: bottom;
}
thead, tbody, tfoot, tr, td, th {
    border-color: #e6edef;
}
thead, tbody, tfoot, tr, td, th {
    border-color: #e6edef;
}
thead, tbody, tfoot, tr, td, th {
    border-color: inherit;
    border-style: solid;
    border-width: 0;
}


@media print 
{
    @page {
      size: A4; /* DIN A4 standard, Europe */
      margin:0;
    }
    html, body {
        width: 210mm;
        /* height: 297mm; */
        height: 282mm;
        font-size: 11px;
        background: #FFF;
        overflow:visible;
    }
    body {
        padding-top:15mm;
    }
}
	      .mb-4 {
			    margin-bottom: 1.5rem !important;
			}
	      
	      .card .card-body {
			    padding: 10px;
			    background-color: transparent;
			}

	      .card-header:first-child {
	          border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
	      }
	      
	      .card-header {
	          padding: .75rem 1.25rem;
	          margin-bottom: 0;
	          background-color: #f0f3f5;
	          border-bottom: 1px solid #c8ced3;
	      }
	      .ui-view{
	        width: 80%;
	        margin: auto;
	        margin-top:20px;
	      }
	      
	      .row {
		
			   width:100%;
		
			}

	      .col {
	      	 
	      	   
			    width:50%;
			    float:left;
			}
			
			 .col-12{
	      	 
	      	   
			    width:100%;
			  
			}
			
		   .col-4{
	      	 
	      	   
			    width:33.3%;
			   float:left;
			}

	     .col-sm-3 {
			    flex: 0 0 auto;
			    width: 25%;
			}
	     </style>
</head>
<body>
  
 
     <div class="">
           <div id="ui-view" style="width: 100%;margin:auto;margin-top:20px">
              <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <img style="" src="https://staging.appmate.in/Smavio-laravel-admin-dashboard/public/images/logo (2).png"/>
                        </div>
                    </div>
                    
                    
                    <div class="row mb-4">
                        <div style="width:50%;float:left">
                          
                          <div>
                              <strong>{{$invoice->customer_name}}</strong>
                          </div>
                          <div>{{$invoice->customer_address}}</div>
                          <div>Email: {{$invoice->customer_email}}</div>
                          <div>Telefon: {{$invoice->customer_phone}}</div>
                         
                        </div>

                        <div style="width:50%;float:right">
                          <div>Rechnungsnummer :
                              <strong> {{$invoice->number}}</strong>
                          </div>
                          <div>Quittungsnummer :
                              <strong> {{$invoice->receipt_number}}</strong>
                          </div>
                          <div>{{$invoice->created}}</div>
                          <div>Kontobezeichnung: {{$invoice->account_name}}</div>
                        
                        </div>
                    </div>
                    
                   <div class="row"></div>
                   

                    <div class="row">
                   
			                    <div style="width:100%;text-align:left;" class="mb-4 mt-4">
			                     Rechnung {{$invoice->number}},
			                      <br/> Sehr geehrte Damen und Herren, 
                                wir erlauben uns wie folgt Rechnung zu stellen:
			                    </div>
		                  
                    </div>

                    <div class="table-responsive-sm">
                      <table class="table table-striped">
                          <thead>
                              <tr>
                                  <th class="center">#</th>
                                  <th class="left">Beschreibung</th>
                                  <th class="left">Menge</th>
                                  <th class="right">Stückpreis</th>
                                  <th class="right">Menge</th>
                              </tr>
                          </thead>
                      <tbody>
                      	
                      	
                     

                       <?php
                             $i=1;
                              foreach($invoice->lines as $val){ ?>
                              	
                              	  <tr>
											<td class="center">{{$i}}</td>
											<td class="left">{{$val->description}}</td>
											<td class="left">{{$val->quantity}}</td>
											<td class="right">€ {{$val->price->unit_amount/100}}</td>
											<td class="right">€{{$val->amount/100}}</td>
		                            </tr>
                              <?php $i++;  } 
                           ?>
                           
                            <tr>
                            <td colSpan="3"></td>
                              <td class="right">
                              <strong>Gesamt</strong>
                              </td>
                              <td class="right">€ {{$invoice->total_excluding_tax/100}}</td>
                            </tr>
                            <tr>
                            <td colSpan="3"></td>
                              <td class="right">
                              <strong>Bezahlter Betrag</strong>
                              </td>
                              <td class="right">
                              <strong>€ {{$invoice->total/100}}</strong>
                              </td>
                            </tr>

                      </tbody>
                      </table>
                    </div>
                   
                    <div clas="row mb-4">
	                    <div class="col-12">
	                        <div>Der Ort der Leistungserbringung war Deutschland, Zeitpunkt entspricht dem Rechnungsdatum.
	                         Den Betrag überweisen Sie bitte in den nächsten 7 Tagen auf das unten genannte Konto, unter
	                        Angabe der Rechnungsnummer.</div>
	                    </div>
                    </div>
                    
                    <div clas="row mt-5" style="margin-top: 17px">
                        <div class="col-12">
                           <div>
                              <strong>Begünstigter: </strong> Ingmar Hansen
                          </div>
                          <div><strong>Bankverbindung: </strong> Commerzbank Berlin</div>
                          <div><strong>IBAN: </strong> DE27 1204 0000 0026 3640 00</div>
                          <div><strong>BIC: </strong> COBADEFFXXX</div>
                          <div>Mit freundlichen Grüßen <br/> Ingmar Hansen</div>
                        </div>
                    </div>
                </div>
              </div>

              <hr></hr>

              <div class="row mb-4">
                  <div class="col-4">
                    <div>
                        <strong>Hansen World</strong>
                    </div>
                    <div>Dunckerstr 12</div>
                    <div>10437 Berlin</div>
                    <div>Email: hallo@hansen-world.de</div>
                    <div>Phone: 03946 5199901</div>
                  </div>

                  <div class="col-4">
                    <div>USt-IdNr: DE258547789</div>
                    <div>Steuernummer: 31/330/00979</div>
                  </div>

                  <div class="col-4">
                    <div>Ingmar Hansen</div>
                    <div>Commerzbank Filiale Berlin 2</div>
                    <div>IBAN: DE27 1204 0000 0026 3640 00</div>
                    <div>BIC: COBADEFFXX</div>
                    
                  </div>
              </div>
           </div>
      </div>
      </div>
</body>
</html>


 