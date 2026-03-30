function isMobile() {
    return window.innerWidth < 576;
}

function getFontSizes() {
    return {
        title: isMobile() ? "16px" : "20px",
        text: isMobile() ? "13px" : "15px",
        button: isMobile() ? "13px" : "14px",
    };
}

document.querySelectorAll(".delete-asset-btn").forEach((btn) => {
    btn.addEventListener("click", (e) => {
        e.preventDefault();

        const deleteUrl = btn.dataset.url;

        // 🔥 Better: use data attribute instead of DOM guessing
        const itemName = btn.dataset.name || "this asset";

        const fontSizes = getFontSizes();

        Swal.fire({
            title: "Delete Asset?",
            html: `
                Are you sure you want to delete <b>${itemName}</b>?<br>
                <small class="text-muted">This action cannot be undone.</small>
            `,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Delete",
            cancelButtonText: "Cancel",
            reverseButtons: true,
            focusCancel: true,
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d",

            customClass: {
                popup: "swal-rounded",
                title: "swal-title-responsive",
                htmlContainer: "swal-text-responsive",
                confirmButton: "swal-btn-responsive",
                cancelButton: "swal-btn-responsive",
            },

            didOpen: () => {
                const title = Swal.getTitle();
                const text = Swal.getHtmlContainer();
                const buttons = Swal.getActions().querySelectorAll("button");

                if (title) title.style.fontSize = fontSizes.title;
                if (text) text.style.fontSize = fontSizes.text;
                buttons.forEach(
                    (btn) => (btn.style.fontSize = fontSizes.button),
                );
            },
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Deleting...",
                    text: "Please wait",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });

                const form = document.createElement("form");
                form.method = "POST";
                form.action = deleteUrl;

                // CSRF
                const token = document.createElement("input");
                token.type = "hidden";
                token.name = "_token";
                token.value = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content");

                // DELETE method
                const method = document.createElement("input");
                method.type = "hidden";
                method.name = "_method";
                method.value = "DELETE";

                form.appendChild(token);
                form.appendChild(method);

                document.body.appendChild(form);
                form.submit();
            }
        });
    });
});
