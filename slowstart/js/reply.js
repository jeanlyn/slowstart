/**
 * @ 回复
 * @param authorId		评论者 ID
 * @param commentId		评论 ID
 * @param commentBox	评论输入框 ID
 */
(function(a,b){var c=a(b);a.fn.lazyload=function(d){function h(){var b=0;e.each(function(){var c=a(this);if(g.skip_invisible&&!c.is(":visible"))return;if(!a.abovethetop(this,g)&&!a.leftofbegin(this,g))if(!a.belowthefold(this,g)&&!a.rightoffold(this,g))c.trigger("appear");else if(++b>g.failure_limit)return!1})}var e=this,f,g={threshold:0,failure_limit:0,event:"scroll",effect:"show",container:b,data_attribute:"original",skip_invisible:!0,appear:null,load:null};return d&&(undefined!==d.failurelimit&&(d.failure_limit=d.failurelimit,delete d.failurelimit),undefined!==d.effectspeed&&(d.effect_speed=d.effectspeed,delete d.effectspeed),a.extend(g,d)),f=g.container===undefined||g.container===b?c:a(g.container),0===g.event.indexOf("scroll")&&f.bind(g.event,function(a){return h()}),this.each(function(){var b=this,c=a(b);b.loaded=!1,c.one("appear",function(){if(!this.loaded){if(g.appear){var d=e.length;g.appear.call(b,d,g)}a("<img />").bind("load",function(){c.hide().attr("src",c.data(g.data_attribute))[g.effect](g.effect_speed),b.loaded=!0;var d=a.grep(e,function(a){return!a.loaded});e=a(d);if(g.load){var f=e.length;g.load.call(b,f,g)}}).attr("src",c.data(g.data_attribute))}}),0!==g.event.indexOf("scroll")&&c.bind(g.event,function(a){b.loaded||c.trigger("appear")})}),c.bind("resize",function(a){h()}),h(),this},a.belowthefold=function(d,e){var f;return e.container===undefined||e.container===b?f=c.height()+c.scrollTop():f=a(e.container).offset().top+a(e.container).height(),f<=a(d).offset().top-e.threshold},a.rightoffold=function(d,e){var f;return e.container===undefined||e.container===b?f=c.width()+c.scrollLeft():f=a(e.container).offset().left+a(e.container).width(),f<=a(d).offset().left-e.threshold},a.abovethetop=function(d,e){var f;return e.container===undefined||e.container===b?f=c.scrollTop():f=a(e.container).offset().top,f>=a(d).offset().top+e.threshold+a(d).height()},a.leftofbegin=function(d,e){var f;return e.container===undefined||e.container===b?f=c.scrollLeft():f=a(e.container).offset().left,f>=a(d).offset().left+e.threshold+a(d).width()},a.inviewport=function(b,c){return!a.rightofscreen(b,c)&&!a.leftofscreen(b,c)&&!a.belowthefold(b,c)&&!a.abovethetop(b,c)},a.extend(a.expr[":"],{"below-the-fold":function(b){return a.belowthefold(b,{threshold:0})},"above-the-top":function(b){return!a.belowthefold(b,{threshold:0})},"right-of-screen":function(b){return a.rightoffold(b,{threshold:0})},"left-of-screen":function(b){return!a.rightoffold(b,{threshold:0})},"in-viewport":function(b){return!a.inviewport(b,{threshold:0})},"above-the-fold":function(b){return!a.belowthefold(b,{threshold:0})},"right-of-fold":function(b){return a.rightoffold(b,{threshold:0})},"left-of-fold":function(b){return!a.rightoffold(b,{threshold:0})}})})(jQuery,window)
function reply(authorId, commentId, commentBox) {
	// 评论者名字
	var author = document.getElementById(authorId).innerHTML;
	// 拼接成 '@评论者名字' 链接
	var insertStr = '<a href="#' + commentId + '">@' + author.replace(/\t|\n/g, "") + '</a> \n';
 
	// 追加到评论输入框
	appendReply(insertStr, commentBox);
}

/**
 * 追加到输入框
 * @param insertStr		追加字符串
 * @param commentBox	评论输入框 ID
 */
