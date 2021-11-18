// add attribute data-bs-toggle & data-bs-display='static' for dropdown link
const dropdown = document.querySelectorAll( '.menu .dropdown' );
dropdown.forEach( element => {
	for ( let i = 0; i < element.children.length; i++ ) {
		if ( element.children[i].tagName == 'A' ) {
			element.children[i].setAttribute( 'data-bs-toggle', 'dropdown' );
			element.children[i].setAttribute( 'data-bs-display', 'static' );
		}
	}
})


// nested dropdowns fix
const nestedDropdownLink = document.querySelectorAll( '.menu .dropdown-menu .dropdown-menu [data-bs-toggle="dropdown"]' );
nestedDropdownLink.forEach( element => element.addEventListener( 'click', e => {
	// first parent dropdown-menu
	const dropdownMenu = e.currentTarget.closest( '.dropdown-menu' );

	// if parent is list - return
	if ( dropdownMenu.parentElement.classList.contains( 'menu_nested_list' ) ) {
		return;
	}

	// close sibling dropdowns OR close current if it was opened
	const openedDropdown = dropdownMenu.querySelector( '.dropdown-item.show' );
	if ( openedDropdown && !e.currentTarget.classList.contains( 'show' ) ) {
		openedDropdown.click();
	}
	e.stopPropagation();
}))