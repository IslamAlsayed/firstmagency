@extends('dashboard.layout')

@section('title', __('dashboard.content'))
@section('page-title', '📝 ' . __('dashboard.content_management'))

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h5><i class="fas fa-file-alt"></i> {{ __('dashboard.available_content') }}</h5>
                </div>
                <div class="dashboard-card-body">
                    <div class="list-group">
                        <!-- Services -->
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1"><i class="fas fa-cogs"></i> {{ __('dashboard.services') }}</h6>
                                    <small class="text-muted">{{ __('dashboard.services_management') }}</small>
                                </div>
                                <span class="badge bg-primary">{{ __('dashboard.available') }}</span>
                            </div>
                        </a>

                        <!-- Articles -->
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1"><i class="fas fa-newspaper"></i> {{ __('dashboard.articles') }}</h6>
                                    <small class="text-muted">{{ __('dashboard.articles_management') }}</small>
                                </div>
                                <span class="badge bg-primary">{{ __('dashboard.available') }}</span>
                            </div>
                        </a>

                        <!-- Clients -->
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1"><i class="fas fa-building"></i> {{ __('dashboard.clients') }}</h6>
                                    <small class="text-muted">{{ __('dashboard.clients_management') }}</small>
                                </div>
                                <span class="badge bg-primary">{{ __('dashboard.available') }}</span>
                            </div>
                        </a>

                        <!-- Portfolio -->
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1"><i class="fas fa-images"></i> {{ __('dashboard.portfolio') }}</h6>
                                    <small class="text-muted">{{ __('dashboard.portfolio_management') }}</small>
                                </div>
                                <span class="badge bg-primary">{{ __('dashboard.available') }}</span>
                            </div>
                        </a>

                        @if (auth()->user()->canManageSettings())
                            <!-- FAQ Management -->
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1"><i class="fas fa-question-circle"></i> {{ __('dashboard.faqs') }}</h6>
                                        <small class="text-muted">{{ __('dashboard.faqs_management') }}</small>
                                    </div>
                                    <span class="badge bg-primary">{{ __('dashboard.available') }}</span>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- معلومات إضافية -->
            <div class="dashboard-card mt-4">
                <div class="dashboard-card-header">
                    <h5><i class="fas fa-info-circle"></i> {{ __('dashboard.important_info') }}</h5>
                </div>
                <div class="dashboard-card-body">
                    <div class="alert alert-info" role="alert">
                        <strong>💡 {{ __('dashboard.tip') }}:</strong> {{ __('dashboard.tip_content') }}
                    </div>

                    @if (auth()->user()->canRollback())
                        <div class="alert alert-warning" role="alert">
                            <strong>⚠️ {{ __('dashboard.warning') }}:</strong> {{ __('dashboard.warning_rollback') }}
                        </div>
                    @endif

                    @if (auth()->user()->canManageSettings())
                        <div class="alert alert-success" role="alert">
                            <strong>✅ {{ __('dashboard.advanced_permissions') }}:</strong> {{ __('dashboard.admin_access') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
