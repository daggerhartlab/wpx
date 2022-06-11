describe('empty spec', function () {

	before(() => {
		cy.fixture('user-admin').then((userData) => {
			this.user = userData;
		})
	});

	it('passes', () => {
		cy.login(this.user)

		cy.get('h1').should('contain.text', 'Dashboard')
	})
})
