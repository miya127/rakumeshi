

$(function() {
	$(".btn_vote").click(function() {
		$(this).toggleClass('on');
		var id = $(this).attr('id');
		$(this).hasClass('on') ? Vote(id, 'plus') : Vote(id, 'minus');
	});
});
function Vote(id, plus) {
	cls = $('.' + id);
	cls_num = Number(cls.html());
	count = plus == 'minus' ? cls_num - 1 : cls_num + 1;
//alert('good');
	$.get('good.php', {'file': id, 'count': count}, function() {
		cls.html(count)
	});
}

