$(function(){


// AJAX TWEET QUERY :

var _btnSearch = $('#btnSearch');
var _hashSearch = $('#hashSearch');

// Evt click search
_btnSearch.click(function(){
	SubmitRequest();
});

_hashSearch.keydown(function(e)
{ 
	if(e.keyCode == 13)
	{
		_btnSearch.click();
	}
});

}); // FIN $



function SubmitRequest(){
	// params :
	var errors = {};
	var params = {};
	
	 hashtag = $('#hashSearch').val();
 	_list = $('#list_result');
	
	// Hashtag empty ?
	console.log(hashtag);
	if(hashtag === undefined){
		alert('Pas de Hashtag? :O');
		return false;
	}

	params.action = 'getPixByHashtag';
	params.hashtag = hashtag;
	// params.count = 20 // @change !

	_list.fadeOut(
			'fast',
			function(){ 
				$(this).empty();
				// launch loader :
				$('#loader').show();
			});

	//getTweets
	getTweets(params);
	
	
	
	
	// jQuery Events :
	//$('#response').on('mouseenter','.item_result',function(){ $(this).children('.links').slideDown('800'); });
	//$('#response').on('mouseleave','.item_result',function(){ $(this).children('.links').slideUp('800'); });
	
	
	//Delete tweet and get new one :
	$('body').on('click','.close_item',function(){
		$(this).parent('li').animate(
			{
				"opacity" : 0
			},
			'slow',
			function(){
				  $(this).hide('slow');
				  
			});
			//getTweets
			  var params = {};
			  params.action = 'getPixByHashtag';
			  params.hashtag = hashtag;
			  params.count = 1;
			  getTweets(params);
	});
	
}


/**
 *  Function to send an Ajax request to get tweets
 *  @Params : Js Object 
 * */
function getTweets(params){
	
	
	// Ajax :
	$.post(
		'incs/functions.php', 
		params,
		function (data){ //fn success
			$('#loader').hide();
			// HTML
			
			
					data = JSON.parse(data);
					if(data.result !== ''){
						var result = data.result;
						for(i in result){
							var _item = '<li id="id_item_result_' + i + '" class="item_result"><img src="" class="img_item_result"/><span class="close_item">X</span>'
											+ '<div class="title_item_result">'+result[i].txt+'</div>'
											
											
											+ '<!-- <div class="title_item_result" >'+result[i].urls[0].expanded_url+'</div> -->';	
												
											// Display links ?	
											if(result[i].urls !== ''){
												_item += '<div class="links" style="display:none">'
														+'<ul>';
															for(var z in result[i].urls){
																
																_item += '<li> <a target="_blank" href="'+result[i].urls[z].expanded_url+'">'+result[i].urls[z].expanded_url+'</a></li>';
																
															}
															
														_item += '</ul>'
												+ '</div>';
											}
											_item += '<input type="hidden" name="favorites_count_' + i + '" value='+ result[i].favoris +' />'
											
											+ '<input type="hidden" name="retweet_count_' + i + '" value='+ result[i].retweet +' />';
											
											
								_list.append(_item);			
							
						}
						
						if(params.count == 1){
							_list.animate({ "opacity": 1 }, 'fast');
						}
						else{
							_list.fadeIn();
						}
			
				}
		}
	); // FIN AJAX
	
	
}
