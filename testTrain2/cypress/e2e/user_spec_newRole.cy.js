describe('Gestion des utilisateurs (fonctionnalité role)', () => {
    beforeEach(() => {
        cy.visit('http://localhost:8000/public/index.html');
    });

    it('Ajoute un utilisateur avec un rôle admin et vérifie son affichage', () => {
        const uniqueName = 'AdminUser' + Date.now();
        const uniqueEmail = 'adminuser' + Date.now() + '@example.com';

        cy.get('#name').type(uniqueName);
        cy.get('#email').type(uniqueEmail);
        cy.get('#role').select('admin');

        cy.get('#userForm').submit().then(() => {
            cy.wait(1000);
            cy.request('GET', '../src/api.php?cb=' + Date.now()).then((response) => {
                const userNames = response.body.map(user => user.name);
                expect(userNames).to.include(uniqueName);
            });
        });

        cy.wait(2000);
        cy.reload();
        cy.wait(1000);
        // On vérifie que l'élément de la liste contient bien le nom, l'email et le rôle
        cy.get('#userList li')
            .should('contain.text', uniqueName)
            .and('contain.text', uniqueEmail)
            .and('contain.text', '[admin]');
    });

    it('Modifie le rôle d’un utilisateur existant', () => {
        const timestamp = Date.now();
        const uniqueName = 'RoleTest' + timestamp;
        const uniqueEmail = 'roletest' + timestamp + '@example.com';

        // Ajout d'un utilisateur avec le rôle "user"
        cy.get('#name').type(uniqueName);
        cy.get('#email').type(uniqueEmail);
        cy.get('#role').select('user');
        cy.get('#userForm').submit();

        cy.wait(1000);
        cy.get('#userList li')
            .should('contain.text', uniqueName)
            .and('contain.text', uniqueEmail)
            .and('contain.text', '[user]');

        // Cliquer sur le bouton d'édition (✏️) pour ouvrir le formulaire d'édition
        cy.contains(uniqueName)
            .parent()
            .within(() => {
                cy.get('button').contains('✏️').click();
            });

        // Modifier le rôle en sélectionnant "admin"
        cy.get('#role').select('admin');
        // On soumet sans changer le nom et l'email (ils restent identiques)
        cy.get('#userForm').submit();

        cy.wait(1000);
        cy.request('GET', '../src/api.php?cb=' + Date.now()).then((response) => {
            const userNames = response.body.map(user => user.name);
            expect(userNames).to.include(uniqueName);
        });

        cy.reload();
        cy.wait(1000);
        // Vérifier que l'élément de la liste affiche bien le rôle mis à jour
        cy.get('#userList li')
            .should('contain.text', uniqueName)
            .and('contain.text', uniqueEmail)
            .and('contain.text', '[admin]');
    });
});
