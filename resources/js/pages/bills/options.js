export function renderProductOptions(container, product, productId) {
    container.innerHTML = "";

    // Cas 1 : produit avec options
    if (product.type === "package") {
        const opts = product.options || [];
        const optionTpl = document.getElementById("bill-option-template");
        const valueTpl = document.getElementById("bill-option-value-template");
        const gridWrapper = document.createElement("div");
        gridWrapper.className =
            "grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4";

        const singleChoice = [
            "Hébergement",
            "Support technique",
            "Maintenance annuelle",
            "Nombre de produits",
            "Système de paiement",
        ];

        opts.forEach((opt) => {
            const fieldset = optionTpl.content.cloneNode(true);
            fieldset.querySelector("[data-option-name]").textContent = opt.name;
            const valuesContainer = fieldset.querySelector(
                "[data-option-values]"
            );
            const isSingle = singleChoice.includes(opt.name);

            opt.values.forEach((v) => {
                let html = valueTpl.innerHTML
                    .replace("{type}", isSingle ? "radio" : "checkbox")
                    .replace(
                        "{name}",
                        isSingle
                            ? `option_${opt.name
                                  .replace(/\s+/g, "_")
                                  .toLowerCase()}_${productId}`
                            : "lines[][options][]"
                    )
                    .replace("{value}", v.id)
                    .replace("{price}", v.price)
                    .replace("{checked}", v.is_default ? "checked" : "")
                    .replace(
                        "{label}",
                        `${v.value}${
                            v.price > 0 ? " (+" + v.price + " €)" : ""
                        }`
                    );
                valuesContainer.insertAdjacentHTML("beforeend", html);
            });

            gridWrapper.appendChild(fieldset);
        });

        container.appendChild(gridWrapper);
    }

    // Cas 2 : produit standard → champ description
    else {
        const desc = document.createElement("textarea");
        desc.name = "lines[][description]";
        desc.rows = 3;
        desc.placeholder = "Description du produit...";
        desc.className =
            "w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition";
        container.appendChild(desc);
    }
}
