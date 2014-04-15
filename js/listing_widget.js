var jase = [{"campaignid":"25","campaign":"Summer 2014 Default Tour","artistid":"19","artist":"Django Django","eventdate":"2014-03-14","venue":"100 Club","location":"London","country":"GB","postzip":"WC1N 1PQ","lattitude":"29.102392","longitude":"12.1202","ticketoutlet":null,"buylink":null},{"campaignid":"25","campaign":"Summer 2014 Default Tour","artistid":"19","artist":"Django Django","eventdate":"2014-04-01","venue":"O2 Academy Bristol","location":"Bristol","country":"GB","postzip":"BS1 5NA","lattitude":"51.454133","longitude":"-2.600836","ticketoutlet":"See Tickets","buylink":"http://www.seetickets.com/music-tickets?afflink=EISEEXX"},{"campaignid":"25","campaign":"Summer 2014 Default Tour","artistid":"19","artist":"Django Django","eventdate":"2014-04-16","venue":"Magazzini Generali","location":"Milan","country":"IT","postzip":"20141","lattitude":"45.4441264","longitude":"9.1950121","ticketoutlet":"Music Glue","buylink":null},{"campaignid":"25","campaign":"Summer 2014 Default Tour","artistid":"19","artist":"Django Django","eventdate":"2014-04-21","venue":"Gasometer","location":"Vienna","country":"AT","postzip":"1110","lattitude":"48.1853902","longitude":"16.4191106","ticketoutlet":"See Tickets","buylink":"http://www.seetickets.com/music-tickets?afflink=EISEEXX"}];
console.log(jase);
function formatDate (input) {
		  var datePart = input.match(/\d+/g),
		  year = datePart[0], // get only two digits
		  month = datePart[1], day = datePart[2];
		  return day+'/'+month+'/'+year;
		}
if (typeof jQuery === "undefined") {
    var script = document.createElement('script');
    script.src = 'http://code.jquery.com/jquery-latest.min.js';
    script.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(script);
}
// document.onreadystatechange = function(e)
// {
//     if (document.readyState === 'complete')
//     {
//   	var load = '<img src="http://www.biota-labs.com/ei/sales/img/loading.gif" alt="Loading">';
// 	$(".listing-widget-initializer").html( load );
//     }
// };
//window.onload = function() {
document.ready = function() {
	$(".listing-widget-initializer").each(function(){
		   var getParams = "";
		   var artistid = $(this).attr('artistid');
		   var tourid = $(this).attr('tourid');
		   if (tourid && !artistid) {
		   		getParams = "tourid="+tourid;
		   } else if (artistid && !tourid) {
		   		getParams = "artistid="+artistid;
		   } else {
		   	getParams = "artistid="+artistid+"&tourid="+tourid;
		   }

		$.getJSON('http://www.biota-labs.com/ei/sales/ei_tour_details.php?'+getParams, function(data) {
		//	$.getJSON(jase, function(data) {
		      var table='<table style="width: 100%; margin-bottom: 20px;"><thead style="border-bottom: 1px solid #999999; padding-bottom: 10px;"><tr style="font-weight: bold;" align="left"><th>Artist</th><th>Date</th><th>Venue</th><th>Location</th><th>Buy</th></tr></thead><tbody align="left">';
		      if (data == '') {
		      	table = "<h4><strong>No dates associated with this campaign/artist</strong><h4>";
		      }
		      $.each( data, function( index, item){
		            /* add to html string started above*/
		            var link = '';
		            if (item.buylink) { link='<a href="'+item.buylink+'">Buy Tickets</a>';
					} else { link = ''; }
					var date = formatDate(item.eventdate);
			 table+='<tr><td>'+item.artist+'</td><td>'+date+'</td><td>'+item.venue+'</td><td>'+item.location+'</td><td>'+link+'</td></tr>';       
		      });
		      table+='</tbody></table>';
		      console.log(table);
		      $(".listing-widget-initializer").html( table );		
		});
	});
}