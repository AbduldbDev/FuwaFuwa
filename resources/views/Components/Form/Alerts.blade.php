<div id="floatingAlertsContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 1055; min-width: 300px;"></div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('floatingAlertsContainer');

        function showFloatingAlert(message, type = 'success') {
            const colors = {
                success: {
                    border: '#198754',
                    icon: 'fa-check-circle'
                },
                danger: {
                    border: '#dc3545',
                    icon: 'fa-circle-xmark'
                },
                warning: {
                    border: '#ffc107',
                    icon: 'fa-triangle-exclamation'
                },
                info: {
                    border: '#0d6efd',
                    icon: 'fa-info-circle'
                },
            };

            const {
                border,
                icon
            } = colors[type] || colors.info;

            const alert = document.createElement('div');
            alert.className = 'floating-alert shadow rounded d-flex align-items-center mb-2';
            alert.style.cssText = `
            border-left: 6px solid ${border};
            padding: 1rem;
            background-color: rgba(255,255,255,0.85);
            backdrop-filter: blur(6px);
            display: flex;
            opacity: 0;
            transform: translateX(120%);
            transition: all 0.5s ease-in-out;
        `;

            alert.innerHTML = `
            <div class="icon-container me-3 text-${type}">
                <i class="fa-solid ${icon} fa-lg fa-beat"></i>
            </div>
            <div class="alert-message flex-grow-1">${message}</div>
            <button type="button" class="btn-close ms-3" aria-label="Close"></button>
        `;

            container.appendChild(alert);
            requestAnimationFrame(() => {
                alert.style.opacity = 1;
                alert.style.transform = 'translateX(0)';
            });
            const timeout = setTimeout(() => hideAlert(alert), 5000);
            alert.querySelector('.btn-close').addEventListener('click', () => hideAlert(alert, timeout));
        }


        function hideAlert(alert, timeout = null) {
            if (timeout) clearTimeout(timeout);
            alert.style.opacity = 0;
            alert.style.transform = 'translateX(120%)';
            setTimeout(() => alert.remove(), 500);
        }

        @if (session('success'))
            showFloatingAlert("{{ session('success') }}", "success");
        @endif

        @if (session('error'))
            showFloatingAlert("{{ session('error') }}", "danger");
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                showFloatingAlert("{{ $error }}", "danger");
            @endforeach
        @endif
    });
</script>
