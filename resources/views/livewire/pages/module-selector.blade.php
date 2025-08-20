<div>
    <style>
        .module-card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
            height: 100%;
        }

        .module-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }

        .module-card .icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
        }

        .module-card .module-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .module-card .module-description {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 1.5rem;
        }

        .module-card .btn {
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
        }

        .icon-bids { color: #007bff; }
        .icon-supplies { color: #6610f2; }
        .icon-docs { color: #28a745; }
        .icon-csm { color: #ffc107; }
        .icon-hr { color: #dc3545; }
        .icon-finance { color: #17a2b8; }
        .icon-ict { color: #343a40; }
        .icon-issuances { color: #fd7e14; }

    </style>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Modules</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Modules</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="module-card">
                            <i class="fas fa-gavel icon icon-bids"></i>
                            <h5 class="module-title">Bids and Awards</h5>
                            <p class="module-description">Manage procurement processes and awards.</p>
                            <a href="#" class="btn btn-outline-primary disabled">Coming Soon</a>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="module-card">
                            <i class="fas fa-box-open icon icon-supplies"></i>
                            <h5 class="module-title">Supplies</h5>
                            <p class="module-description">Track and manage office supplies.</p>
                            <a href="#" class="btn btn-outline-secondary disabled">Coming Soon</a>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="module-card">
                            <i class="fas fa-file-signature icon icon-docs"></i>
                            <h5 class="module-title">Document Tracking</h5>
                            <p class="module-description">Trace and monitor official documents.</p>
                            <a href="{{ route('document-tracking-dashboard') }}" class="btn btn-success">Go to Module</a>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="module-card">
                            <i class="fas fa-smile-beam icon icon-csm"></i>
                            <h5 class="module-title">Client Satisfaction</h5>
                            <p class="module-description">Measure and analyze client feedback.</p>
                            <a href="{{ route('css-results', ['param' => 2025]) }}" class="btn btn-warning">Go to Module</a>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="module-card">
                            <i class="fas fa-users-cog icon icon-hr"></i>
                            <h5 class="module-title">Human Resource</h5>
                            <p class="module-description">Manage employee information and services.</p>
                            <a href="#" class="btn btn-outline-danger disabled">Coming Soon</a>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="module-card">
                            <i class="fas fa-file-invoice-dollar icon icon-finance"></i>
                            <h5 class="module-title">Finance</h5>
                            <p class="module-description">Handle financial records and transactions.</p>
                            <a href="#" class="btn btn-outline-info disabled">Coming Soon</a>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="module-card">
                            <i class="fas fa-headset icon icon-ict"></i>
                            <h5 class="module-title">ICT Requests</h5>
                            <p class="module-description">Submit and track IT service requests.</p>
                            <a href="{{ route('list-ict-requests') }}" class="btn btn-dark">Go to Module</a>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="module-card">
                            <i class="fas fa-bullhorn icon icon-issuances"></i>
                            <h5 class="module-title">Issuances</h5>
                            <p class="module-description">Disseminate official announcements.</p>
                            <a href="{{ route('list-issuances') }}" class="btn btn-orange">Go to Module</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
