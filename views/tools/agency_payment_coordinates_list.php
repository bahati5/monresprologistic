<?php
require_once('helpers/querys.php');
$userData = $user->cdp_getUserData();
$coordinates = cdp_getAllAgencyPaymentCoordinates();
$db = new Conexion;
$db->cdp_query("SELECT * FROM cdb_branchoffices ORDER BY name_branch");
$db->cdp_execute();
$branches = $db->cdp_registros();
?>
<!DOCTYPE html>
<html dir="<?php echo $direction_layout; ?>" lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon ?>">
    <title>Coordonnées de paiement par agence | <?php echo $core->site_name ?></title>
    <?php include 'views/inc/head_scripts.php'; ?>
</head>
<body>
    <?php include 'views/inc/preloader.php'; ?>
    <div id="main-wrapper">
        <?php include 'views/inc/topbar.php'; ?>
        <?php include 'views/inc/left_sidebar.php'; ?>
        <div class="page-wrapper">
            <div class="tw-p-4 lg:tw-p-6 tw-space-y-4">
                <div id="resultados_ajax"></div>

                <div class="tw-flex tw-flex-col sm:tw-flex-row sm:tw-items-center sm:tw-justify-between tw-gap-3">
                    <div>
                        <h1 class="tw-text-2xl tw-font-bold tw-text-gray-800">Coordonnées de paiement par agence</h1>
                        <p class="tw-text-sm tw-text-gray-500 tw-mt-1">Numéros Mobile Money, comptes bancaires, etc. affichés aux clients pour la preuve de paiement.</p>
                    </div>
                    <button type="button" class="tw-inline-flex tw-items-center tw-gap-2 tw-px-4 tw-py-2 tw-bg-blue-600 tw-text-white tw-rounded-lg tw-text-sm tw-font-medium hover:tw-bg-blue-700 tw-transition-colors tw-shadow-sm" data-toggle="modal" data-target="#modalAddCoordinate">
                        <i data-lucide="plus" class="tw-w-4 tw-h-4"></i>
                        Ajouter
                    </button>
                </div>

                <div class="tw-bg-white tw-rounded-xl tw-border tw-border-gray-200 tw-shadow-sm tw-overflow-hidden">
                    <div class="tw-overflow-x-auto">
                        <table class="tw-w-full tw-text-sm tw-text-left">
                            <thead class="tw-bg-gray-50 tw-border-b tw-border-gray-200">
                                <tr>
                                    <th class="tw-px-4 tw-py-3 tw-font-semibold tw-text-gray-600">Agence</th>
                                    <th class="tw-px-4 tw-py-3 tw-font-semibold tw-text-gray-600">Libellé</th>
                                    <th class="tw-px-4 tw-py-3 tw-font-semibold tw-text-gray-600">Numéro / Compte</th>
                                    <th class="tw-px-4 tw-py-3 tw-font-semibold tw-text-gray-600">Devise</th>
                                    <th class="tw-px-4 tw-py-3 tw-font-semibold tw-text-gray-600">Actif</th>
                                    <th class="tw-px-4 tw-py-3 tw-font-semibold tw-text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="tw-divide-y tw-divide-gray-100">
                                <?php if (!empty($coordinates)): foreach ($coordinates as $c): ?>
                                <tr class="hover:tw-bg-gray-50 tw-transition-colors">
                                    <td class="tw-px-4 tw-py-3"><?php echo htmlspecialchars($c->name_branch ?? '-'); ?></td>
                                    <td class="tw-px-4 tw-py-3"><?php echo htmlspecialchars($c->label); ?></td>
                                    <td class="tw-px-4 tw-py-3"><?php echo htmlspecialchars($c->account_identifier); ?></td>
                                    <td class="tw-px-4 tw-py-3"><?php echo htmlspecialchars($c->currency ?? '-'); ?></td>
                                    <td class="tw-px-4 tw-py-3">
                                        <span class="tw-inline-flex tw-items-center tw-px-2 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium <?php echo $c->is_active ? 'tw-bg-green-100 tw-text-green-800' : 'tw-bg-red-100 tw-text-red-800'; ?>">
                                            <?php echo $c->is_active ? 'Oui' : 'Non'; ?>
                                        </span>
                                    </td>
                                    <td class="tw-px-4 tw-py-3">
                                        <div class="tw-flex tw-items-center tw-gap-2">
                                            <a href="#" class="tw-p-1.5 tw-rounded-lg tw-text-gray-500 hover:tw-bg-gray-100 hover:tw-text-blue-600 tw-transition-colors edit-coord" data-id="<?php echo $c->id; ?>" data-branch="<?php echo $c->branch_id; ?>" data-label="<?php echo htmlspecialchars($c->label); ?>" data-account="<?php echo htmlspecialchars($c->account_identifier); ?>" data-currency="<?php echo htmlspecialchars($c->currency ?? ''); ?>"><i data-lucide="pencil" class="tw-w-4 tw-h-4"></i></a>
                                            <a href="#" class="tw-p-1.5 tw-rounded-lg tw-text-gray-500 hover:tw-bg-red-50 hover:tw-text-red-600 tw-transition-colors delete-coord" data-id="<?php echo $c->id; ?>"><i data-lucide="trash-2" class="tw-w-4 tw-h-4"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr><td colspan="6" class="tw-px-4 tw-py-8 tw-text-center tw-text-gray-400">Aucune coordonnée. Cliquez sur &laquo; Ajouter &raquo;.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php include 'views/inc/footer.php'; ?>
        </div>
    </div>

    <!-- Modal Ajouter -->
    <div class="modal fade" id="modalAddCoordinate" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une coordonnée de paiement</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="formAddCoordinate">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Agence</label>
                            <select name="branch_id" class="form-control" required>
                                <option value="">-- Choisir --</option>
                                <?php foreach ($branches as $b): ?>
                                <option value="<?php echo $b->id; ?>"><?php echo htmlspecialchars($b->name_branch); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Libellé (ex: M-Pesa, Airtel Money, Virement SEPA)</label>
                            <input type="text" name="label" class="form-control" required placeholder="M-Pesa">
                        </div>
                        <div class="form-group">
                            <label>Numéro / Compte</label>
                            <input type="text" name="account_identifier" class="form-control" required placeholder="+243 XXX XXX XXX">
                        </div>
                        <div class="form-group">
                            <label>Devise (optionnel)</label>
                            <input type="text" name="currency" class="form-control" placeholder="USD, CDF, XAF, EUR">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Modifier -->
    <div class="modal fade" id="modalEditCoordinate" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier la coordonnée</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="formEditCoordinate">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Agence</label>
                            <select name="branch_id" id="edit_branch_id" class="form-control" required>
                                <?php foreach ($branches as $b): ?>
                                <option value="<?php echo $b->id; ?>"><?php echo htmlspecialchars($b->name_branch); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Libellé</label>
                            <input type="text" name="label" id="edit_label" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Numéro / Compte</label>
                            <input type="text" name="account_identifier" id="edit_account_identifier" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Devise</label>
                            <input type="text" name="currency" id="edit_currency" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="dataJs/agency_payment_coordinates.js"></script>
</body>
</html>
