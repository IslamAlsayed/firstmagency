@extends('dashboard.layout')

@section('title', __('dashboard.sections'))
@section('page-title', '📋 ' . __('dashboard.sections_management'))

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h5><i class="fas fa-th"></i> {{ __('dashboard.sections_management') }}</h5>
                </div>
                <div class="dashboard-card-body">
                    <div class="alert alert-info" role="alert">
                        <strong>ℹ️ معلومة:</strong> {{ __('dashboard.sections_info') }}
                    </div>

                    <!-- Sections List -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('dashboard.section_name') }}</th>
                                    <th>{{ __('dashboard.section_description') }}</th>
                                    <th>{{ __('dashboard.padding') }}</th>
                                    <th>{{ __('dashboard.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>{{ __('dashboard.hero_section') }}</strong></td>
                                    <td>{{ __('dashboard.hero_description') }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ __('dashboard.top_bottom') }}: 60px</span><br>
                                        <span class="badge bg-secondary">{{ __('dashboard.left_right') }}: 30px</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPadding">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('dashboard.services_section') }}</strong></td>
                                    <td>{{ __('dashboard.services_description') }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ __('dashboard.top_bottom') }}: 40px</span><br>
                                        <span class="badge bg-secondary">{{ __('dashboard.left_right') }}: 20px</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPadding">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('dashboard.portfolio') }} {{ __('dashboard.sections') }}</strong></td>
                                    <td>قسم الأعمال</td>
                                    <td>
                                        <span class="badge bg-primary">{{ __('dashboard.top_bottom') }}: 40px</span><br>
                                        <span class="badge bg-secondary">{{ __('dashboard.left_right') }}: 20px</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPadding">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('dashboard.clients') }} {{ __('dashboard.sections') }}</strong></td>
                                    <td>قسم العملاء</td>
                                    <td>
                                        <span class="badge bg-primary">{{ __('dashboard.top_bottom') }}: 40px</span><br>
                                        <span class="badge bg-secondary">{{ __('dashboard.left_right') }}: 20px</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPadding">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Blog {{ __('dashboard.sections') }}</strong></td>
                                    <td>قسم المدونة</td>
                                    <td>
                                        <span class="badge bg-primary">{{ __('dashboard.top_bottom') }}: 40px</span><br>
                                        <span class="badge bg-secondary">{{ __('dashboard.left_right') }}: 20px</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPadding">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Footer {{ __('dashboard.sections') }}</strong></td>
                                    <td>القسم السفلي</td>
                                    <td>
                                        <span class="badge bg-primary">{{ __('dashboard.top_bottom') }}: 30px</span><br>
                                        <span class="badge bg-secondary">{{ __('dashboard.left_right') }}: 15px</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPadding">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Padding Modal -->
    <div class="modal fade" id="editPadding" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('dashboard.edit') }} {{ __('dashboard.padding') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="padding-top" class="form-label">Top Padding (px)</label>
                            <input type="number" id="padding-top" class="form-control" value="40" min="0" max="200">
                        </div>
                        <div class="mb-3">
                            <label for="padding-bottom" class="form-label">Bottom Padding (px)</label>
                            <input type="number" id="padding-bottom" class="form-control" value="40" min="0" max="200">
                        </div>
                        <div class="mb-3">
                            <label for="padding-left" class="form-label">Left Padding (px)</label>
                            <input type="number" id="padding-left" class="form-control" value="20" min="0" max="200">
                        </div>
                        <div class="mb-3">
                            <label for="padding-right" class="form-label">Right Padding (px)</label>
                            <input type="number" id="padding-right" class="form-control" value="20" min="0" max="200">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('dashboard.cancel') }}</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ __('dashboard.save_changes') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
