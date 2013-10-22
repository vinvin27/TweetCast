$(function(){


	// AJAX TWEET QUERY :

	var _btnSearch = $('#btnSearch');
	var _hashSearch = $('#hashSearch');

	_list = $('#list_result');
	
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

	// Lightbox :
	$('#more_options').click(function(){
		$('#lightbox').fadeIn();
	});

	$('#lbc_close').click(function(){
		closeLightbox();
	});

}); // FIN $

// lightbox submit form 
function lbx_opts(form){
	var form = form;
	console.info(form);
	
	var nb_tweets = form.opt_nb_tweets.value;
	var isGeoloc = form.opt_twt_geoloc.checked;
	
	var params = {};
	
	hashtag = $('#hashSearch').val();
	
	params.action = 'getUrlByHashtag';
	params.hashtag = hashtag;
	params.count = nb_tweets;
	params.isGeoloc = isGeoloc;
	
	getTweets(params);
	
	return false;
}

function closeLightbox(){
	$('#lightbox').fadeOut();
}

function SubmitRequest(){
	// params :
	var errors = {};
	var params = {};
	
	 hashtag = $('#hashSearch').val();
	//_list = $('#list_result');
	
	// Hashtag empty ?
	console.log(hashtag);
	if(hashtag === undefined){
		alert('Pas de Hashtag? :O');
		return false;
	}

	params.action = 'getUrlByHashtag';
	params.hashtag = hashtag;
	// params.count = 20 // @change !

	
	//getTweets
	getTweets(params);
	
		
	// jQuery Events :
	$('#response').on('mouseenter','.item_result',function(){ $(this).children('.links').slideDown('800'); });
	$('#response').on('mouseleave','.item_result',function(){ $(this).children('.links').slideUp('800'); });
	
	
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
			
			// Loader :
			$('.item_result.item_loader').show();
			
			//getTweets
			  var params = {};
			  params.action = 'getUrlByHashtag';
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
	
	// Remove old tweets 
	_list.fadeOut(
			'fast',
			function(){ 
				$(this).children('.item').remove();
				// launch loader :
				$('#loader').show();
			});
			
	// Ajax :
	$.post(
		'incs/functions.php', 
		params,
		function (data){ //fn success
			$('#loader').hide();
			$('.item_result.item_loader').hide();
			data = JSON.parse(data);
			if(data.result !== ''){
				var result = data.result;
				for(i in result){
					var _item = '<li id="id_item_result_' + i + '" class="item_result item"><img src="" class="img_item_result"/><span class="close_item">X</span>'
								+ '<div class="title_item_result">'+result[i].txt+'</div>'
								
								// Display links ?	
								if(result[i].urls !== ''){
									_item += '<div class="links" style="display:none">'
													+'<ul>';
													for(var z in result[i].urls){
														var href = (result[i].urls[z].expanded_url==undefined?result[i].urls[z].url:result[i].urls[z].expanded_url);
														_item += '<li> <a target="_blank" href="'+href+'">'+href+'</a></li>';
													}
													_item += '</ul>'
											+ '</div>';
								}
								_item += '<input type="hidden" name="favorites_count_' + i + '" value='+ result[i].favoris +' />'
										+ '<input type="hidden" name="retweet_count_' + i + '" value='+ result[i].retweet +' />';
								
									
						$('.item_result.item_loader').before(_item);			
					
				}
				// if new one tweet
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
