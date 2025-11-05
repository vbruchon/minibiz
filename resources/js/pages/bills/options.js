export function renderProductOptions(container, product, productId, lineIndex) {
    container.innerHTML = "";

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

        opts.forEach((opt, optIndex) => {
            const fieldset = optionTpl.content.cloneNode(true);
            fieldset.querySelector("[data-option-name]").textContent = opt.name;
            const valuesContainer = fieldset.querySelector(
                "[data-option-values]"
            );
            const isSingle = singleChoice.includes(opt.name);

            const groupName = isSingle
                ? `lines[${lineIndex}][selected_group_${optIndex}]`
                : `lines[${lineIndex}][selected_options][]`;

            opt.values.forEach((v) => {
                const html = valueTpl.innerHTML
                    .replace("{type}", isSingle ? "radio" : "checkbox")
                    .replace("{name}", groupName)
                    .replace("{value}", v.id)
                    .replace("{price}", v.price)
                    .replace("{checked}", v.is_default ? "checked" : "")
                    .replace(
                        "{label}",
                        `${v.value}${
                            v.price > 0
                                ? " (+" + Number(v.price).toFixed(2) + " €)"
                                : ""
                        }`
                    );

                valuesContainer.insertAdjacentHTML("beforeend", html);
            });

            if (isSingle) {
                valuesContainer.addEventListener("change", (e) => {
                    if (e.target.matches('input[type="radio"]')) {
                        container
                            .querySelectorAll(
                                `input[name="lines[${lineIndex}][selected_options][]"][data-group="${optIndex}"]`
                            )
                            .forEach((el) => el.remove());

                        const hiddenInput = document.createElement("input");
                        hiddenInput.type = "hidden";
                        hiddenInput.name = `lines[${lineIndex}][selected_options][]`;
                        hiddenInput.value = e.target.value;
                        hiddenInput.dataset.group = optIndex;
                        container.appendChild(hiddenInput);
                    }
                });
            }

            gridWrapper.appendChild(fieldset);
        });

        container.appendChild(gridWrapper);
    } else {
        const desc = document.createElement("textarea");
        desc.name = `lines[${lineIndex}][description]`;
        desc.rows = 3;
        desc.placeholder = "Description du produit...";
        desc.className =
            "w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition";
        container.appendChild(desc);
    }
}
