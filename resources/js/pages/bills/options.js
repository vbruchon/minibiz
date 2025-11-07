export function renderProductOptions(container, product, productId, lineIndex) {
    container.innerHTML = "";

    if (!product || product.type !== "package") {
        renderSimpleProduct(container, lineIndex);
        return;
    }

    const model = document.querySelector("#bill-option-model fieldset");
    const gridWrapper = createGridWrapper();

    const opts = product.options || [];
    opts.forEach((opt, optIndex) => {
        const fieldset = renderOptionGroup(opt, optIndex, model, lineIndex);
        gridWrapper.appendChild(fieldset);
    });

    container.appendChild(gridWrapper);
}

function renderSimpleProduct(container, lineIndex) {
    const desc = document.createElement("textarea");
    desc.name = `lines[${lineIndex}][description]`;
    desc.rows = 3;
    desc.placeholder = "Description du produit...";
    desc.className =
        "w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition";
    container.appendChild(desc);
}

function createGridWrapper() {
    const div = document.createElement("div");
    div.className = "grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4";
    return div;
}

function renderOptionGroup(opt, optIndex, model, lineIndex) {
    const singleChoice = [
        "Hébergement",
        "Support technique",
        "Maintenance annuelle",
        "Nombre de produits",
        "Système de paiement",
    ];

    const isSingle = singleChoice.includes(opt.name);
    const name = isSingle
        ? `lines[${lineIndex}][selected_options][group_${optIndex}]`
        : `lines[${lineIndex}][selected_options][group_${optIndex}][]`;

    const fieldset = model.cloneNode(true);
    const legend = fieldset.querySelector("[data-option-name]");
    const valuesContainer = fieldset.querySelector("[data-option-values]");
    const labelTemplate = fieldset.querySelector("[data-option-value]");

    legend.textContent = opt.name;
    valuesContainer.innerHTML = "";

    opt.values.forEach((value) => {
        const label = renderOptionValue(labelTemplate, value, name, isSingle);
        valuesContainer.insertAdjacentHTML("beforeend", label);
    });

    return fieldset;
}

function renderOptionValue(labelTemplate, value, name, isSingle) {
    return labelTemplate.outerHTML
        .replace("{type}", isSingle ? "radio" : "checkbox")
        .replace("{name}", name)
        .replace("{value}", value.id)
        .replace("{price}", value.price)
        .replace("{checked}", value.is_default ? "checked" : "")
        .replace(
            "{label}",
            `${value.value}${
                value.price > 0 ? ` (+${Number(value.price).toFixed(2)} €)` : ""
            }`
        );
}
