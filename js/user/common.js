/**

	// Author: Shardul Bagade
	// Comment: Created file.


*/




// Author: Shardul Bagade; Comment: perform undo operation
function doUndo(){  
  editor.execCommand('undo', false, null);  
}  
   
   
// Author: Shardul Bagade; Comment: perform redo operation
function doRedo(){  
  editor.execCommand('redo', false, null);  
} 



// Author: Shardul Bagade; Comment: pin and unpin language panel
function pinUnpinLangPanel()
{
	if(document.getElementById('lang_id').style.visibility == 'visible')
	{
		document.getElementById('lang_id').style.visibility = 'hidden';
		$('#lang_id').hide();
	}
	else if(document.getElementById('lang_id').style.visibility != 'visible')
	{
		document.getElementById('lang_id').style.visibility = 'visible';
		$('#lang_id').show("medium");
	}
}


// Author: Shardul Bagade; Comment: pin and unpin rich text operation panel
function pinUnpinRichTextPanel()
{
	if(document.getElementById('richtext_id').style.visibility == 'visible')
	{
		document.getElementById('richtext_id').style.visibility = 'hidden';
		$('#richtext_id').hide();
	}
	else if(document.getElementById('richtext_id').style.visibility != 'visible')
	{
		document.getElementById('richtext_id').style.visibility = 'visible';
		$('#richtext_id').show("medium");
	}
}


