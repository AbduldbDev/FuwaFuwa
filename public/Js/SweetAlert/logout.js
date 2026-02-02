const logoutBtn = document.getElementById("logoutBtn");
logoutBtn.addEventListener("click", () => {
    const logoutUrl = logoutBtn.dataset.logout;

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
