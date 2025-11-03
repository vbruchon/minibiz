export function updateTotals(hasVAT, vatRate) {
    let subtotal = 0;

    document.querySelectorAll("[data-line]").forEach((line) => {
        const q = parseFloat(
            line.querySelector('[name$="[quantity]"]')?.value || 0
        );
        const p = parseFloat(
            line.querySelector('[name$="[unit_price]"]')?.value || 0
        );
        let lineTotal = q * p;

        // ✅ Prix des options sélectionnées
        line.querySelectorAll(
            'input[type="checkbox"]:checked, input[type="radio"]:checked'
        ).forEach((opt) => {
            const optPrice = parseFloat(opt.dataset.price || 0);
            lineTotal += optPrice;
        });

        subtotal += lineTotal;
    });

    const rate = parseFloat(
        document.querySelector('[name="discount"]')?.value || 0
    );
    const discount = subtotal * (rate / 100);
    let vat = 0;

    if (hasVAT && vatRate > 0) {
        vat = (subtotal - discount) * (vatRate / 100);
    }

    const total = subtotal - discount + vat;

    document.getElementById("subtotal").textContent =
        subtotal.toFixed(2) + " €";
    document.getElementById("discount-value").textContent =
        "-" + discount.toFixed(2) + " €";
    if (hasVAT)
        document.getElementById("vat").textContent = vat.toFixed(2) + " €";
    document.getElementById("total").textContent = total.toFixed(2) + " €";
}
