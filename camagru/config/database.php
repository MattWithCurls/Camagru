<?PHP
     $DB_DSN = "mysql:host=localhost;";
     $DB_USER = "root";
     $DB_PASSWORD = "123456";
         try {
             $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
             $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         } catch (PDOException $e) {
             $_SESSION['messages'][] = 'Connection failed: ' . $e->getMessage();
            //  header('Location: register.php');
             exit;
         }
?>
