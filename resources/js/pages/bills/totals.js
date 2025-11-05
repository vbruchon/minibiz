export function updateTotals(hasVAT, vatRate) {
    let subtotal = 0;

    document.querySelectorAll("[data-line]").forEach((line) => {
        const quantity = parseFloat(
            line.querySelector('[name$="[quantity]"]')?.value || 0
        );
        const unitPrice = parseFloat(
            line.querySelector('[name$="[unit_price]"]')?.value || 0
        );
        let lineTotal = quantity * unitPrice;

        line.querySelectorAll(
            'input[type="checkbox"]:checked, input[type="radio"]:checked'
        ).forEach((opt) => {
            lineTotal += parseFloat(opt.dataset.price || 0);
        });

        subtotal += lineTotal;
    });

    const discountRate = parseFloat(
        document.querySelector('[name="discount_percentage"]')?.value || 0
    );
    const discount = subtotal * (discountRate / 100);
    const base = subtotal - discount;
    const vat = hasVAT && vatRate > 0 ? base * (vatRate / 100) : 0;
    const total = base + vat;

    document.getElementById("subtotal").textContent =
        subtotal.toFixed(2) + " €";
    document.getElementById("discount-value").textContent =
        "-" + discount.toFixed(2) + " €";
    if (hasVAT)
        document.getElementById("vat").textContent = vat.toFixed(2) + " €";
    document.getElementById("total").textContent = total.toFixed(2) + " €";
}
