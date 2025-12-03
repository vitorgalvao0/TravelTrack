<?php
// Basic autoloader and constants
require_once __DIR__ . '/database.php';

define('BASE_PATH', __DIR__ . '/..');
define('APP_PATH', BASE_PATH);
define('VIEW_PATH', BASE_PATH . '/views');
define('MODEL_PATH', BASE_PATH . '/models');
define('CONTROLLER_PATH', BASE_PATH . '/controllers');
define('ASSETS_PATH', BASE_PATH . '/public');

spl_autoload_register(function ($class) {
    $paths = [CONTROLLER_PATH, MODEL_PATH];
    foreach ($paths as $p) {
        $file = $p . '/' . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

session_start();

/**
 * Resolve a logical table name to the actual table name present in the database.
 * Tries common English names first, then Portuguese names used by provided SQL.
 */
function tableName(string $logical)
{
    static $map = [
        'users' => ['users', 'usuario'],
        'places' => ['places', 'estabelecimento','estabelecimentos','place','estab','estabelecimento'],
        'checkins' => ['checkins', 'checkin'],
        'reviews' => ['reviews', 'avaliacao','avaliacoes'],
        'rewards' => ['rewards', 'recompensa','recompensas'],
    ];

    $db = null;
    try {
        $db = (new Database())->conectar();
    } catch (Exception $e) {
        return $logical; // fallback
    }

    $candidates = $map[$logical] ?? [$logical];
    foreach ($candidates as $t) {
        try {
            $stmt = $db->prepare('SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = :t');
            $stmt->execute(['t' => $t]);
            if ($stmt->fetch()) {
                return $t;
            }
        } catch (Exception $e) {
            // ignore and try next
        }
    }

    return $logical;
}

?>
