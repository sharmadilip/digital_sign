@extends('layouts.app', ['activePage' => 'addtemplate', 'titlePage' => __('PDF page'),'pageSlug' => 'addtemplate'])


@section('content')
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header">
<h5 class="title">Edit Profile</h5>
</div>
<form method="post" name="add_pdf_data" id="add_invoice_data" action="{{ route('pages.savepdftemplate') }}">
<div class="card-body" id="pdf_html_container"> 
@method('post')

@include('alerts.success')
<div><strong><h2>Page 1<h2></strong></div>
<textarea id="tinymic_1" name="pdf_page[]">

</textarea>     
<div><strong><h2>Page 2<h2></strong></div>
<textarea id="tinymic_2" name="pdf_page[]">
<div class="heading">Verwerkersovereenkomst: Algemene Verordening Gegevensbescherming</div>
<p><strong>Partijen:</strong></p>
<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; I. <strong>Klantnaam</strong>, kantoorhoudende aan Adresgegevens <strong>klant</strong>, &ldquo;Verwerkingsverantwoordelijke&rdquo;;</p>
<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; II. Money Management B.V., kantoorhoudende aan Herengracht 449a, 1017 BR te Amsterdam,</p>
<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &ldquo;Verwerker&rdquo;.</p>
<p>&nbsp;<strong>Overwegingen:</strong></p>
<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <strong>&nbsp;A</strong>. Verwerkingsverantwoordelijke en Verwerker zijn een overeenkomst aangegaan voor het verrichten</p>
<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;van de volgende diensten:&nbsp;&nbsp;</p>
<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - incassodienstverlening</p>
<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- juridische dienstverlening.</p>
<p>&nbsp;</p>
<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Deze overeenkomst leidt ertoe dat Verwerker in opdracht van</p>
<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Verwerkingsverantwoordelijke persoonsgegevens verwerkt.</p>
<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <strong>B</strong>. In deze overeenkomst leggen Verwerkingsverantwoordelijke en Verwerker wederzijdse rechten en</p>
<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;plichten vast voor de verwerking&nbsp; van&nbsp;persoonsgegevens, dit overeenkomstig met</p>
<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;de toepasselijke Privacywetgeving</p>
<p>&nbsp;</p>
<p>&nbsp;<strong> &nbsp;1. Partijen zijn overeengekomen: </strong></p>
<p>&nbsp;</p>
<p><strong>1.1. Begrippen: </strong></p>
<p><strong>AVG:</strong>&nbsp;Verordening (EU) 2016/679 van het Europees Parlement en de Raad van 27 april 2016 betreffende de bescherming van natuurlijke personen in verband met de verwerking van persoonsgegevens en betreffende het vrije verkeer van die gegevens en tot intrekking van Richtlijn 95/46/EG (Algemene Verordening Gegevensbescherming);</p>
<p><strong>Betrokkene:</strong> Persoon op wie de persoonsgegevens betrekking heeft;</p>
<p><strong>Onderliggende overeenkomst:</strong> Getekende overeenkomst/offerte waarbij Verwerkingsverantwoordelijke aan Verwerker de opdracht heeft gegeven om financi&euml;le dienstverlening te leveren;</p>
<p><strong>Overeenkomst:</strong> Deze verwerkersovereenkomst inclusief bijlagen;</p>
<p><strong>Persoonsgegevens: </strong>Alle informatie over ge&iuml;dentificeerde of identificeerbare natuurlijke persoon die Verwerker op grond van Onderliggende overeenkomst verwerkt of dient te verwerken;</p>
<p><strong>Uitvoeringswet AVG:</strong> Uitvoeringsregels van Verordening (EU) 2016/679 van het Europees Parlement en de Raad van 27 april 2016 betreffende de bescherming van natuurlijke personen met betrekking tot de verwerking van persoonsgegevens en het vrije verkeer van dergelijke gegevens, en tot intrekking van Richtlijn 95/46/EG (algemene verordening gegevensbescherming) (PbEU 2016, L 119) (Uitvoeringswet Algemene Verordening Gegevensbescherming).&nbsp;</p>
</textarea>

