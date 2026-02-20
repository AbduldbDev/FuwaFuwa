const logoutBtn = document.getElementById("logoutBtn");

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

logoutBtn.addEventListener("click", () => {
    const logoutUrl = logoutBtn.dataset.logout;
    const fontSizes = getFontSizes();

    Swal.fire({
        title: "Log out?",
        text: "You will be signed out of your account.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, log out",
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
            buttons.forEach((btn) => (btn.style.fontSize = fontSizes.button));
        },
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement("form");
            form.method = "POST";
            form.action = logoutUrl;

            const token = document.createElement("input");
            token.type = "hidden";
            token.name = "_token";
            token.value = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");

            form.appendChild(token);
            document.body.appendChild(form);
            form.submit();
        }
    });
});
