export function calculateTotals(hasVAT, vatRate) {
    let subtotal = 0;

    document.querySelectorAll("[data-line]").forEach((line) => {
        const quantity = parseFloat(
            line.querySelector('[name$="[quantity]"]')?.value || 0
        );
        const unitPrice = parseFloat(
            line.querySelector('[name$="[unit_price]"]')?.value || 0
        );
        let lineTotal = quantity * unitPrice;

        // Add selected option prices
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

    return { subtotal, discount, vat, total };
}

export function updateTotalsDisplay(totalsData, hasVAT) {
    const { subtotal, discount, vat, total } = totalsData;

    const subtotalElement = document.getElementById("subtotal");
    const discountElement = document.getElementById("discount-value");
    const vatElement = document.getElementById("vat");
    const totalElement = document.getElementById("total");

    if (subtotalElement)
        subtotalElement.textContent = `${subtotal.toFixed(2)} €`;
    if (discountElement)
        discountElement.textContent = `-${discount.toFixed(2)} €`;
    if (hasVAT && vatElement) vatElement.textContent = `${vat.toFixed(2)} €`;
    if (totalElement) totalElement.textContent = `${total.toFixed(2)} €`;
}

export function initTotalsRecalculation(hasVAT, vatRate) {
    document.addEventListener("input", (e) => {
        if (
            e.target.matches(
                '[name$="[unit_price]"], [name$="[quantity]"], [name="discount_percentage"], input[type="checkbox"], input[type="radio"]'
            )
        ) {
            const totals = calculateTotals(hasVAT, vatRate);
            updateTotalsDisplay(totals, hasVAT);
        }
    });

    const initialTotals = calculateTotals(hasVAT, vatRate);
    updateTotalsDisplay(initialTotals, hasVAT);
}
