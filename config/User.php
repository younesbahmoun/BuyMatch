<?php
require_once __DIR__ . "/../classes/Users.php";

$user = new User();

// === CRÉER UN UTILISATEUR ===
$user->create(
    1,                      // role_id
    "alice@email.com",      // email
    "motdepasse123",        // password (sera hashé automatiquement)
    "Dupont",               // nom
    "Alice",                // prenom
    "actif"                 // statut
);
echo "ID créé : " . $user->getLastInsertId();


// === CONNEXION ===
$result = $user->login("alice@email.com", "motdepasse123");
if ($result) {
    echo "Bienvenue " . $result['prenom'] . " " . $result['nom'];
} else {
    echo "Email ou mot de passe incorrect";
}


// === RÉCUPÉRER TOUS LES UTILISATEURS ===
$allUsers = $user->getAll();
print_r($allUsers);


// === TROUVER PAR ID ===
$oneUser = $user->findById(1);
print_r($oneUser);


// === METTRE À JOUR ===
$user->update(1, [
    'nom' => 'Martin',
    'prenom' => 'Alice',
    'statut' => 'premium'
]);


// === CHANGER LE MOT DE PASSE ===
$user->updatePassword(1, "nouveauMotDePasse");


// === DÉSACTIVER UN COMPTE ===
$user->deactivate(1);


// === RÉACTIVER UN COMPTE ===
$user->activate(1);


// === VÉRIFIER SI EMAIL EXISTE ===
if ($user->emailExists("alice@email.com")) {
    echo "Cet email est déjà utilisé";
}


// === SUPPRIMER ===
$user->delete(1);