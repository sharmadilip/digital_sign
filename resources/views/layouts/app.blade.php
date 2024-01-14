<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Invoice') }}</title>
        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('black') }}/img/apple-icon.png">
        <link rel="icon" type="image/png" href="{{ asset('black') }}/img/favicon.png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('black') }}/css/nucleo-icons.css" rel="stylesheet" />
        <!-- CSS -->
        <link href="{{ asset('black') }}/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
        <link href="{{ asset('black') }}/css/theme.css" rel="stylesheet" />
        <script src="https://cdn.tiny.cloud/1/mqnl2ghcf1w62y6cid79j87s8aifeyl1gznntkihemzrklix/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        
        
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <div class="wrapper">
                    @include('layouts.navbars.sidebar')
                <div class="main-panel">
                    @include('layouts.navbars.navbar')

                    <div class="content">
                        @yield('content')
                    </div>

                    @include('layouts.footer')
                </div>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            @include('layouts.navbars.navbar')
            <div class="wrapper wrapper-full-page">
                <div class="full-page {{ $contentClass ?? '' }}">
                    <div class="content">
                        <div class="container">
                            @yield('content')
                        </div>
                    </div>
                    @include('layouts.footer')
                </div>
            </div>
        @endauth
       
        <script src="{{ asset('black') }}/js/core/jquery.min.js"></script>
        <script src="{{ asset('black') }}/js/core/popper.min.js"></script>
        <script src="{{ asset('black') }}/js/core/bootstrap.min.js"></script>
        <script src="{{ asset('black') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
       
        <!--  Google Maps Plugin    -->
        <!--  Notifications Plugin    -->
        <script src="{{ asset('black') }}/js/plugins/bootstrap-notify.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js" ></script>
        <script src="{{ asset('black') }}/js/black-dashboard.min.js?v=1.0.0"></script>
        <script src="{{ asset('black') }}/js/theme.js"></script>
        <script src="{{ asset('black') }}/js/bcPaint.js"></script>
        @stack('js')

        <script>
            $(document).ready(function() {
                $().ready(function() {
                    $sidebar = $('.sidebar');
                    $navbar = $('.navbar');
                    $main_panel = $('.main-panel');

                    $full_page = $('.full-page');

                    $sidebar_responsive = $('body > .navbar-collapse');
                    sidebar_mini_active = true;
                    white_color = false;

                    window_width = $(window).width();
                });
            });

            $(document).ready(function() {
    // Javascript method's body can be found in assets/js/demos.js
    function add_tinymic_data()
    {
        
    tinymce.init({
    selector: 'textarea[id^="tinymic_"]',
    plugins: 'anchor autolink charmap codesample code emoticons image link lists media searchreplace table visualblocks wordcount preview',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat | preview',
    tinycomments_mode: 'embedded',
    content_style: "body { font-family: 'Century Gothic'; }",
    font_family_formats: "Century Gothic=Century Gothic; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
    });
    }
    add_tinymic_data();
  
 //-------------add pdf by button---------------------
 $("#add_new_pdf_page").on("click",function(){
     //pdf_html_container
    var total_count= $("textarea[id^='tinymic_']").length;
    console.log(total_count);
    total_count++;
    $("#pdf_html_container").append('<div style="padding-top: 10px;"><strong><h2>Page '+total_count+'<h2></strong></div><textarea id="tinymic_'+total_count+'" name="pdf_page[]"></textarea>');
    tinymce.init({
    selector: '#tinymic_'+total_count+'',
    plugins: 'anchor autolink charmap codesample code emoticons image link lists media searchreplace table visualblocks wordcount preview',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat | preview',
    tinycomments_mode: 'embedded',
    content_style: "body { font-family: 'Century Gothic'; }",
    font_family_formats: "Century Gothic=Century Gothic; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
    });

    });

    $("#view_data_as_pdf").on('click',function(){

        $("#add_invoice_data").attr('action',"{{ route('pages.generatepdf') }}");
        $("#add_invoice_data").submit();
    })
    $("#save_template_to_db").on('click',function(){

     $("#add_invoice_data").attr('action',"{{ route('pages.savepdftemplate') }}");
     $("#add_invoice_data").submit();
        })
        $("body").on('click',"#delete_invoice_data",function(event){
          return confirm("Are you sure you want to delete?");
        })
//-----------template controller btn acttions------------------
$("body").on('click',"#delete_pdf_template_btn",function(){
   var template_id=$(this).data('id');
   if (confirm('Are you sure you want to delete this ?')) {


      $.ajax({
         headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
          'url':'{{route("pages.deletepdftemplate")}}',
          'data':{"template_id":template_id},
          'type': "POST",
          'dataType': 'json',
          success: function (data) {
   
          location.reload();
       
        },
        error: function (data) {
         
        }
        })
      }
});

//-------------------button for send to client invoice status change ---------------------

$("body").on('click',"#send_to_client_contract",function(){
   var template_id=$(this).data('id');
   
      $.ajax({
         headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
          'url':'{{route("pages.sendcontract")}}',
          'data':{"contact_id":template_id},
          'type': "POST",
          'dataType': 'json',
          success: function (data) {
           
            location.reload();
       
        },
        error: function (data) {
         
        }
        });
      
});

  });
        </script>
        @if(isset($pageSlug)&&$pageSlug=="pages.viewinvoice")

