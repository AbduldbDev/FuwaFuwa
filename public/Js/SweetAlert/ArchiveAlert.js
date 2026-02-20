function isMobile() {
    return window.innerWidth < 576;
}

function getFontSizes() {
    return {
        title: isMobile() ? "18px" : "22px",
        text: isMobile() ? "13px" : "16px",
        button: isMobile() ? "13px" : "16px",
    };
}

document.querySelectorAll(".delete-btn").forEach((btn) => {
    btn.addEventListener("click", (e) => {
        e.preventDefault();

        const deleteUrl = btn.dataset.url;
        const fontSizes = getFontSizes();

        Swal.fire({
            title: "Delete This Item?",
            text: "This action cannot be undone.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete",
            cancelButtonText: "Cancel",
            reverseButtons: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",

            customClass: {
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
                const form = document.createElement("form");
                form.method = "POST";
                form.action = deleteUrl;

                // CSRF token
                const token = document.createElement("input");
                token.type = "hidden";
                token.name = "_token";
                token.value = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content");

                const method = document.createElement("input");
                method.type = "hidden";
                method.name = "_method";
                method.value = "POST";

                form.appendChild(token);
                form.appendChild(method);

                document.body.appendChild(form);
                form.submit();
            }
        });
    });
});
