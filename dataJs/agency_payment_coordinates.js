"use strict";

$(function () {
    $("#formAddCoordinate").on("submit", function (e) {
        e.preventDefault();
        $.ajax({
            url: "./ajax/tools/agency_payment_coordinate_save_ajax.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (r) {
                if (r.success) {
                    $("#resultados_ajax").html('<div class="alert alert-success">Enregistré.</div>');
                    setTimeout(function () { location.reload(); }, 800);
                } else {
                    $("#resultados_ajax").html('<div class="alert alert-danger">' + (r.message || 'Erreur') + '</div>');
                }
            },
            error: function () {
                $("#resultados_ajax").html('<div class="alert alert-danger">Erreur réseau.</div>');
            }
        });
    });

    $("#formEditCoordinate").on("submit", function (e) {
        e.preventDefault();
        $.ajax({
            url: "./ajax/tools/agency_payment_coordinate_save_ajax.php",
            type: "POST",
            data: $(this).serialize() + "&edit=1",
            dataType: "json",
            success: function (r) {
                if (r.success) {
                    $("#modalEditCoordinate").modal("hide");
                    $("#resultados_ajax").html('<div class="alert alert-success">Modifié.</div>');
                    setTimeout(function () { location.reload(); }, 800);
                } else {
                    $("#resultados_ajax").html('<div class="alert alert-danger">' + (r.message || 'Erreur') + '</div>');
                }
            }
        });
    });

    $(".edit-coord").on("click", function (e) {
        e.preventDefault();
        var id = $(this).data("id"), branch = $(this).data("branch"), label = $(this).data("label"), account = $(this).data("account"), currency = $(this).data("currency") || "";
        $("#edit_id").val(id);
        $("#edit_branch_id").val(branch);
        $("#edit_label").val(label);
        $("#edit_account_identifier").val(account);
        $("#edit_currency").val(currency);
        $("#modalEditCoordinate").modal("show");
    });

    $(".delete-coord").on("click", function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        if (!confirm("Supprimer cette coordonnée ?")) return;
        $.post("./ajax/tools/agency_payment_coordinate_delete_ajax.php", { id: id }, function (r) {
            if (r && r.success) {
                location.reload();
            } else {
                alert(r && r.message ? r.message : "Erreur");
            }
        }, "json");
    });
});
