

$(function() {
	$(".btn_save").click(function() {
		$(this).toggleClass('on');
		var id = $(this).attr('id');
		$(this).hasClass('on') ? Save(id, 'plus') : Save(id, 'minus');
	});
});
function Save(id, plus) {

	count = plus == 'minus' ?  0 :  + 1;

//alert('save');
	$.get('save.php', {'file': id, 'count': count}, function() {
	
	});
}