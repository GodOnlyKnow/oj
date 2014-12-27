$(function(){
	$('tr:odd').addClass('odd');
	$('tr:even').addClass('even');
	$("#list tr").each(function(index){
		if(index%2==0)
			$(this).find("td:first").addClass('evenrow');
		else
			$(this).find("td:first").addClass('oddrow');
	})
	$('#submitinfo').click(function () {
		
        var str = $('#searchinfo').val();
        if (str == '') return;
        window.location.href = SearchUrl + "?info=" + str;
    });
	$('.panel').on('hide.bs.collapse', function () {
		 $(this).find('.pointerimg').attr('src','../../Public/Image/News/1.png');
	});
	$('.panel').on('show.bs.collapse', function () {
		 $(this).find('.pointerimg').attr('src','../../Public/Image/News/2.png');
	});
})
