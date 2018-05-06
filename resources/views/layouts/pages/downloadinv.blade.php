<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 1</title>
    <style type="text/css">
    .clearfix:after {
      content: "";
      display: table;
      clear: both;
    }

    a {
      color: #5D6975;
      text-decoration: underline;
    }

    body {
      position: relative;
      margin: 0 auto; 
      color: #001028;
      background: #FFFFFF; 
      font-family: Arial, sans-serif; 
      font-size: 12px; 
      font-family: Arial;
    }

    header {
      padding: 10px 0;
      margin-bottom: 30px;
    }

    #logo {
      margin-bottom: 10px;
      clear: both;
    }

    #logo img {
      width: 90px;
      float: right;
      
    }

    h1 {
      border-top: 1px solid  #5D6975;
      border-bottom: 1px solid  #5D6975;
      color: #5D6975;
      font-size: 2.4em;
      line-height: 1.4em;
      font-weight: normal;
      text-align: center;
      margin: 0 0 20px 0;
      background: url(dimension.png);
    }

    #project {
      float: left;
    }

    #project span {
      color: #5D6975;
      text-align: right;
      width: 52px;
      margin-right: 10px;
      display: inline-block;
      font-size: 0.8em;
    }

    #company {
      float: right;
      text-align: right;
    }

    #project div,
    #company div {
      white-space: nowrap;        
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-spacing: 0;
      margin-bottom: 20px;
    }

    table tr:nth-child(2n-1) td {
      background: #F5F5F5;
    }

    table th,
    table td {
      text-align: center;
    }

    table th {
      padding: 5px 20px;
      color: #5D6975;
      border-bottom: 1px solid #C1CED9;
      white-space: nowrap;        
      font-weight: normal;
    }

    table .service,
    table .desc {
      text-align: left;
    }

    table td {
      padding: 10px;
      text-align: center;
      border: 1px;
    }

    table td.service,
    table td.desc {
      vertical-align: top;
    }

    table td.unit,
    table td.qty,
    table td.total {
      font-size: 1.2em;
    }

    table td.grand {
      border: 1px solid #5D6975;;
    }

    #notices .notice {
      color: #5D6975;
      font-size: 1.2em;
    }

  </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="../public/img/SavvyPay.PNG" width="200px" height="100px">
        <div id="project">
          <div><span>FROM</span> SavvyPAY.com</div>
          <div><span>CLIENT</span> John Doe</div>
          <div><span>ADDRESS</span> 796 Silver Harbour, TX 79273, US</div>
          <div><span>EMAIL</span> <a href="mailto:john@example.com">john@example.com</a></div>
          <div><span>DATE</span> August 17, 2015</div>
        </div>
      </div>

      <h1>INVOICE 3-2-1</h1>
      <div id="company" class="clearfix">
        <div>Company Name</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
      </div>
      
      <div id="project" style="padding-left: 50px">
        <div><span>TO</span> {{$user[0]->name}}</div>
        <div><span>ADDRESS</span> 
          {{$user[0]->address->line1}},
          {{$user[0]->address->line2}},
          {{$user[0]->address->po}},
          {{$user[0]->address->pocode}},
          {{$user[0]->address->area}},
          {{$user[0]->address->city}}
        </div>
        <div><span>Phone</span> {{$user[0]->address->phone}}</div>
        <div><span>EMAIL</span> <a href="mailto:{{$user[0]->email}}">{{$user[0]->email}}</a></div>
        <div><span>DATE</span> {{$settlementdetails[0]->created_at->format('l j F Y') }}</div>
        <div><span>ADJUSTMENT DATE</span> Demo Date</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">Serial</th>
            <th class="desc">Payment Method</th>
            <th>Total</th>
            <th>Charge</th>
            <th>Creditable</th>
          </tr>
        </thead>
        <tbody border="1">

          @foreach($settlementdetails as $indexKey => $setl)
          <tr>
            <td class="service">{{$indexKey+1}}</td>
            <td class="desc">{{$setl->Methodtype->name}}</td>
            <td class="unit">{{number_format($setl->TotalAmount,2)}}</td>
            <td class="qty">{{number_format($setl->Charge,2)}}</td>
            <td class="total">{{number_format($setl->CreditableAmount,2)}}</td>
          </tr>
          @endforeach
          <tr>
            <td class="service" colspan="2">Total</td>
            <td class="unit">80</td>
            <td class="qty">80</td>
            <td class="total">800</td>
          </tr>
          
        </tbody>
      </table>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">
          Payments are adjusted by 15 days of invoice generation. Any change in the date will be 
          communicated through email. Please contact +880 1851313826 for any help.
        </div>
      </div>
    </main>
  </body>
</html>