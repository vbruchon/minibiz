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

    const totals = calculateTotals(hasVAT, vatRate);
    updateTotalsDisplay(totals, hasVAT);

    initTotalsRecalculation(hasVAT, vatRate);
});