<script>
  $(document).ready(function($) {
    
    var canvas = document.getElementById("signature");
    var signaturePad = new SignaturePad(canvas);
    $("#clear_signature_pad").on("click",function(){
        signaturePad.clear();
    }) 
    $("#save_signature").on('click',function(){
        var data = signaturePad.toDataURL('image/png');
        if(data)
        {
         $('#signature_data_value').val(data);
         $('#paint_signature').modal('hide');
         $.ajax({
            'url':'{{route("pages.savesignaturedb")}}',
            'data': $('#signature_area_form').serialize(),
            'type': "POST",
          'dataType': 'json',
          success: function (data) {
     
            location.reload();
         
          },
          error: function (data) {
           
          }
         })
        }
    })
    //---------upload signature check-------------
    var imagebase64 = "";  
  
function encodeImageFileAsURL(element) {  
    var file = element.files[0];  
    var reader = new FileReader();  
    reader.onloadend = function() {  
        imagebase64 = reader.result;
        $('#display_signature').attr('src',imagebase64);  
    }  
    reader.readAsDataURL(file);  
}  
   
  $("#signature_input").on("change",function(event)
  {
    encodeImageFileAsURL(this);
    //$('#display_signature').attr('src',imagebase64);


  });

    $("#upload_your_signature").on('click',function(){
        var data = $('#display_signature').attr('src');
        if(data)
        {
         $('#signature_data_value').val(data);
         $('#upload_signature').modal('hide');
         $.ajax({
            'url':'{{route("pages.savesignaturedb")}}',
            'data': $('#signature_area_form').serialize(),
            'type': "POST",
          'dataType': 'json',
          success: function (data) {
     
            location.reload();
         
          },
          error: function (data) {
           
          }
         })
        }
    })

    //--------------approve contract by user------
    $("body").on("click","#approve_signature_digital",function(){
      var contract_id=$("#invoice_id").val();
      $.ajax({
        headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
            'url':'{{route("pages.approvecontract")}}',
            'type': "post",
            'data':{'contract_id':contract_id},
          'dataType': 'json',
          success: function (data) {
     
            location.reload();
         
          },
          error: function (data) {
           
          }
         })
    })

    var url = '{{$pdf_url}}';
    
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    var pdfDoc = null;
    var pdfDoc = null,
    pageNum = 1,
    pageRendering = false,
    pageNumPending = null,
    scale = IsMobile() ? 1 : 1.5;

function renderPage(num, canvas) {
  var ctx = canvas.getContext('2d');
  pageRendering = true;
  // Using promise to fetch the page
  pdfDoc.getPage(num).then(function(page) {
    var viewport = page.getViewport({scale: scale});
    canvas.height = viewport.height;
    canvas.width = viewport.width;

    // Render PDF page into canvas context
    var renderContext = {
      canvasContext: ctx,
      viewport: viewport
    };
    var renderTask = page.render(renderContext);

    // Wait for rendering to finish
    renderTask.promise.then(function() {
      pageRendering = false;
      if (pageNumPending !== null) {
        // New page rendering is pending
        renderPage(pageNumPending);
        pageNumPending = null;
      }
    });
  });
}

pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
  pdfDoc = pdfDoc_;

  const pages = parseInt(pdfDoc.numPages);

  var canvasHtml = '';
  for (var i = 0; i < pages; i++) {
  	canvasHtml += '<canvas id="canvas_' + i + '"></canvas>';
  }

  document.getElementById('pdf_viewer_canvas').innerHTML = canvasHtml;

  for (var i = 0; i < pages; i++) {
  	var canvas = document.getElementById('canvas_' + i);
  	renderPage(i+1, canvas);
  }
});

function IsMobile() {
        var r = new RegExp("Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini");
        return r.test(navigator.userAgent);
    }



  });
</script>
@endif
        @stack('js')
    </body>
</html>
