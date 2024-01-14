@include('emails.header') 
    <p>Beste,</p>
    <br>
    <p>Bijgaand de getekende overeenkomst welke is ondertekend naar door de klant {{ $mailData['client_name'] }}.</p>
    <p>Zodra deze is getekend ontvangt u hier nogmaals berichtgeving van.</p>
       
    <p>De geldigheidsduur van deze offerte bedraagt 30 dagen na offertedatum.</p>  
    @include('emails.footer')