function appendReply(insertStr, commentBox) {
	// 如果指定的输入框存在, 将它设为目标区域
	if(document.getElementById(commentBox) && document.getElementById(commentBox).type == 'textarea') {
		field = document.getElementById(commentBox);
	// 否则提示不能追加, 并退出操作
	} else {
		alert("The comment box does not exist!");
		return false;
	}
 
	// 如果一次评论中重复回复, 提示并退出操作
	if (field.value.indexOf(insertStr) > -1) {
		alert("You've already appended this reply!");
		return false;
	}
 
	// 如果输入框内无内容 (忽略空格, 跳格和换行), 将输入框内容设置为需要追加的字符串
	if (field.value.replace(/\s|\t|\n/g, "") == '') {
		field.value = insertStr;
	// 否则清除多余换行, 并将字符串追加到输入框中
	} else {
		field.value = field.value.replace(/[\n]*$/g, "") + '\n\n' + insertStr;
	}
 
	// 聚焦评论输入框
	field.focus();
}
/**/
$(function(){
	$('#comment').keypress(function(e){
        if(e.ctrlKey && e.which == 13 || e.which == 10) {
            jQuery("#commentform").submit();
        }
    })
})
		
/*悬浮效果*/
$(function(){
var id=/^#comment-/;
var at=/^@/;
jQuery('#thecomments li p a').each(function() {
	if(jQuery(this).attr('href').match(id)&& jQuery(this).text().match(at)) {
		jQuery(this).addClass('atreply');
	}
});
jQuery('.atreply').hover(function() {
	var target = this;
	var _commentId = jQuery(this).attr('href');	
	if(jQuery(_commentId).is('.comment_text')) {
		$('<div id="comment_tip" class="tip"></div>').html($(_commentId).parents('li').html()+'<div class="dot"></div>').appendTo($(this));
		//$('<div class="dot"></div>').appendTo($('#comment_tip'));
		jQuery('#thecomments .tip').css({
			top: 22,
			left: $(this).width()+80
		}).fadeIn();
	} else {
		var id = _commentId.slice(9);
		var dal=$(this);
		jQuery.ajax({
			type:         'GET'
			,url:         '?action=load_comment&id=' + id
			,cache:       false
			,dataType:    'html/text'
			,contentType: 'application/json; charset=utf-8' 
			,beforSend: function(){
				$('<div id="comment_tip" class="tip"></div>').html('<p>Loding......</p><div class="dot"></div>').appendTo(dal);
				jQuery('#thecomments .tip').css({
					top: 22,
					left: dal.width()+80
				}).fadeIn();
			} 
			,success: function(data){
				var addedComment = jQuery(data + '</li>');				
				jQuery('#comment_tip').html(data);
			}
 
			,error: function(){
				jQuery('#comment_tip').html('<p class="msg">Oops, failed to load data.</p>');
			}
		});
	}
}, function() {
	jQuery('#thecomments .tip').fadeOut(400, function(){
		jQuery(this).remove();
	});
});
});
/*延迟加载*/
$(function(){
	$("img.avatar").lazyload({ 
	    effect :"fadeIn"});
});
/*评论框的信息填写*/
$(function(){
	$(".input input").each(function(){
		switch($(this).attr("id")){
		case "author":
		{
			var _author=this.value;
			if($(this).val()==""){
				$(this).val("Id");
				_author="Id";
			}
			$(this).focus(function(){
				this.value="";
			}).blur(function(){
				if(this.value=="")
				this.value=_author;
			});
		}break;
		case "email":
		{
			var _email=$(this).val();
			if($(this).val()==""){
				$(this).val("Email");
				_email="Email";
			}
			$(this).focus(function(){
				this.value="";
			}).blur(function(){
				if(this.value=="")
				this.value=_email;
			});
		}break;
		case "url":
		{
			var _url=this.value;
			if($(this).val()==""){
				$(this).val("Url");
				_url="Url";
			}
			$(this).focus(function(){
				this.value="http://";
			}).blur(function(){
				if(this.value==""||this.value=="http://")
				this.value=_url;
			});
		}break;
	}
	});
	/*邮箱自动完成*/
	 var Iemail = [
	               "@163.com",
	               "@qq.com",
	               "@hotmail.com",
	               "@gmail.com",
	               "@126.com",
	               "@21cn.com",
	               "@sohu.com",
	               "@yahoo.cn",
	               "@139.com",
	               "@wo.com.cn",
	               "@189.cn"
	               ];	              
	               $("#email").autocomplete({
	                   minLength: 1,
	                   delay: 200,   
						   source: function (request, respond) {	                      
	                       if (request.term.indexOf('@') == -1) {	                          
	                    	   respond(Iemail.map(function(v){
	                    		   return request.term+v;
	                    	   }));
							}
	                       else {
							   var behind=request.term.split('@')[1];
	                           var form = request.term.split('@')[0];	                          
	                           respond(Iemail.filter(function(value,index){	                        	   
	                        	   return value.indexOf(behind)!=-1
	                           }).map(function(v){
	                        	   return form+v;
	                           }));
	                       }
	                   },
	                   autoFocus: true
	               });
});
