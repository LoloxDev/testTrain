describe('Gestion de tâches avec deadline - Test E2E', () => {
    it('Devrait permettre d’ajouter puis de supprimer une tâche avec une date d’échéance', () => {
        // Remplace l'URL ci-dessous par la tienne, ex. http://localhost:8000/index_exercice3.html
        cy.visit('http://localhost:8000/index_exercice3.html');

        // Saisie du nom de la tâche
        cy.get('#taskInput').type('Ma tâche avec deadline');

        // Saisie de la date
        cy.get('#deadlineInput').type('2025-12-01');

        // Clic sur "Ajouter"
        cy.contains('Ajouter').click();

        // Vérification que la tâche s'affiche
        cy.get('#taskList').should('contain', 'Ma tâche avec deadline');
        // Vérification que la date s'affiche
        cy.get('#taskList').should('contain', '2025-12-01');

        // Suppression de la tâche
        cy.contains('Supprimer').click();

        // Vérification que la tâche n'est plus présente
        cy.get('#taskList').should('not.contain', 'Ma tâche avec deadline');
        cy.get('#taskList').should('not.contain', '2025-12-01');
    });
});
