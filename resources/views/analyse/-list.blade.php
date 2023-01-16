@extends('layouts.app')

@section('content')
  <div id="medicaments">
    <div id="mediclist"></div>
    <div id="medicsingle"></div>
  </div>
@endsection

@section('js')
<script>
  $(document).ready(async function(){
      $link = 'https://medicament.ma/listing-des-medicaments/page/2/?lettre=A';
      $page = 2;

      await loadmedic($page, function(){

      });


  });

  async function loadmedic(p, clback){
    $('#medicsingle').load('https://medicament.ma/listing-des-medicaments/page/'+p+'/?lettre=A #wrapper', clback);
  }

////////////////////////////////////////////////////////

var myScript = window.document.createElement('script');
myScript.type = 'text/javascript';
myScript.setAttribute('src','http://localhost/cabgest/assets/libs/jquery/jquery-3.6.1.min.js');
window.document.getElementsByTagName('head')[0].appendChild(myScript);


async function loadmedic(){
	$('.listing').html('');
  $('.listing').load('https://medicament.ma/listing-des-medicaments/page/'+page+'/?lettre='+lettre+' .listing',null, async function( response, status, xhr ){

		$('.listing tbody tr').each(function(k, a){
			console.log($('.listing tbody tr').length);
			//$('#newsletter-email-collector').append( $(a).find('a').text() );
				var aa = $(a).find('a');

				href = $(aa).attr('href')
				price = $(aa).find('.small').text();
				$(aa).find('.small').remove();
				name = $(aa).find('.details').text().trim();

				$data.push({
					name: name,
					price: price,
					href: href,
				});
		});
	});	
};

$('#newsletter-email-collector').html('');

lastpage = $('.listing .pagination li:last a').attr('href');
lastpage = lastpage.replace('https://medicament.ma/listing-des-medicaments/page/', '');
lastpage = parseInt( lastpage.split('/')[0] );

page = 1;
lettre = 'B';

$data = [];

setInterval(async () => {
	if( page <= lastpage ){
		await loadmedic(); 
		page += 1;
	}else{
		$kk = "";
		for( d in $data ){
			$kk += `INSERT INTO medicaments (code,nom,href) VALUES ("${ $data[d].name }", "${ $data[d].price }", "${ $data[d].href }"); \n`;
		}
		$('.listing').html('<textarea>'+ $kk +'</textarea>');
	}
}, 2500);


</script>


@endsection














