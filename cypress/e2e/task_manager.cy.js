// cypress/e2e/task_manager.cy.js
describe('Gestion de tâches - Test E2E', () => {
    it('Devrait permettre d’ajouter puis de supprimer une tâche', () => {
        cy.visit('http://localhost:8000/index.html'); // ou l'URL que tu utilises

        cy.get('#taskInput').type('Nouvelle tâche');
        cy.contains('Ajouter').click();

        cy.get('#taskList').should('contain', 'Nouvelle tâche');

        cy.contains('Supprimer').click();
        cy.get('#taskList').should('not.contain', 'Nouvelle tâche');
    });
});
