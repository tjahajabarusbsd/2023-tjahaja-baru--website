$(function () {
    const $root = $("#specs-list");
    const endpoint = $root.data("specUrl");
    const $selects = $root.find("select[data-slot]");
    const $error = $("#compare-error");

    const cache = new Map(); // id -> jqXHR promise
    const latest = {}; // slot -> id terakhir yang dipilih

    function fetchSpec(id) {
        if (!cache.has(id)) {
            const req = $.getJSON(`${endpoint}/${id}`);
            req.fail(() => cache.delete(id)); // jangan cache kegagalan
            cache.set(id, req);
        }
        return cache.get(id);
    }

    function render(slot, data) {
        const specs = data ? data.specs : {};

        $root.find(`td[data-spec][data-slot="${slot}"]`).each(function () {
            $(this).text(specs[this.dataset.spec] ?? "-");
        });

        const $img = $(`#thumbnail${slot}`);
        if (data && data.thumbnail) {
            $img.attr({ src: data.thumbnail, alt: data.name }).removeClass(
                "d-none"
            );
        } else {
            $img.addClass("d-none").removeAttr("src").attr("alt", "");
        }
    }

    function setLoading(slot, isLoading) {
        $root
            .find(`td[data-slot="${slot}"]`)
            .toggleClass("opacity-50", isLoading);
    }

    // Produk yang sudah dipilih di satu kolom tidak bisa dipilih di kolom lain
    function syncOptions() {
        $selects.each(function () {
            const otherValue = $selects.not(this).val();
            $(this)
                .find("option")
                .each(function () {
                    if (this.value) this.disabled = this.value === otherValue;
                });
        });
    }

    function load(slot, id) {
        latest[slot] = id;
        $error.addClass("d-none");
        setLoading(slot, true);

        fetchSpec(id)
            .done((data) => {
                if (latest[slot] === id) render(slot, data);
            })
            .fail(() => {
                if (latest[slot] !== id) return;
                render(slot, null);
                $error.removeClass("d-none");
            })
            .always(() => {
                if (latest[slot] === id) setLoading(slot, false);
            });
    }

    $selects.on("change", function () {
        syncOptions();
        load(this.dataset.slot, this.value);
    });
});
