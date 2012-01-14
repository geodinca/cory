// open and print pdf document
function openPdf(filePath, title){
	$('#pdf_frame').attr('src', filePath);
	$('#pdf_content').dialog({title: "Show request " + title});
	$('#pdf_content').dialog('open');
}

// dialog box to open pdf document
$(function(){
	$('#pdf_content').dialog({
		autoOpen: false,
		height: 700,
		width: 830,
		resizable: false,
		modal: true,
		close: function() {
			// fa ceva la close
		}
	});
});