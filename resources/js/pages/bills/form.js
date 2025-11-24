import { addQuoteLine, initQuoteLineEvents, setupLineActions } from "./lines";
import {
    calculateTotals,
    initTotalsRecalculation,
    updateTotalsDisplay,
} from "./totals";
import { renderProductOptions } from "./options";

document.addEventListener("DOMContentLoaded", () => {
    const context = loadMetaData();
    if (!context) return;

    setupGlobals(context);
    initializeForm(context);

    if (context.billLines.length > 0) {
        populateEditForm(context);
    } else {
        renderExistingLines(context);
    }

    initQuoteLineEvents(
        context.productPrices,
        context.productOptions,
        context.hasVAT,
        context.vatRate
    );

    setupLineActions();
    updateAllTotals(context);
});

// === Gestion des champs "Autre" / "Personnalisé" ===
document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ Script 'Autre/personnalisé' chargé !");

    const paymentSelect = document.getElementById("payment_terms");
    const paymentCustom = document.getElementById("payment_terms_custom");
    const interestSelect = document.getElementById("interest_rate");
    const interestCustom = document.getElementById("interest_rate_custom");
    console.log({
        paymentSelect,
        paymentCustom,
        interestSelect,
        interestCustom,
    });

    const toggleCustomField = (select, input) => {
        if (!select || !input) return;
        const show = select.value === "other";
        input.classList.toggle("hidden", !show);
        if (!show) input.value = "";
    };

    // Initialisation (utile pour édition)
    toggleCustomField(paymentSelect, paymentCustom);
    toggleCustomField(interestSelect, interestCustom);

    paymentSelect?.addEventListener("change", () =>
        toggleCustomField(paymentSelect, paymentCustom)
    );
    interestSelect?.addEventListener("change", () =>
        toggleCustomField(interestSelect, interestCustom)
    );
});

function loadMetaData() {
    const meta = (name) => document.querySelector(`meta[name="${name}"]`);
    const required = ["prices", "options"];
    if (!required.every((n) => meta(n))) return null;

    return {
        productPrices: JSON.parse(meta("prices")?.content || "{}"),
        productOptions: JSON.parse(meta("options")?.content || "{}"),
        hasVAT: JSON.parse(meta("has-vat")?.content || "false"),
        vatRate: JSON.parse(meta("vat-rate")?.content || "0"),
        billLines: JSON.parse(meta("bill-lines")?.content || "[]"),
    };
}

function setupGlobals(context) {
    window.productPrices = context.productPrices;
    window.productOptions = context.productOptions;
    window.hasVAT = context.hasVAT;
    window.vatRate = context.vatRate;
    window.addQuoteLine = addQuoteLine;
}

function initializeForm(context) {
    document.querySelectorAll("[data-line]").forEach((line, index) => {
        const select = line.querySelector(
            "select[name^='lines'][name$='[product_id]']"
        );
        const productId = select?.value;
        if (!productId) return;

        const product = context.productOptions[productId];
        const container = line.querySelector("[data-options-container]");
        if (product && container) {
            renderProductOptions(container, product, productId, index);
        }
    });
}

function populateEditForm(context) {
    const container = document.getElementById("quote-lines");
    container.innerHTML = "";

    context.billLines.forEach((line, index) => {
        const tpl = document.getElementById("bill-line-template").innerHTML;
        const html = tpl.replaceAll("{lineIndex}", index);
        const wrapper = document.createElement("div");
        wrapper.innerHTML = html.trim();
        const lineElement = wrapper.firstElementChild;

        fillLineData(lineElement, line, index, context.productOptions);
        container.appendChild(lineElement);
    });
}

function renderExistingLines(context) {
    const container = document.getElementById("quote-lines");

    container.innerHTML = "";

    addQuoteLine();

    const totals = calculateTotals(context.hasVAT, context.vatRate);
    updateTotalsDisplay(totals, context.hasVAT);
}

function fillLineData(lineElement, line, index, productOptions) {
    lineElement.dataset.lineId = line.id;

    lineElement.querySelector(
        `select[name="lines[${index}][product_id]"]`
    ).value = line.product_id;

    lineElement.querySelector(`input[name="lines[${index}][quantity]"]`).value =
        line.quantity;

    lineElement.querySelector(
        `input[name="lines[${index}][unit_price]"]`
    ).value = line.unit_price;

    const product = productOptions[line.product_id];
    const container = lineElement.querySelector("[data-options-container]");
    if (!product || !container) return;

    renderProductOptions(container, product, line.product_id, index);

    line.selected_options.forEach((optId) => {
        const input = container.querySelector(`input[value="${optId}"]`);
        if (input) input.checked = true;
    });
}

function updateAllTotals(context) {
    const totals = calculateTotals(context.hasVAT, context.vatRate);
    updateTotalsDisplay(totals, context.hasVAT);
    initTotalsRecalculation(context.hasVAT, context.vatRate);
}
