describe('WPX Example Admin Pages', function () {

	beforeEach(() => {
		cy.fixture('user-admin').then((userData) => {
			this.user = userData;
			cy.login(userData)
		})
	});

	/*
	 * ACF Pages
	 */
	it('Acf page can save data', () => {
		cy.get('a.toplevel_page_acf-top-level').click()

		cy.get('#acf-group_1 h2').should('contain.text', 'My Group')
		cy.get('#acf-field_1').type('{selectAll}{del}Example value set')
		cy.get('form#post').submit()

		// Wait for the ajax submit to complete.
		cy.wait(6000)

		cy.get('#acf-field_1').should('have.value', 'Example value set')
	})

	/*
	 * Custom pages.
	 */
	it('Admin page menu items exist with correct menu titles in correct order', () => {
		cy.get('h1').should('contain.text', 'Dashboard')

		// Visit the first page so we don't have to look for hidden elements.
		cy.get('#toplevel_page_top-level')
			.should('contain.text', 'Top Level')
			.click()

		cy.get('h1').should('contain.text', 'Top Level')

		cy.get('#toplevel_page_top-level .wp-submenu')
			.find('li:nth-child(3)')
				.should('contain.text', 'Child 2 Menu Title')
			.parent()
				.find('li:nth-child(4)')
					.should('contain.text', 'Child 1')
	})

	it('Admin pages have correct titles', () => {
		cy.get('#toplevel_page_top-level')
			.should('contain.text', 'Top Level')
			.click()

		cy.get('h1').should('contain.text', 'Top Level')

		cy.get('#toplevel_page_top-level .wp-submenu')
			.find('li:nth-child(3)')
			.click()

		cy.get('h1').should('contain.text', 'Child 2')

		cy.get('#toplevel_page_top-level .wp-submenu')
			.find('li:nth-child(4)')
			.click()

		cy.get('h1').should('contain.text', 'Child 1')
	})
})
