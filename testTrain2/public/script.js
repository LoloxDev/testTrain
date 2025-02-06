document.addEventListener("DOMContentLoaded", function () {
    const userForm = document.getElementById("userForm");
    const userList = document.getElementById("userList");
    const userIdField = document.getElementById("userId");
    const roleField = document.getElementById("role"); // Nouveau champ

    function fetchUsers() {
        const url = "../src/api.php?cb=" + Date.now();
        fetch(url, {cache: "no-store"})
            .then(response => response.json())
            .then(users => {
                userList.innerHTML = "";
                users.forEach(user => {
                    const li = document.createElement("li");
                    li.innerHTML = `${user.name} (${user.email}) - [${user.role}]
                        <button onclick="editUser(${user.id}, '${user.name}', '${user.email}', '${user.role}')">✏️</button>
                        <button onclick="deleteUser(${user.id})">❌</button>`;
                    userList.appendChild(li);
                });
            })
            .catch(err => console.error('Erreur lors de la récupération des utilisateurs :', err));
    }

    userForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const userId = userIdField.value;
        const role = roleField.value; // Récupération du champ role

        if (!name || !email) {
            alert("Veuillez renseigner un nom et un email.");
            return;
        }

        let method = "POST";
        let bodyParams = {name, email, role};

        if (userId) {
            method = "PUT";
            bodyParams.id = userId;
        }

        fetch("../src/api.php", {
            method: method,
            body: new URLSearchParams(bodyParams),
            headers: {"Content-Type": "application/x-www-form-urlencoded"}
        })
            .then(resp => {
                if (!resp.ok) {
                    return resp.json().then(data => {
                        throw new Error(data.error || "Une erreur est survenue.");
                    });
                }
                return resp.json();
            })
            .then(responseData => {
                userForm.reset();
                userIdField.value = "";
                console.log("Réponse serveur :", responseData);
                fetchUsers();
            })
            .catch(err => alert(err.message));
    });

    // On ajoute 'role' en 4e paramètre
    window.editUser = function (id, name, email, role) {
        document.getElementById("name").value = name;
        document.getElementById("email").value = email;
        document.getElementById("role").value = role;
        userIdField.value = id;
    };

    window.deleteUser = function (id) {
        fetch(`../src/api.php?id=${id}`, {method: "DELETE"})
            .then(resp => {
                if (!resp.ok) {
                    return resp.json().then(data => {
                        throw new Error(data.error || "Erreur pendant la suppression.");
                    });
                }
                return resp.json();
            })
            .then(responseData => {
                console.log("Réponse après suppression :", responseData);
                fetchUsers();
            })
            .catch(err => alert(err.message));
    };

    fetchUsers();
});