<div><strong><h2>Page 3 Content here<h2></strong></div>
<textarea id="tinymic_3" name="pdf_page[]">
<p><strong>2. Toepasselijkheid</strong></p>
<p><strong>2.1.</strong>&nbsp;Tenzij anders schriftelijk overeengekomen, zijn de bepalingen van deze Overeenkomst van toepassing op iedere verwerking door Verwerker op grond van de Onderliggende Overeenkomst.</p>
<p>&nbsp;</p>
<p><strong>3. Verwerking door Verwerker</strong></p>
<p>&nbsp;</p>
<p><strong>3.1.</strong> Verwerker verwerkt Persoonsgegevens ten behoeve van Verwerkingsverantwoordelijke, onder de verantwoordelijkheid van Verwerkingsverantwoordelijke en op de wijze vastgelegd in de Onderliggende Overeenkomst.</p>
<p><strong>3.2.</strong>&nbsp;Verwerker verwerkt de Persoonsgegevens slechts in opdracht van Verwerkingsverantwoordelijke. .3.&nbsp;De Verwerker heeft geen controle over het doel en de methoden van de Persoonsgegevensverwerking en heeft geen invloed op beslissingen betreffende het gebruik van Persoonsgegevens, de overdracht aan derden, en de duur van Persoonsgegevensopslag.</p>
<p><strong>3.4.</strong> In&nbsp;geval een instructie van de Verwerkingsverantwoordelijke naar het redelijk oordeel van de Verwerker in strijd is met de geldende Privacywetgeving, dient de Verwerker onmiddellijk schriftelijk de Verwerkingsverantwoordelijke op de hoogte te stellen.</p>
<p><strong>3.5.</strong> Op&nbsp;verzoek van de Verwerkingsverantwoordelijke zal de Verwerker alle noodzakelijke informatie verstrekken om de naleving van de verplichtingen in deze Overeenkomst aan te tonen.</p>
<p><strong>3.6.</strong>&nbsp;Het is de verantwoordelijkheid van de Verwerker om te zorgen voor naleving van de voorwaarden van de toepasselijke Privacywetgeving met betrekking tot Persoonsgegevensverwerking.</p>
<p><strong>3.7.</strong>&nbsp;De Verwerker verleent toegang tot Persoonsgegevens aan haar werknemers, voor zover dit vereist is voor het leveren van diensten volgens de Onderliggende Overeenkomst.</p>
<p><strong>3.8.</strong>&nbsp;Zonder voorafgaande schriftelijke toestemming van de Verwerkingsverantwoordelijke mag de Verwerker Persoonsgegevens buiten Nederland niet verwerken.</p>
<p><strong>3.9.</strong>&nbsp;De Verwerker zal Persoonsgegevens niet langer verwerken dan noodzakelijk voor de specifieke doeleinden, tenzij expliciet schriftelijk opgedragen door de Verwerkingsverantwoordelijke.</p>
<p>&nbsp;</p>
<p><strong>4. Overdracht van Persoonsgegevens aan derde partijen</strong></p>
<p><strong>4.1.</strong>&nbsp;De Verwerker zal Persoonsgegevens niet verstrekken aan of delen met derden, tenzij expliciet schriftelijk opgedragen door de Verwerkingsverantwoordelijke of in opdracht van een gerechtelijke of administratieve instantie. In dit geval dient de Verwerker de Verwerkingsverantwoordelijke binnen 24 uur na ontvangst van een dergelijk bevel op de hoogte te stellen om de Verwerkingsverantwoordelijke de kans te geven passende juridische stappen te ondernemen.</p>
<p><strong>4.2.</strong>&nbsp;Als de Verwerker van mening is dat zij wettelijk verplicht is Persoonsgegevens aan een bevoegde instantie te verstrekken, zal zij dit pas doen na overleg met en goedkeuring van de Verwerkingsverantwoordelijke. De Verwerker zal de Verwerkingsverantwoordelijke schriftelijk informeren over de wettelijke verplichting en alle relevante informatie verstrekken om de juiste maatregelen te bepalen.</p>
</textarea>


</div>
<div class="card-footer"><button type="submit" class="btn btn-fill btn-primary">Save Template</button><button type="button" class="btn btn-fill btn-primary" id="add_new_pdf_page">Add Page</button><button type="button" id="view_data_as_pdf" class="btn btn-fill btn-primary">View as pdf</button>
{{ csrf_field() }}
</div>

</form>
</div>
</div>
</div>
@endsection

