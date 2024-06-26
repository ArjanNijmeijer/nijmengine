( function () {
	function addEventListeners() {
		document.addEventListener( 'change', handleChangeEvent );
		document.addEventListener( 'keydown', handleKeyDownEvent );
	}

	function handleChangeEvent( e ) {
		if (
			'INPUT' === e.target.nodeName &&
			'checkbox' === e.target.type &&
			e.target.parentNode.classList.contains( 'frm_switch_block' )
		) {
			handleToggleChangeEvent( e );
		}
	}

	function handleKeyDownEvent( e ) {
		switch ( e.key ) {
			case ' ':
				handleSpaceDownEvent( e );
				break;
		}
	}

	function handleToggleChangeEvent( e ) {
		e.target.nextElementSibling.setAttribute(
			'aria-checked',
			e.target.checked ? 'true' : 'false'
		);
	}

	function handleSpaceDownEvent( e ) {
		if ( e.target.classList.contains( 'frm_switch' ) ) {
			e.target.click();
		}
	}

	addEventListeners();
} )();
