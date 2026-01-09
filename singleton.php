<?php

class Database
{

    private static ?Database $instance = null;

    private PDO $pdo;



    private function __construct(string $dsn, string $username, string $password)
    {
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed");
        }
    }


    public static function getInstance(?string $dsn = null, ?string $username = null, ?string $password = null): Database
    {

        if (self::$instance === null) {
            self::$instance = new Database(
                $dsn ?? 'mysql:host=localhost;dbname=live_coding_db',
                $username ?? 'root',
                $password ?? 'Sa@123456'
            );
        }

        return self::$instance;
    }


    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}

//  ==============================(- USER -)================================

class User
{
    private ?int $id;
    private string $nom;
    private string $prenom;
    private string $email;
    private ?string $passwordHash;

    public function __construct(
        ?int $id,
        string $nom,
        string $prenom,
        string $email,
        ?string $passwordHash = null
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    public function __toString(): string
    {
        return $this->nom . ' ' . $this->prenom;
    }

    /* ===================== SETTERS ===================== */

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    private function setPassword(string $password): void
    {
        $this->passwordHash = password_hash($password, PASSWORD_BCRYPT);
    }

    /* ===================== DATABASE ===================== */

    public function save(): int
    {
        $db = Database::getInstance()->getConnection();

        if ($this->id) {
            $stmt = $db->prepare(
                "UPDATE users 
                 SET nom = :nom, prenom = :prenom, email = :email 
                 WHERE id = :id"
            );
            $stmt->execute([
                ':nom' => $this->nom,
                ':prenom' => $this->prenom,
                ':email' => $this->email,
                ':id' => $this->id
            ]);
        } else {
            $stmt = $db->prepare(
                "INSERT INTO users (nom, prenom, email, password)
                 VALUES (:nom, :prenom, :email, :password)"
            );
            $stmt->execute([
                ':nom' => $this->nom,
                ':prenom' => $this->prenom,
                ':email' => $this->email,
                ':password' => $this->passwordHash
            ]);

            $this->id = (int) $db->lastInsertId();
        }

        return $this->id;
    }

    /* ===================== STATIC FINDERS ===================== */

    public static function findByEmail(string $email): ?User
    {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row
            ? new User(
                $row['id'],
                $row['nom'],
                $row['prenom'],
                $row['email'],
                $row['password']
            )
            : null;
    }

    public static function searchByName(string $name): array
    {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare(
            "SELECT * FROM users 
             WHERE nom LIKE :q OR prenom LIKE :q"
        );
        $stmt->execute([':q' => "%$name%"]);

        $users = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $users[] = new User(
                $row['id'],
                $row['nom'],
                $row['prenom'],
                $row['email'],
                $row['password']
            );
        }

        return $users;
    }

    /* ===================== AUTH ===================== */

    public static function signup(
        string $nom,
        string $prenom,
        string $email,
        string $password
    ): int {
        if (self::findByEmail($email)) {
            throw new Exception("Email already exists");
        }

        $user = new User(null, $nom, $prenom, $email);
        $user->setPassword($password);

        return $user->save();
    }

    public static function signin(string $email, string $password): User
    {
        $user = self::findByEmail($email);

        if (!$user || !password_verify($password, $user->passwordHash)) {
            throw new Exception("Invalid credentials");
        }

        return $user;
    }
}


// =========================== RUN CODE ===========================================


// Test Singleton
$db1 = Database::getInstance();
$db2 = Database::getInstance();

var_dump($db1 === $db2); // true

// $newUser = new User(null,"Ahmed","Ali","Ali@gmail.com",password_hash("11111111",PASSWORD_BCRYPT));
// $newUser->save();


// echo PHP_EOL . "================ USER CREATION ================" . PHP_EOL;

// Create user using SIGNUP
// try {
//     $newUserId = User::signup(
//         "omar",
//         "EL AMRANI",
//         "amranii@gmail.com",
//         "11111111"
//     );

//     echo "User created with ID: " . $newUserId . PHP_EOL;
// } catch (Exception $e) {
//     echo "Signup error: " . $e->getMessage() . PHP_EOL;
// }

// echo PHP_EOL . "================ SIGN IN ================" . PHP_EOL;

// // Sign in user
// try {
//     $loggedUser = User::signin("abdellaah@gmail.com", "11111111");

//     echo "Logged in as: " . $loggedUser . PHP_EOL;
// } catch (Exception $e) {
//     echo "Signin error: " . $e->getMessage() . PHP_EOL;
// }

// echo PHP_EOL . "================ SEARCH BY NAME ================" . PHP_EOL;

// // Search users by name
// $users = User::searchByName("Hamzaqq");

// foreach ($users as $u) {
//     echo $u . PHP_EOL;
// }


// ===(- Fetch user -)====
$user = User::findByEmail("hamza@gmail.com");

if ($user == null) {
    echo "No User Exist -)" . "\n";
    exit;
}

echo $user . PHP_EOL;

// Update user
$user->setNom("lafsioui");
$user->save();

echo $user . PHP_EOL;