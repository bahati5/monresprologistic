-- Création utilisateur admin par défaut pour base de données vierge
-- Exécuter après deprixapro_database.sql + monrespro_migration.sql

SET NAMES utf8mb4;

-- Vérifier si la table cdb_users existe
SET @table_exists = (SELECT COUNT(*) FROM information_schema.tables 
                    WHERE table_schema = DATABASE() AND table_name = 'cdb_users');

-- Créer admin uniquement si la table existe
SET @sql = IF(@table_exists > 0, 
    CONCAT('INSERT INTO `cdb_users` (`id`, `name_user`, `email_user`, `password_user`, `user_type`, `status_user`, `date_created`) VALUES (',
           '1, ',
           '''Administrateur'', ',
           '''admin@monrespro.com'', ',
           '''$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'', ', -- password: password
           '''admin'', ',
           '''Active'', ',
           'NOW()) ',
           'ON DUPLICATE KEY UPDATE name_user = VALUES(name_user), email_user = VALUES(email_user), password_user = VALUES(password_user)'),
    'SELECT ''Table cdb_users not found - skipping admin creation'' as message');

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Afficher un message de confirmation
SELECT 'Default admin user created (or updated): admin@monrespro.com / password' as result;
