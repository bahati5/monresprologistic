-- Migration Monrespro Logistics — Phase A
-- Preuve de paiement, coordonnées par agence, structure pour 3 agences
-- Exécuter après deprixapro_database.sql

SET NAMES utf8mb4;

-- ============================================================
-- 1. Passerelle "Preuve de paiement" (ID 6)
-- ============================================================
INSERT INTO `cdb_met_payment` (`id`, `name_pay`, `detail_pay`, `paypal_client_id`, `public_key`, `secret_key`, `is_active`) VALUES
(6, 'Preuve de paiement', 'Le client paie via Mobile Money, virement ou autre moyen puis charge la preuve (capture d''écran, reçu). L''administrateur vérifie et valide ou rejette.', NULL, NULL, NULL, 1)
ON DUPLICATE KEY UPDATE name_pay = VALUES(name_pay), detail_pay = VALUES(detail_pay), is_active = VALUES(is_active);

-- ============================================================
-- 2. Table des preuves de paiement (workflow validation admin)
-- ============================================================
CREATE TABLE IF NOT EXISTS `cdb_payment_proofs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_entity` varchar(50) NOT NULL COMMENT 'package|courier|consolidate|consolidate_package',
  `entity_id` int(11) NOT NULL,
  `order_track` varchar(350) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `rejection_reason` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reviewed_at` datetime DEFAULT NULL,
  `reviewed_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_entity` (`type_entity`,`entity_id`),
  KEY `idx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 3. Fichiers des preuves (jusqu'à 3 par preuve)
-- ============================================================
CREATE TABLE IF NOT EXISTS `cdb_payment_proof_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proof_id` int(11) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `sort_order` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `proof_id` (`proof_id`),
  CONSTRAINT `fk_proof_files_proof` FOREIGN KEY (`proof_id`) REFERENCES `cdb_payment_proofs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 4. Coordonnées de paiement par agence (Mobile Money, virement…)
-- ============================================================
CREATE TABLE IF NOT EXISTS `cdb_agency_payment_coordinates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL COMMENT 'cdb_branchoffices.id',
  `label` varchar(120) NOT NULL COMMENT 'ex: M-Pesa, Airtel Money, Virement SEPA',
  `account_identifier` varchar(255) NOT NULL COMMENT 'numéro, IBAN, etc.',
  `currency` varchar(10) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` smallint(3) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 5. Agences et bureaux Monrespro (optionnel — décommenter si BDD vierge)
-- ============================================================
-- Bureaux (offices)
-- INSERT INTO `cdb_offices` (`id`, `name_off`, `code_off`, `address`, `city`, `phone_off`) VALUES
-- (91, 'Monrespro Belgium', 'MRP-BE', 'Adresse entrepôt Belgique', 'Bruxelles', '+32 XXX XX XX XX'),
-- (92, 'Monrespro Kinshasa', 'MRP-KIN', 'Adresse bureau Kinshasa', 'Kinshasa', '+243 XXX XXX XXX'),
-- (93, 'Monrespro Gabon', 'MRP-GAB', 'Adresse bureau Libreville', 'Libreville', '+241 XX XX XX XX');

-- Agences (branch offices)
-- INSERT INTO `cdb_branchoffices` (`id`, `name_branch`, `branch_address`, `branch_city`, `phone_branch`) VALUES
-- (9, 'Monrespro Belgium', 'Adresse entrepôt', 'Bruxelles', '+32 XXX XX XX XX'),
-- (10, 'Monrespro Kinshasa', 'Adresse bureau', 'Kinshasa', '+243 XXX XXX XXX'),
-- (11, 'Monrespro Gabon', 'Adresse bureau', 'Libreville', '+241 XX XX XX XX');
