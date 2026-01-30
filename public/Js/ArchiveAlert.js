document.querySelectorAll(".delete-btn").forEach((btn) => {
    btn.addEventListener("click", (e) => {
        e.preventDefault();

        const deleteUrl = btn.dataset.url;

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

                // DELETE method spoofing
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
