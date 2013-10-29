
$(function () {
		
/** Tabbing **/	
/* tabs function:
	<div class="tabs">
		<ul class="tabNavigation"><li><a href="#xyz"></a></li><li><a href="#abc"></a></li></ul>
		<div class="content" id="xyz">...</div><div class="content" id="abc">...</div>
	</div> 
*/	
	var tabContainers = $('div.tabs > div');
	tabContainers.hide().filter(':first').show();
	
	$('div.tabs ul.tabNavigation a').click(function () {
		tabContainers.hide();
		tabContainers.filter(this.hash).show();
		$('div.tabs ul.tabNavigation a').removeClass('active');
		$(this).addClass('active');
		return false;
	}).filter(':first').click();
 
/** x **/

				
});



