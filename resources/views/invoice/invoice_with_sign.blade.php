<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
     <style type="text/css">
       html, body { display: block;
        
        font-size:15px;
         font-weight:normal;
         margin: 0px;
         padding: 0px 20px 0px 0px;
    }
         div{
             font-family: sans-serif,DejaVu Sans;
            

         }
	.margin-div{ margin: 0%; padding: 0%; }
	.normal-txt{
		 font-size:15px;
        font-family:sans-serif;
        font-weight:normal;
       	}
           .ft-25{
        font-size:25px;
        font-weight: bold;
    }
    .ft-30{
        font-size:30px;
        font-weight: bold;
    }

    .ft-16{
        font-size:16px;
    }
    .ft-14{
        font-size:14px;
    }

    .heading{
        font-size:16px;
        font-weight:bold;
        color:#000;
        margin-bottom:10px;
		font-family:sans-serif;
    }

    .title{
        font-size:14px;
        font-weight:bold;
        color:#000;
        display:block;
    }
	
	.table-custm{
		 width: 100%;
        max-width: 100%;
        margin-bottom: 15px;
        border-collapse: collapse;
        font-size:15px;
        font-family:sans-serif;
        font-weight:normal;
	}
	
	 .table-custm>tbody>tr>td{
        padding: 5px;
        line-height: 1.42857143;
		border-collapse:collapse;
    }

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 15px;
        border-collapse: collapse;
        font-size:11px;
        font-family:sans-serif;
        font-weight:normal;
    }

    .table>thead>tr>th {
        vertical-align: top;
        background:#fff;
        color:#000;
    }

    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        padding: 5px;
        line-height: 1.42857143;
    }



    a{
        color:#000;
        text-decoration:underline;
    }
    p{
        margin:0;
        padding:0;
        line-height:20px;
    }

  

    .list-unstyled {
        padding-left: 0;
        list-style: none;
    }


    .invoice-to li{
        margin-bottom: 6px;

        float: left;
        width: 100%;
    }

    .invoice-to li:last-child{
        margin-bottom: 0;
    }

   
.gap-list{
margin-bottom:6px;
float:left;	
width:100%;
clear:both;
}

    .left-blk{
        float:left;
        width:100px;
        margin-right:20px;
        display:inline-block;
        font-weight:bold;
		line-height:24px;
    }

    .rght-blk{
        float:left;
        width:200px;
        margin-right:20px;
        display:inline-block;
		line-height:24px;
    }




    .container {
        width:100%;
        float: left;
    }
    ul , ul > li {
        list-style: none;
    }
	* {
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
}
    .col-md-6{
        float: left;
		padding:15px;
        width: 400px;
    }





    .clearfix:before,
    .clearfix:after{
        display: table;
        content: " ";
    }
    .clearfix:after{
        clear:both;
    }
	td p{
	float:left;
	width:100%;
	position:relative;
	display:block;
	}
	td  span{
	width:50%;	
	display:inline-block;
	padding:5px;
	}

         td span.lft{
             width:25%;
         }
         td span.lft_2{
             width:25%;
         }
         td span.rght{
             width:75%;
         }
		 .border_lagade{
			 border-collapse: collapse;
			 }
			 
			.page_break{page-break-after: always;}
            .page_margin{
                padding-left: 30px;;
            }
		
</style>
</head>
   @php
   $total_count=count($pages_data);
   $row_count=0;
   @endphp
<body style="border-left:#00B050 17px solid;">

   @foreach($pages_data as $key=>  $page_row)
   @php
   $row_count++;
   @endphp
  <div class="page_margin" style="margin-top: 120px;">
   {!!$page_row!!}
   @if($row_count!=$total_count)
   <div class="page_break"></div>
   @endif;
  </div>
  @endforeach
</body>
</html>