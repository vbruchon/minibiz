import { renderProductOptions } from "./options";
import { calculateTotals, updateTotalsDisplay } from "./totals";

export function initQuoteLineEvents(
    productPrices,
    productOptions,
    hasVAT,
    vatRate
) {
    document
        .querySelectorAll('[name^="lines"][name$="[product_id]"]')
        .forEach((select) => {
            select.removeEventListener("change", onProductChange);
            select.addEventListener("change", (e) =>
                onProductChange(
                    e,
                    productPrices,
                    productOptions,
                    hasVAT,
                    vatRate
                )
            );
        });
}

export function setupLineActions() {
    const addProduct = document.querySelector("#addProduct");
    if (addProduct) {
        addProduct.addEventListener("click", () => addQuoteLine());
    }

    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("remove-line")) {
            const line = e.target.closest("[data-line]");
            if (line) line.remove();
            const totals = calculateTotals(window.hasVAT, window.vatRate);
            updateTotalsDisplay(totals, window.hasVAT);
        }
    });
}

export function addQuoteLine() {
    const container = document.getElementById("quote-lines");
    const tpl = document.getElementById("bill-line-template").innerHTML;
    const index = container.querySelectorAll("[data-line]").length;

    const html = tpl.replaceAll("{lineIndex}", index);
    const wrapper = document.createElement("div");
    wrapper.innerHTML = html.trim();
    container.appendChild(wrapper.firstElementChild);

    initQuoteLineEvents(
        window.productPrices,
        window.productOptions,
        window.hasVAT,
        window.vatRate
    );

    const totals = calculateTotals(window.hasVAT, window.vatRate);
    updateTotalsDisplay(totals, window.hasVAT);
}

function onProductChange(e, productPrices, productOptions, hasVAT, vatRate) {
    const productId = e.target.value;
    const grid = e.target.closest(".grid");
    const priceInput = grid.querySelector(
        '[name^="lines"][name$="[unit_price]"]'
    );
    const qtyInput = grid.querySelector('[name^="lines"][name$="[quantity]"]');
    const lineWrapper = grid.closest("[data-line]");
    const optionsContainer = lineWrapper.querySelector(
        "[data-options-container]"
    );
    const lineIndex = lineWrapper.dataset.lineIndex;

    if (priceInput) priceInput.value = productPrices[productId] ?? 0;
    if (qtyInput) qtyInput.value = 1;

    const product = productOptions[productId];
    if (!product) return;

    renderProductOptions(optionsContainer, product, productId, lineIndex);

    const totals = calculateTotals(hasVAT, vatRate);
    updateTotalsDisplay(totals, hasVAT);
}
