@extends('dashboard.layout')

@section('title', __('main.revisions'))
@section('page-title', '📜 ' . __('main.revisions') . ' والـ Revisions')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h5><i class="fas fa-history"></i> {{ __('main.revisions_log') }}</h5>
                </div>
                <div class="dashboard-card-body">
                    <div class="alert alert-info" role="alert">
                        <strong>ℹ️ معلومة:</strong> {{ __('main.revisions_info') }}
                    </div>

                    <!-- Filter Options -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="{{ __('main.search') }} {{ __('main.content') }} أو {{ __('main.name') }}...">
                        </div>
                        <div class="col-md-6">
                            <select class="form-select">
                                <option selected>{{ __('main.all_types') }}</option>
                                <option>{{ __('main.articles') }}</option>
                                <option>{{ __('main.services') }}</option>
                                <option>{{ __('main.clients') }}</option>
                                <option>{{ __('main.portfolio') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Revisions List -->
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ __('main.edit_in') }} {{ __('main.services') }}</h6>
                                    <p class="mb-1 text-muted">{{ __('main.changed') }} "Web Design" description</p>
                                    <small class="text-muted">{{ __('main.by') }}: Ahmed Admin | 26 فبراير 2026 - 14:30</small>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-info">{{ __('main.show_revision') }}</button>
                                    @if (auth()->user()->canRollback())
                                        <button class="btn btn-sm btn-danger">{{ __('main.rollback') }}</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ __('main.create') }} {{ __('main.articles') }}</h6>
                                    <p class="mb-1 text-muted">"كيفية اختيار الخدمات المناسبة"</p>
                                    <small class="text-muted">{{ __('main.by') }}: Content Manager | 26 فبراير 2026 - 10:15</small>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-info">{{ __('main.show_revision') }}</button>
                                    @if (auth()->user()->canRollback())
                                        <button class="btn btn-sm btn-danger">{{ __('main.rollback') }}</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ __('main.edit_in') }} {{ __('main.clients') }}</h6>
                                    <p class="mb-1 text-muted">{{ __('main.update') }} قائمة الشركاء</p>
                                    <small class="text-muted">{{ __('main.by') }}: Ahmed Admin | 25 فبراير 2026 - 16:45</small>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-info">{{ __('main.show_revision') }}</button>
                                    @if (auth()->user()->canRollback())
                                        <button class="btn btn-sm btn-danger">{{ __('main.rollback') }}</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ __('main.update') }} {{ __('main.settings') }}</h6>
                                    <p class="mb-1 text-muted">{{ __('main.changed') }} الألوان الأساسية</p>
                                    <small class="text-muted">{{ __('main.by') }}: Admin | 24 فبراير 2026 - 09:20</small>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-info">{{ __('main.show_revision') }}</button>
                                    @if (auth()->user()->canRollback())
                                        <button class="btn btn-sm btn-danger">{{ __('main.rollback') }}</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation" class="mt-3">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled"><a class="page-link" href="#">{{ __('main.previous') }}</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">{{ __('main.next') }}</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

@endsection
