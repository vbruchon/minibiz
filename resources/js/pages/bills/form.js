import { addQuoteLine, initQuoteLineEvents } from "./lines";
import {
    calculateTotals,
    initTotalsRecalculation,
    updateTotalsDisplay,
} from "./totals";
import { renderProductOptions } from "./options";

document.addEventListener("DOMContentLoaded", () => {
    const metaPrices = document.querySelector('meta[name="prices"]');
    const metaOptions = document.querySelector('meta[name="options"]');
    const metaVAT = document.querySelector('meta[name="has-vat"]');
    const metaRate = document.querySelector('meta[name="vat-rate"]');

    if (!metaPrices || !metaOptions) return;

    const productPrices = JSON.parse(metaPrices.content || "{}");
    const productOptions = JSON.parse(metaOptions.content || "{}");
    const hasVAT = JSON.parse(metaVAT.content || "false");
    const vatRate = JSON.parse(metaRate.content || "0");

    window.productPrices = productPrices;
    window.productOptions = productOptions;
    window.hasVAT = hasVAT;
    window.vatRate = vatRate;
    window.addQuoteLine = addQuoteLine;

    initQuoteLineEvents(productPrices, productOptions, hasVAT, vatRate);

    document.querySelectorAll("[data-line]").forEach((line, index) => {
        const productSelect = line.querySelector(
            "select[name^='lines'][name$='[product_id]']"
        );
        const productId = productSelect?.value;

        if (productId) {
            const product = productOptions[productId];
            const container = line.querySelector("[data-options-container]");
            if (product && container) {
                renderProductOptions(container, product, productId, index);
            }
        }
    });

    // === Mode édition ===
    const metaBillLines = document.querySelector('meta[name="bill-lines"]');
    if (metaBillLines) {
        const billLines = JSON.parse(metaBillLines.content || "[]");
        const container = document.getElementById("quote-lines");

        container.innerHTML = "";

        billLines.forEach((line, index) => {
            const tpl = document.getElementById("bill-line-template").innerHTML;
            const html = tpl.replaceAll("{lineIndex}", index);
            const wrapper = document.createElement("div");
            wrapper.innerHTML = html.trim();
            const lineElement = wrapper.firstElementChild;

            lineElement.dataset.lineId = line.id;
            lineElement.querySelector(
                `select[name="lines[${index}][product_id]"]`
            ).value = line.product_id;

            lineElement.querySelector(
                `input[name="lines[${index}][quantity]"]`
            ).value = line.quantity;

            lineElement.querySelector(
                `input[name="lines[${index}][unit_price]"]`
            ).value = line.unit_price;

            const product = productOptions[line.product_id];
            const optionsContainer = lineElement.querySelector(
                "[data-options-container]"
            );
            if (product && optionsContainer) {
                renderProductOptions(
                    optionsContainer,
                    product,
                    line.product_id,
                    index
                );

                line.selected_options.forEach((optId) => {
                    const input = optionsContainer.querySelector(
                        `input[value="${optId}"]`
                    );
                    if (input) input.checked = true;
                });
            }

            container.appendChild(lineElement);
        });

        initQuoteLineEvents(productPrices, productOptions, hasVAT, vatRate);
        const totals = calculateTotals(hasVAT, vatRate);
        updateTotalsDisplay(totals, hasVAT);
    }

    const totals = calculateTotals(hasVAT, vatRate);
    updateTotalsDisplay(totals, hasVAT);

    initTotalsRecalculation(hasVAT, vatRate);
});
