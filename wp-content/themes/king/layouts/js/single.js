html2element:(function($){'use strict';$(document).ready(function(){$(".floating-video").stick_in_parent({offset_top:-600})
$(".king-gallery-01").owlCarousel({nav:!0,margin:0,center:!0,stagePadding:0,items:1,autoHeight:!0,navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>']});$(".king-gallery-04").owlCarousel({nav:!0,margin:0,center:!0,stagePadding:0,margin:10,loop:false,autoWidth:true,navText:['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>']});$(".king-gallery-images").owlCarousel({items:1,loop:!1,center:!0,autoHeight:!0,margin:0,dots:!1,URLhashListener:!0,autoplayHoverPause:!0,startPosition:"URLHash"});$('.iframe-link').magnificPopup({type:'iframe'});var ias=$.ias({container:"ol.comment-list",item:"li.comment.depth-1",pagination:".comments-area .nav-links",next:".comments-area .nav-previous a"});$('.king-like').on('click',function(b){b.preventDefault();var c=$(this);var id=c.data('id');var n=c.data('nonce');$.ajax({type:'POST',url:singlejs.ajaxurl,data:{action:'king_favorite_ajax',id:id,nonce:n},beforeSend:function(){c.addClass('effect');},success:function(f){if('1'===f){c.find('.fa-heart').removeClass('far').addClass('fas');c.addClass('added');}else{c.find('.fa-heart').removeClass('fas').addClass('far');c.removeClass('added');}
setTimeout(function(){c.removeClass('effect');},700);},});});$('.king-flag').on('click',function(b){b.preventDefault();var cs=$(this);var id=cs.data('id');var ty=cs.data('type');var dis=cs.data('ds');var n=cs.data('nonce');$.ajax({type:'POST',url:singlejs.ajaxurl,data:{action:'king_flag_ajax',id:id,ty:ty,ds:dis,nonce:n},beforeSend:function(){cs.addClass('effect');},success:function(f){if('1'===f){cs.addClass('flagged');}else{cs.removeClass('flagged');}
setTimeout(function(){cs.removeClass('effect');},700);},});});$(document).on("click",".king-reactions-icon",function(d){d.preventDefault();var a=$(this).parent().parent(),c=$(this).data("action");d=a.data("voted");var e=a.data("logged"),f=localStorage.getItem("king_reaction");"disabled"===d?$(".king-reactions-post-"+a.data("post")).find("#king-reacted").removeClass("hide"):a.hasClass("disabled")||("not_logged"===e&&f=="reaction-"+a.data("post")?b(".king-reactions-post-"+a.data("post")).find("#king-reacted").removeClass("hide"):$.ajax({url:singlejs.ajaxurl,dataType:"json",type:"POST",data:{action:"king_reactions_box",nonce:a.data("nonce"),type:c,post:a.data("post")},success:function(d){$(".king-reactions-post-"+a.data("post")).find(".king-reactions-icon").each(function(){var f=$(this).data("action"),g=$(this).data("new");"not_logged"===e&&localStorage.setItem("king_reaction","reaction-"+a.data("post"));$(".king-reactions-post-"+a.data("post")).addClass("disabled");$(".king-reactions-post-"+a.data("post")).find(".king-reactions-count-"+c).html(d.reactions);$(".king-reactions-post-"+a.data("post")).find(".king-reaction-percent-"+f).height(g+"%");$(".king-reactions-post-"+a.data("post")).find(".king-reaction-percent-"+c).height(d.new_reactions+"%")})}}))});var myFunction=function(b){b.preventDefault();b=$(this).val();var c={action:'king_gifs',keyword:b};$.ajax({type:'POST',url:singlejs.ajaxurl,data:c,beforeSend:function(){$('#kingif-results').html('<div class="loader"></div>');},success:function(b){$('#kingif-results').html(b);$(".king-gif").on('click',function(){var cntrl=$(this).html();var val=$(this).data('embed');$("#comment").val(val);$('.comment-form-comment').hide();$('.show-gif').html(cntrl);$('.show-gif').append('<span class="hide-gif"><i class="fas fa-times"></i></span>');});$(".show-gif").on('click','.hide-gif',function(){$("#comment").val('');$('.comment-form-comment').show();$('.show-gif').html('');});},});}
$('.king-gif-toggle').on('click',myFunction);$('#king-gifs').on('keyup',myFunction);$('#commentform').on('submit',function(){var button=$('#submit'),respond=$('#respond'),commentlist=$('.comment-list'),commenterror=$('.comment-error'),comment=$('#comment'),email=$('#email'),cancelreplylink=$('#cancel-comment-reply-link');if(comment.val().length<3){comment.addClass('error');return false}else{comment.removeClass('error');}
if(!button.hasClass('loadingform')&&!$('#author').hasClass('error')&&!$('#email').hasClass('error')&&!$('#comment').hasClass('error')){$.ajax({type:'POST',url:singlejs.ajaxurl,data:$(this).serialize()+'&action=king_submit_ajax_comment',beforeSend:function(xhr){button.addClass('loadingform').val('...');button.prop('disabled',true);},error:function(request,status,error){if(status==500){var error='Error while adding comment';}else if(status=='timeout'){var error='Error: Server doesn\'t respond.';}else{var error=request.responseText;}
if(error){commenterror.html(error);commenterror.show();}},success:function(addedCommentHTML){if(commentlist.length>0){if(respond.parent().hasClass('comment')){if(respond.parent().children('.children').length){respond.parent().children('.children').append(addedCommentHTML);}else{addedCommentHTML='<ol class="children">'+addedCommentHTML+'</ol>';respond.parent().append(addedCommentHTML);}
cancelreplylink.trigger("click");}else{commentlist.prepend(addedCommentHTML);}}else{addedCommentHTML='<ol class="comment-list">'+addedCommentHTML+'</ol>';respond.after($(addedCommentHTML));}
comment.val('');$('.comment-form-comment').show();$('.show-gif').html('');commenterror.hide();},complete:function(){button.prop('disabled',false);$('input[name="acf[field_5c9bee01a519a]"]').prop('checked',false);$('.acf-input label').removeClass('selected');button.removeClass('loadingform').val('Post Comment');}});}
return false;});$(".king-emj-toggle").on('click',function(){$.ajax({url:singlejs.ajaxurl,data:{action:'king_emoji'},beforeSend:function(){$('.king-emj').html('<div class="loader"></div>');},success:function(b){$('.king-emj').html(b);$(".emojis").on('click',function(){var cntrl=$(this).attr("data-emj");$("#comment").val(function(_,val){return val+cntrl;});});},});});$('.king-emj').click(function(e){e.stopPropagation();});$(document).on('click','.king-poll-answer',function(d){d.preventDefault();var t=$(this);var ul=t.parent().parent();var pid=ul.data('postid');var p=ul.data('parent');var n=ul.data('nonce');var tot=ul.data('total');var c=t.data('child');var vtd=t.data('voted');$.ajax({type:'POST',url:singlejs.ajaxurl,dataType:'json',data:{action:'king_poll_answer',nonce:n,postid:pid,parent:p,child:c,},success:function(data){console.log(data.success);if(true===data.success){ul.addClass('voted');t.data('voted',vtd+1);ul.find('.quiz-share').show();ul.find('li').each(function(){var current=$(this);var vot=current.data('voted');var perc=Math.round(100*vot/(tot+1));current.find('.king-poll-result').css({'width':perc+'%','height':perc+'%'});current.find('.poll-result-voted').html(vot);current.find('.poll-result-percent').html(perc+'%');});}}});});$(document).on('click','.king-quiz-answer',function(d){d.preventDefault();var t=$(this);var ul=t.parent().parent();var inp=t.find('input[name="king_quiz"]').val();var pid=ul.data('postid');var p=ul.data('parent');var n=ul.data('nonce');var vt=ul.data('voted');var result=$('.king-quiz-result');if(0===vt){ul.addClass('voted');if('1'===inp){t.addClass('correct');}else{t.addClass('not-correct');}
var idd=+ul.attr('id')+1;if(document.getElementById(idd)){var position=$('#'+idd).offset().top;$("body, html").delay(500).animate({scrollTop:(position-80)});}}
ul.data('voted',1);if($('.king-poll.voted').length==p){var c=$('.king-quiz-answer.correct').length;var position=$('.king-quiz-result').offset().top;$("body, html").delay(500).animate({scrollTop:(position-80)});$.ajax({url:singlejs.ajaxurl,dataType:'json',type:'POST',data:{action:'king_quiz_answer',nonce:n,postid:pid,total:p,correct:c,},beforeSend:function(){result.html('<div class="quiz-result"><div class="loader"></div></div>');},success:function(f){result.html(f.cont);}});}});var b=singlejs.second,d=setInterval(function(){b--;if(0<b){var c="You can skip ad in "+b+"s";$("#notice").text(c)}else $("#notice").hide(),$("#hidead").show(),clearInterval(d)},1E3);$("#hidead").click(function(){$(".king-loading-ad").hide()});const parent=document.getElementById("creact");let rb=null;parent.onclick=(e)=>{rb=e.target;if(rb.type==="radio"){if(parent.rb===rb){rb.checked=false;parent.rb=null;}else{parent.rb=rb;}}};});})(jQuery);