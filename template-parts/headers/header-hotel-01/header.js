jQuery(document).ready( function(){

	var menu_container 	= jQuery( '.primary-menu-container' );
	var menu_list 		= menu_container.find( 'ul.menu, div.menu > ul');
	var menu_link 		= menu_list.find('li a');

	menu_link.on('click', function(evt){
		
		evt.preventDefault();
		var text 		= jQuery(this).text();
		var parent 		= jQuery(this).parent();
		var submenu 	= parent.children('ul.sub-menu, ul.children');
		var subclone 	= submenu.clone();
		
		
		var menuback 	= menu_container.children('div').prepend('<a href="#" class="menu-back">' + text + '</a>');
		menuback.on('click', function(){
			menu_container.removeClass('inside-submenu');
		});

		menu_list.after( subclone );

		setTimeout( function(){

			menu_container.addClass('inside-submenu');

		}, 100);
		
	});

});