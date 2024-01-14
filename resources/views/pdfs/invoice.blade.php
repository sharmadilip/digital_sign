<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
     <style type="text/css">

      /*-----------------include fonts --------------------------*/
      @font-face {
                font-family: 'Century Gothic';
                src: url({{ storage_path("fonts/static/gothic/GOTHICB.ttf") }}) format("truetype");
                font-weight: bold;
    
            }
    
            @font-face {
                font-family: 'Century Gothic';
                src: url({{ storage_path("fonts/static/gothic/GOTHICBI.ttf") }}) format("truetype");
                font-weight: bold;
                font-style: italic,oblique;
            }
    
    
            @font-face {
                font-family: 'Century Gothic';
                src: url({{ storage_path("fonts/static/gothic/CenturyGothic.ttf") }}) format("truetype");
                font-style: normal;
            }
    
    
            @font-face {
                font-family: 'Century Gothic';
                src: url({{ storage_path("fonts/static/gothic/GOTHICI.ttf") }}) format("truetype");
                font-style: italic;
            }


       html, body { display: block;
        font-family:'Century Gothic' !important;
        font-size:15px;
         font-weight:normal;
         margin: 0px;
         padding: 0px 20px 0px 0px;
    }
        
    

	.margin-div{ margin: 0%; padding: 0%; }
	.normal-txt{
		 font-size:15px;
        font-family:'Century Gothic';
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
		font-family:'Century Gothic';
    }

    .title{
        font-size:14px;
        font-weight:bold;
        color:#000;
        display:block;
    }
	table{
        border-collapse: collapse;
        border-spacing: 0px;
        font-family:'Century Gothic';
    }

    a{
        color:#000;
        text-decoration:underline;
    }
    p{ 
        font-size: 14px;
        margin:0;
        padding:0;
        line-height:16px;
    }
strong{ font-weight:bold !important;
    font-family:'Century Gothic';
}
span {
    font-family:'Century Gothic';  
}

    ul , ul > li {
        list-style: none;
        font-family:'Century Gothic';  
    }
	
    .clearfix:before,
    .clearfix:after{
        display: table;
        content: " ";
    }
    .clearfix:after{
        clear:both;
    }
    
     .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 15px;
        border-collapse: collapse;
        font-size:11px;
        font-family:'Century Gothic';
        font-weight:normal;
        border: 0px;
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
    
			.page_break{page-break-after: always;}
            .page_margin{
                padding-left: 30px;;
            }
            .pagenum:before {
        content: counter(page);
          }
          footer{
            position: fixed; 
                bottom: 15px; 
                left: 0px; 
                right: 0px;
                height: 30px; 
                color: rgb(22, 22, 22);
                text-align: center;
                line-height: 35px;
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
  <div class="page_margin" style="margin-top: 100px;">
    @if(isset($replace_keywords))
   @foreach($replace_keywords as $r_key=>$value)
    @php
    $page_row= str_replace($r_key,$value,$page_row);
    @endphp
    @endforeach
    {!!$page_row!!}
    @else
    {!!$page_row!!}
    @endif
    <footer><span class="pagenum"></span></footer>
  
   @if($row_count!=$total_count)
   <div class="page_break"></div>
   @endif
  </div>
  @endforeach
</body>
</html>