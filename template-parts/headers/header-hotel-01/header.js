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
		var menuback 	= jQuery('<a href="#" class="menu-back">' + text + '</a>');
		

		subclone.addClass( 'sub-menu-generated' );
		menu_container.children('div').prepend( menuback );
		menu_list.after( subclone );

		setTimeout( function(){

			menu_container.addClass('inside-submenu');

		}, 100);

		menuback.on('click', function(){ 
			menu_container.removeClass('inside-submenu');

			setTimeout( function(){

				menu_container.find('.sub-menu-generated, .menu-back').remove();

			}, 500);
			
		});
		
	});

});