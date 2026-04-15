<style>
    .role-mobile-content .container.mt-5 > .btn,
    .role-mobile-content .container.mt-5 .btn-group-mobile > .btn {
        margin-bottom: 8px;
    }

    .role-mobile-content .card {
        border-radius: 14px;
    }

    .role-mobile-content .card-header h4 {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 0;
    }

    .role-mobile-content .card-header h4 .btn {
        flex-shrink: 0;
    }

    .role-mobile-content .role-table-scroll {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .role-mobile-content .role-table-scroll table {
        min-width: 640px;
    }

    .role-mobile-content .role-form-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .role-mobile-content .permission-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    @media (max-width: 575.98px) {
        .role-mobile-content .container.mt-5 {
            margin-top: 1rem !important;
        }

        .role-mobile-content .container.mt-5 > .btn,
        .role-mobile-content .container.mt-5 .btn-group-mobile > .btn {
            display: block;
            width: 100%;
            margin: 0 0 10px 0 !important;
        }

        .role-mobile-content .card-header h4 {
            flex-direction: column;
            align-items: stretch;
        }

        .role-mobile-content .card-header h4 .btn {
            width: 100%;
            text-align: center;
        }

        .role-mobile-content .role-form-actions {
            flex-direction: column;
        }

        .role-mobile-content .role-form-actions .btn,
        .role-mobile-content form .btn,
        .role-mobile-content .permission-section-header .btn,
        .role-mobile-content #selectAllBtn {
            width: 100%;
        }

        .role-mobile-content .permission-section-header {
            flex-direction: column;
            align-items: stretch;
        }

        .role-mobile-content .card-body {
            padding: 14px;
        }

        .role-mobile-content .card-header {
            padding: 14px;
        }
    }
</style>
