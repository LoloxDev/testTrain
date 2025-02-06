describe('Gestion des utilisateurs', () => {
    beforeEach(() => {
        // Accéder à l'application
        cy.visit('http://localhost:8000/public/index.html');
    });

    it('Ajoute un utilisateur et vérifie son affichage dans la liste', () => {
        cy.get('#name').type('Alice');
        cy.get('#email').type('alice@example.com');
        cy.get('#userForm').submit();

        // Attendre la mise à jour du DOM
        cy.wait(1000);

        // Vérifier que l'utilisateur apparaît bien dans la liste
        cy.contains('Alice').should('exist');
    });

    it('Modifie un utilisateur existant', () => {
        // Ajouter un utilisateur
        cy.get('#name').type('Bob');
        cy.get('#email').type('bob@example.com');
        cy.get('#userForm').submit();

        // Attendre que la liste soit mise à jour
        cy.wait(1000);

        // Vérifier qu'il est bien ajouté
        cy.contains('Bob').should('exist');

        // Cliquer sur le bouton d'édition (✏️)
        cy.contains('Bob')
            .parent()
            .find('button')
            .contains('✏️')
            .click();

        // Modifier les informations
        cy.get('#name').clear().type('Robert');
        cy.get('#email').clear().type('robert@example.com');
        cy.get('#userForm').submit();

        // Attendre la mise à jour
        cy.wait(1000);

        // Vérifier que la modification est effective
        cy.contains('Robert').should('exist');
    });

    it('Supprime un utilisateur et vérifie sa disparition', () => {
        // Générer un nom et un email uniques pour éviter les conflits
        const uniqueName = 'Charlie' + Date.now();
        const uniqueEmail = 'charlie' + Date.now() + '@example.com';

        // Ajouter l'utilisateur unique
        cy.get('#name').type(uniqueName);
        cy.get('#email').type(uniqueEmail);
        cy.get('#userForm').submit();

        // Attendre la mise à jour de la liste
        cy.wait(1000);

        // Vérifier que l'utilisateur est bien ajouté
        cy.contains(uniqueName).should('exist');

        // Supprimer l'utilisateur via le bouton ❌
        cy.contains(uniqueName)
            .parent()
            .find('button')
            .contains('❌')
            .click();

        // Attendre un peu pour laisser l'API et le DOM se mettre à jour
        cy.wait(2000);

        // Vérifier que l'utilisateur a bien été supprimé de la base en effectuant une requête directe
        cy.request('GET', '../src/api.php?cb=' + Date.now()).then((response) => {
            expect(response.body).not.to.include(uniqueName);
        });

        // Forcer un rechargement de la liste en appelant une mise à jour manuelle
        cy.reload();

        // Vérifier que l'utilisateur n'est plus présent (attente max de 10s)
        cy.contains(uniqueName, {timeout: 10000}).should('not.exist');
    });
});
