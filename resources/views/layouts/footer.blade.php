
<footer class="app-footer"> <!--begin::To the end-->
    <div class="float-end d-none d-sm-inline">Sisitem Informasi Pengarsipan</div> <!--end::To the end--> <!--begin::Copyright--> <strong>
        Copyright &copy; 2024&nbsp;
        <a href="/" class="text-decoration-none">CV XYZ</a>.
    </strong>
    All rights reserved.
    <!--end::Copyright-->
</footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
<script src="../../dist/js/adminlte.js"></script> <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
<script>
const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
const Default = {
    scrollbarTheme: "os-theme-light",
    scrollbarAutoHide: "leave",
    scrollbarClickScroll: true,
};
document.addEventListener("DOMContentLoaded", function() {
    const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
    if (
        sidebarWrapper &&
        typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
    ) {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
                theme: Default.scrollbarTheme,
                autoHide: Default.scrollbarAutoHide,
                clickScroll: Default.scrollbarClickScroll,
            },
        });
    }
});
</script> <!--end::OverlayScrollbars Configure--> <!-- OPTIONAL SCRIPTS --> <!-- sortablejs -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ=" crossorigin="anonymous"></script> <!-- sortablejs -->
<script>
const connectedSortables =
    document.querySelectorAll(".connectedSortable");
connectedSortables.forEach((connectedSortable) => {
    let sortable = new Sortable(connectedSortable, {
        group: "shared",
        handle: ".card-header",
    });
});

const cardHeaders = document.querySelectorAll(
    ".connectedSortable .card-header",
);
cardHeaders.forEach((cardHeader) => {
    cardHeader.style.cursor = "move";
});
</script> 
<script type="text/javascript">
    let timeout;

    function resetTimer() {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            // Redirect ke halaman logout
            window.location.href = "{{ route('logout') }}"; 
        }, 900000); 
    }

    // Reset timer saat ada aktivitas mouse atau keyboard
    document.addEventListener('mousemove', resetTimer);
    document.addEventListener('keydown', resetTimer);

    // Jalankan timer saat halaman pertama kali dimuat
    resetTimer();
</script>

<!--end::Script-->
</body>
</html>

<!--begin::Footer-->

