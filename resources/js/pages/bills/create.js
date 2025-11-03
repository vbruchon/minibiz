import { addQuoteLine, initQuoteLineEvents } from "./lines";
import { updateTotals } from "./totals";

document.addEventListener("DOMContentLoaded", () => {
    const metaPrices = document.querySelector('meta[name="prices"]');
    const metaOptions = document.querySelector('meta[name="options"]');
    const metaVAT = document.querySelector('meta[name="has-vat"]');
    const metaRate = document.querySelector('meta[name="vat-rate"]');

    if (!metaPrices || !metaOptions) {
        return;
    }

    const productPrices = JSON.parse(metaPrices.content || "{}");
    const productOptions = JSON.parse(metaOptions.content || "{}");
    const hasVAT = JSON.parse(metaVAT.content || "false");
    const vatRate = JSON.parse(metaRate.content || "0");

    const template = document.getElementById("bill-line-template");

    window.productPrices = productPrices;
    window.productOptions = productOptions;
    window.hasVAT = hasVAT;
    window.vatRate = vatRate;
    window.addQuoteLine = addQuoteLine;

    initQuoteLineEvents(productPrices, productOptions, hasVAT, vatRate);
    updateTotals(hasVAT, vatRate);

    document.addEventListener("input", (e) => {
        if (
            e.target.matches(
                '[name$="[unit_price]"], [name$="[quantity]"], [name="discount"], input[type="checkbox"], input[type="radio"]'
            )
        ) {
            updateTotals(hasVAT, vatRate);
        }
    });
});
