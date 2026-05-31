<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'super_admin' => redirect()->route('admin.dashboard'),
            'hse_manager' => redirect()->route('hse.dashboard'),
            'supervisor' => redirect()->route('supervisor.dashboard'),
            'worker' => redirect()->route('worker.dashboard'),
            default => redirect('/login'),
        };
    }
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Routes with RBAC
Route::middleware(['auth', 'log.activity'])->group(function () {
    
    Route::get('/notifications', [\App\Http\Controllers\Notification\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read', [\App\Http\Controllers\Notification\NotificationController::class, 'markAsRead'])->name('notifications.read');

    Route::prefix('analytics')->middleware(['role:super_admin,hse_manager'])->name('analytics.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Analytics\AnalyticsDashboardController::class, 'index'])->name('index');
    });

    // Super Admin Routes
    Route::prefix('admin')->middleware(['role:super_admin'])->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('activity')->name('activity.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('index');
            Route::get('/{activityLog}', [\App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('show');
        });

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\UserManagementController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Admin\UserManagementController::class, 'store'])->name('store');
        });
    });

    // HSE Manager Routes
    Route::prefix('hse')->middleware(['role:hse_manager'])->name('hse.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Hse\DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('incident')->name('incident.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Hse\IncidentInvestigationController::class, 'index'])->name('index');
            Route::get('/{incidentReport}', [\App\Http\Controllers\Hse\IncidentInvestigationController::class, 'show'])->name('show');
            Route::post('/{incidentReport}/investigate', [\App\Http\Controllers\Hse\IncidentInvestigationController::class, 'investigate'])->name('investigate');
        });

        Route::prefix('hiradc')->name('hiradc.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Hse\HiradcController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Hse\HiradcController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Hse\HiradcController::class, 'store'])->name('store');
            Route::get('/{hiradc}', [\App\Http\Controllers\Hse\HiradcController::class, 'show'])->name('show');
            Route::post('/{hiradc}/approve', [\App\Http\Controllers\Hse\HiradcController::class, 'approve'])->name('approve');
        });

        Route::prefix('capa')->name('capa.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Hse\CapaController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Hse\CapaController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Hse\CapaController::class, 'store'])->name('store');
            Route::get('/{capaAction}', [\App\Http\Controllers\Hse\CapaController::class, 'show'])->name('show');
            Route::post('/{capaAction}/verify', [\App\Http\Controllers\Hse\CapaController::class, 'verify'])->name('verify');
        });

        Route::prefix('inspection')->name('inspection.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Hse\InspectionScheduleController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Hse\InspectionScheduleController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Hse\InspectionScheduleController::class, 'store'])->name('store');
        });

        Route::prefix('sop')->name('sop.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Hse\SopController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Hse\SopController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Hse\SopController::class, 'store'])->name('store');
            Route::get('/{sop}', [\App\Http\Controllers\Hse\SopController::class, 'show'])->name('show');
            Route::post('/{sop}/approve', [\App\Http\Controllers\Hse\SopController::class, 'approve'])->name('approve');
        });

        Route::prefix('certificate')->name('certificate.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Hse\CertificateController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Hse\CertificateController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Hse\CertificateController::class, 'store'])->name('store');
        });

        Route::prefix('permit')->name('permit.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Hse\PermitApprovalController::class, 'index'])->name('index');
            Route::get('/{permitToWork}', [\App\Http\Controllers\Hse\PermitApprovalController::class, 'show'])->name('show');
            Route::post('/{permitToWork}/approve', [\App\Http\Controllers\Hse\PermitApprovalController::class, 'approve'])->name('approve');
        });

        Route::prefix('audit')->name('audit.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Hse\AuditController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Hse\AuditController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Hse\AuditController::class, 'store'])->name('store');
            Route::get('/{audit}', [\App\Http\Controllers\Hse\AuditController::class, 'show'])->name('show');
        });

        Route::prefix('training')->name('training.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Hse\TrainingController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Hse\TrainingController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Hse\TrainingController::class, 'store'])->name('store');
            Route::get('/{training}', [\App\Http\Controllers\Hse\TrainingController::class, 'show'])->name('show');
        });
    });

    // Supervisor Routes
    Route::prefix('supervisor')->middleware(['role:supervisor'])->name('supervisor.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Supervisor\DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('hazard')->name('hazard.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Supervisor\HazardVerificationController::class, 'index'])->name('index');
            Route::get('/{hazardReport}', [\App\Http\Controllers\Supervisor\HazardVerificationController::class, 'show'])->name('show');
            Route::post('/{hazardReport}/verify', [\App\Http\Controllers\Supervisor\HazardVerificationController::class, 'verify'])->name('verify');
        });

        Route::prefix('capa')->name('capa.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Supervisor\CapaExecutionController::class, 'index'])->name('index');
            Route::get('/{capaAction}', [\App\Http\Controllers\Supervisor\CapaExecutionController::class, 'show'])->name('show');
            Route::post('/{capaAction}/update', [\App\Http\Controllers\Supervisor\CapaExecutionController::class, 'update'])->name('update');
        });

        Route::prefix('inspection')->name('inspection.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Supervisor\InspectionController::class, 'index'])->name('index');
            Route::get('/{inspection}', [\App\Http\Controllers\Supervisor\InspectionController::class, 'show'])->name('show');
            Route::post('/{inspection}/complete', [\App\Http\Controllers\Supervisor\InspectionController::class, 'complete'])->name('complete');
        });

        Route::prefix('toolbox')->name('toolbox.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Supervisor\ToolboxMeetingController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Supervisor\ToolboxMeetingController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Supervisor\ToolboxMeetingController::class, 'store'])->name('store');
            Route::get('/{toolboxMeeting}', [\App\Http\Controllers\Supervisor\ToolboxMeetingController::class, 'show'])->name('show');
        });

        Route::prefix('apd')->name('apd.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Supervisor\ApdController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Supervisor\ApdController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Supervisor\ApdController::class, 'store'])->name('store');
        });
    });

    // Worker Routes
    Route::prefix('worker')->middleware(['role:worker'])->name('worker.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Worker\DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('hazard')->name('hazard.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Worker\HazardReportController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Worker\HazardReportController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Worker\HazardReportController::class, 'store'])->name('store');
            Route::get('/{hazardReport}', [\App\Http\Controllers\Worker\HazardReportController::class, 'show'])->name('show');
        });

        Route::prefix('incident')->name('incident.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Worker\IncidentReportController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Worker\IncidentReportController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Worker\IncidentReportController::class, 'store'])->name('store');
            Route::get('/{incidentReport}', [\App\Http\Controllers\Worker\IncidentReportController::class, 'show'])->name('show');
        });

        Route::post('/panic-button', [\App\Http\Controllers\Worker\PanicButtonController::class, 'trigger'])->name('panic.trigger');

        Route::prefix('permit')->name('permit.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Worker\PermitController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Worker\PermitController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Worker\PermitController::class, 'store'])->name('store');
        });
    });

});
