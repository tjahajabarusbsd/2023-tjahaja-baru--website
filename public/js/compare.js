$(document).ready(function () {
    function updateTableCell(row, column, data) {
        $(`tbody tr:nth-child(${row}) td:nth-child(${column})`).text(data);
    }

    function updateImageSrc(column, src) {
        $(`#thumbnailImage${column}`).attr('src', src);
    }

    function updateData(selectedValue, targetColumn) {
        $.ajax({
            url: `/get_spec_details/${selectedValue}`,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                updateTableCell(2, targetColumn, data.p_l_t);
                updateTableCell(3, targetColumn, data.jarak_sumbu_roda);
                updateTableCell(4, targetColumn, data.ground_clearence);
                updateTableCell(5, targetColumn, data.tinggi_tempat_duduk);
                updateTableCell(6, targetColumn, data.berat_isi);
                updateTableCell(7, targetColumn, data.volume_tangki);
                updateTableCell(8, targetColumn, data.volume_bagasi);
                updateTableCell(9, targetColumn, data.tipe_rangka);
                updateTableCell(10, targetColumn, data.suspensi_depan);
                updateTableCell(11, targetColumn, data.suspensi_belakang);
                updateTableCell(12, targetColumn, data.tipe_ban);
                updateTableCell(13, targetColumn, data.ban_depan);
                updateTableCell(14, targetColumn, data.ban_belakang);
                updateTableCell(15, targetColumn, data.rem_depan);
                updateTableCell(16, targetColumn, data.rem_belakang);
                updateTableCell(17, targetColumn, data.rem_abs);
                updateTableCell(18, targetColumn, data.kapasitas);
                updateTableCell(19, targetColumn, data.pendingin);
                updateTableCell(20, targetColumn, data.d_x_l);
                updateTableCell(21, targetColumn, data.rasio_kompresi);
                updateTableCell(22, targetColumn, data.daya_maksimum);
                updateTableCell(23, targetColumn, data.torsi_maksimum);
                updateTableCell(24, targetColumn, data.sistem_starter);
                updateTableCell(25, targetColumn, data.kapasitas_oli_mesin);
                updateTableCell(26, targetColumn, data.sistem_bbm);
                updateTableCell(27, targetColumn, data.tipe_kopling);
                updateTableCell(28, targetColumn, data.tipe_transmisi);
                updateTableCell(29, targetColumn, data.sistem_pengapian);
                updateTableCell(30, targetColumn, data.baterai);
                updateTableCell(31, targetColumn, data.busi);
                updateTableCell(32, targetColumn, data.price);
                updateImageSrc(targetColumn, data.thumbnail);
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }

    $('#produk1').change(function () {
        updateData($(this).val(), 2);
    });

    $('#produk2').change(function () {
        updateData($(this).val(), 3);
    });
});