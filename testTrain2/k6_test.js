import http from 'k6/http';
import {check, sleep} from 'k6';

export let options = {
    vus: 500,          // 500 utilisateurs virtuels
    duration: '30s',   // sur 30 secondes
};

export default function () {
    // Générer un nom/email unique pour éviter les contraintes d’unicité
    const randomId = Math.floor(Math.random() * 1000000);
    const url = 'http://localhost:8000/src/api.php'; // adapter si besoin

    let payload = {
        name: 'User' + randomId,
        email: `user${randomId}@example.com`
    };

    // Envoi d’une requête POST pour ajouter un utilisateur
    let res = http.post(url, payload);

    // Vérification de base : code 200 attendu
    check(res, {
        'status was 200': (r) => r.status === 200,
    });

    // Attendre un tout petit peu entre deux requêtes
    sleep(0.5);
}
