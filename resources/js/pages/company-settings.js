function initVisualIdentity() {
    const dropzone = document.getElementById("logo-dropzone");
    const fileInput = document.getElementById("logo_file");
    const logoUrlInput = document.getElementById("logo_url");
    const preview = document.getElementById("logo-preview");

    if (!dropzone || !fileInput || !preview) return;

    const setPreviewWithSrc = (src) => {
        preview.innerHTML = `
      <img 
        src="${src}" 
        alt="Aperçu du logo"
        class="h-32 object-contain transition-transform duration-300 hover:scale-105" 
      />
    `;
    };

    const handleFile = (file) => {
        const reader = new FileReader();
        reader.onload = (e) => setPreviewWithSrc(e.target.result);
        reader.readAsDataURL(file);
    };

    // === Drag & Drop ===
    dropzone.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropzone.classList.add("border-primary/60");
    });

    dropzone.addEventListener("dragleave", () => {
        dropzone.classList.remove("border-primary/60");
    });

    dropzone.addEventListener("drop", (e) => {
        e.preventDefault();
        dropzone.classList.remove("border-primary/60");
        const file = e.dataTransfer.files[0];
        if (file) {
            fileInput.files = e.dataTransfer.files;
            handleFile(file);
            if (logoUrlInput) logoUrlInput.value = "";
        }
    });

    fileInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (file) {
            handleFile(file);
            if (logoUrlInput) logoUrlInput.value = "";
        }
    });

    if (logoUrlInput) {
        const handleUrlPreview = () => {
            const url = logoUrlInput.value.trim();
            if (!url) return;

            if (url.startsWith("http://") || url.startsWith("https://")) {
                setPreviewWithSrc(url);
            }
        };

        logoUrlInput.addEventListener("input", handleUrlPreview);
        logoUrlInput.addEventListener("blur", handleUrlPreview);
    }
}

function initBusinessTypeSwitch() {
    const businessTypeSelect = document.querySelector(
        'select[name="business_type"]'
    );
    const vatInput = document.querySelector("#vat");
    const taxRateInput = document.querySelector("#tax-rate");
    const footerTextarea = document.querySelector(
        'textarea[name="footer_note"]'
    );

    const AUTO_TEXT = "TVA non applicable, article 293 B du CGI.";

    if (!businessTypeSelect) return;

    const handleBusinessTypeChange = () => {
        const businessType = businessTypeSelect.value;

        vatInput?.classList.toggle("hidden", businessType === "auto");
        vatInput?.classList.toggle("block", businessType !== "auto");
        taxRateInput?.classList.toggle("hidden", businessType === "auto");
        taxRateInput?.classList.toggle("block", businessType !== "auto");

        if (footerTextarea) {
            if (businessType === "auto") {
                footerTextarea.value = AUTO_TEXT;
                footerTextarea.placeholder = "";
            } else {
                if (footerTextarea.value === AUTO_TEXT)
                    footerTextarea.value = "";
                footerTextarea.placeholder =
                    "Ex : SARL Dupont – Capital 5 000 € – RCS Valence 123 456 789";
            }
        }
    };

    businessTypeSelect.addEventListener("change", handleBusinessTypeChange);

    handleBusinessTypeChange();
}

document.addEventListener("DOMContentLoaded", () => {
    initVisualIdentity();
    initBusinessTypeSwitch();
});
