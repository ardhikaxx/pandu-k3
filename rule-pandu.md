# RULE-PANDU.md
# Aturan Sistem PANDU K3
## Pusat Analisis & Navigasi Data Unggul K3

> **Versi:** 1.0.0 | **Framework:** Laravel 12 | **Tanggal:** 2025

---

## DAFTAR ISI

1. [Gambaran Umum Sistem](#1-gambaran-umum-sistem)
2. [Arsitektur Proyek](#2-arsitektur-proyek)
3. [Struktur Database](#3-struktur-database)
4. [Peran & Hak Akses (RBAC)](#4-peran--hak-akses-rbac)
5. [Modul & Fitur Sistem](#5-modul--fitur-sistem)
6. [Alur Kerja Sistem (Workflow)](#6-alur-kerja-sistem-workflow)
7. [Notifikasi & Otomasi](#7-notifikasi--otomasi)
8. [Keamanan Sistem](#8-keamanan-sistem)
9. [Aturan Validasi Data](#9-aturan-validasi-data)
10. [API & Integrasi](#10-api--integrasi)
11. [Laporan & Ekspor](#11-laporan--ekspor)
12. [Konfigurasi Teknis Laravel](#12-konfigurasi-teknis-laravel)

---

## 1. GAMBARAN UMUM SISTEM

### 1.1 Identitas Sistem
- **Nama Sistem:** PANDU K3 *(Pusat Analisis & Navigasi Data Unggul K3)*
- **Tujuan:** Sistem informasi manajemen Kesehatan dan Keselamatan Kerja (K3) industri yang komprehensif berbasis web
- **Framework Backend:** Laravel 12
- **Database:** MySQL 8.0+ / MariaDB 10.6+
- **PHP Version:** 8.2+
- **Frontend Stack:** Blade Template + Bootstrap 5 CDN + Font Awesome 6 CDN + Chart.js CDN + SweetAlert2 CDN

### 1.2 Prinsip Dasar Sistem
1. **Closed-Loop Workflow** — Setiap isu keselamatan harus memiliki siklus hidup penuh: lapor → verifikasi → tindakan → tutup
2. **Real-Time Responsiveness** — Notifikasi insiden berjalan tanpa penundaan menggunakan Laravel Events & Queues
3. **Zero Paper Policy** — Semua dokumen, checklist, dan izin kerja tersimpan digital
4. **Audit Trail Lengkap** — Setiap perubahan data tercatat secara otomatis
5. **Mobile-First Lapangan** — Antarmuka pekerja lapangan harus responsif dan ringan

### 1.3 Aturan Umum Sistem
- Semua tanggal/waktu menggunakan timezone **WIB (Asia/Jakarta)** sebagai default
- Format tanggal standar: `DD/MM/YYYY`
- Format waktu standar: `HH:MM WIB`
- Bahasa antarmuka utama: **Bahasa Indonesia**
- Semua upload file disimpan di `storage/app/public/` dengan symbolic link
- Ukuran maksimum upload per file: **10 MB**
- Format foto yang diizinkan: `jpg`, `jpeg`, `png`, `webp`
- Format dokumen yang diizinkan: `pdf`, `doc`, `docx`, `xlsx`

---

## 2. ARSITEKTUR PROYEK

### 2.1 Struktur Direktori Laravel

```
pandu-k3/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       ├── SendCertificateExpiryReminder.php
│   │       ├── EscalateUnhandledHazards.php
│   │       ├── GenerateMonthlyReport.php
│   │       └── CleanupTempFiles.php
│   ├── Events/
│   │   ├── HazardReportSubmitted.php
│   │   ├── IncidentReported.php
│   │   ├── InspectionCompleted.php
│   │   └── PanicButtonPressed.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UserManagementController.php
│   │   │   │   └── CompanySettingController.php
│   │   │   ├── Hse/
│   │   │   │   ├── HiradicController.php
│   │   │   │   ├── IncidentInvestigationController.php
│   │   │   │   ├── AuditController.php
│   │   │   │   ├── ComplianceController.php
│   │   │   │   └── TrainingController.php
│   │   │   ├── Supervisor/
│   │   │   │   ├── HazardVerificationController.php
│   │   │   │   ├── InspectionController.php
│   │   │   │   ├── ToolboxMeetingController.php
│   │   │   │   └── ApdManagementController.php
│   │   │   ├── Worker/
│   │   │   │   ├── HazardReportController.php
│   │   │   │   ├── IncidentReportController.php
│   │   │   │   ├── SopController.php
│   │   │   │   └── PanicButtonController.php
│   │   │   ├── Analytics/
│   │   │   │   └── AnalyticsDashboardController.php
│   │   │   ├── Notification/
│   │   │   │   └── NotificationController.php
│   │   │   └── Report/
│   │   │       └── ReportExportController.php
│   │   ├── Middleware/
│   │   │   ├── CheckRole.php
│   │   │   ├── CheckDivisionAccess.php
│   │   │   ├── LogActivity.php
│   │   │   └── EnsureProfileComplete.php
│   │   └── Requests/
│   │       ├── HazardReportRequest.php
│   │       ├── IncidentReportRequest.php
│   │       ├── HiradicRequest.php
│   │       └── InspectionRequest.php
│   ├── Jobs/
│   │   ├── SendNotificationJob.php
│   │   ├── ProcessIncidentEscalation.php
│   │   └── GenerateReportPdfJob.php
│   ├── Listeners/
│   │   ├── NotifySupervisorOnHazard.php
│   │   ├── EscalateToHseManager.php
│   │   └── LogIncidentToHistory.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Company.php
│   │   ├── Division.php
│   │   ├── WorkArea.php
│   │   ├── HazardReport.php
│   │   ├── IncidentReport.php
│   │   ├── Hiradc.php
│   │   ├── HiradicItem.php
│   │   ├── Inspection.php
│   │   ├── InspectionChecklist.php
│   │   ├── CapaAction.php
│   │   ├── Audit.php
│   │   ├── AuditFinding.php
│   │   ├── ToolboxMeeting.php
│   │   ├── Apd.php
│   │   ├── Certificate.php
│   │   ├── PermitToWork.php
│   │   ├── Training.php
│   │   ├── TrainingParticipant.php
│   │   ├── Sop.php
│   │   ├── ActivityLog.php
│   │   └── Notification.php
│   ├── Notifications/
│   │   ├── HazardReportNotification.php
│   │   ├── IncidentAlertNotification.php
│   │   ├── CertificateExpiryNotification.php
│   │   └── EscalationNotification.php
│   ├── Policies/
│   │   ├── HazardReportPolicy.php
│   │   ├── IncidentReportPolicy.php
│   │   └── HiradicPolicy.php
│   └── Services/
│       ├── RiskMatrixService.php
│       ├── NotificationService.php
│       ├── ReportGeneratorService.php
│       └── StatisticsService.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   ├── auth.blade.php
│   │   │   └── worker.blade.php
│   │   ├── auth/
│   │   ├── dashboard/
│   │   ├── hazard/
│   │   ├── incident/
│   │   ├── hiradc/
│   │   ├── inspection/
│   │   ├── capa/
│   │   ├── audit/
│   │   ├── toolbox/
│   │   ├── apd/
│   │   ├── certificate/
│   │   ├── permit/
│   │   ├── training/
│   │   ├── sop/
│   │   ├── analytics/
│   │   ├── reports/
│   │   ├── notifications/
│   │   └── settings/
│   └── js/
│       └── app.js
└── routes/
    ├── web.php
    ├── api.php
    └── console.php
```

### 2.2 Namespace & Prefix Route

```php
// routes/web.php
Route::prefix('admin')->middleware(['auth', 'role:super_admin'])->name('admin.')->group(...)
Route::prefix('hse')->middleware(['auth', 'role:hse_manager'])->name('hse.')->group(...)
Route::prefix('supervisor')->middleware(['auth', 'role:supervisor'])->name('supervisor.')->group(...)
Route::prefix('worker')->middleware(['auth', 'role:worker'])->name('worker.')->group(...)
Route::prefix('analytics')->middleware(['auth', 'role:super_admin,hse_manager'])->name('analytics.')->group(...)
```

---

## 3. STRUKTUR DATABASE

### 3.1 Tabel `users`
```sql
- id (bigint, PK)
- name (string, 100)
- email (string, unique)
- password (hashed)
- role (enum: 'super_admin', 'hse_manager', 'supervisor', 'worker')
- employee_id (string, 20, unique, nullable) -- NIK Karyawan
- phone (string, 20, nullable)
- photo (string, nullable) -- path foto profil
- division_id (FK → divisions)
- work_area_id (FK → work_areas, nullable)
- company_id (FK → companies)
- is_active (boolean, default: true)
- last_login_at (timestamp, nullable)
- email_verified_at (timestamp)
- remember_token
- timestamps
```

### 3.2 Tabel `companies`
```sql
- id, name, code, address, industry_type
- logo, phone, email
- is_active, timestamps
```

### 3.3 Tabel `divisions`
```sql
- id, company_id (FK), name, code, description
- supervisor_id (FK → users, nullable)
- is_active, timestamps
```

### 3.4 Tabel `work_areas`
```sql
- id, company_id (FK), division_id (FK)
- name, code, description
- risk_level (enum: 'low','medium','high','critical')
- location_coordinates (string, nullable) -- lat,lng
- is_active, timestamps
```

### 3.5 Tabel `hazard_reports`
```sql
- id (bigint, PK)
- report_number (string, unique) -- HAZ-YYYY-NNNNN
- reporter_id (FK → users)
- work_area_id (FK → work_areas)
- division_id (FK → divisions)
- hazard_type (enum: 'unsafe_condition','unsafe_act','near_miss')
- category (enum: 'electrical','mechanical','chemical','fire','ergonomic','biological','other')
- title (string, 200)
- description (text)
- location_detail (string, 200)
- coordinates (string, nullable)
- severity (enum: 'low','medium','high','critical')
- photos (json) -- array of photo paths
- status (enum: 'open','in_review','in_progress','resolved','closed')
- priority (enum: 'normal','urgent','emergency')
- assigned_to (FK → users, nullable) -- supervisor/hse
- verified_by (FK → users, nullable)
- verified_at (timestamp, nullable)
- resolved_at (timestamp, nullable)
- closed_at (timestamp, nullable)
- response_time_minutes (integer, nullable) -- calculated
- supervisor_notes (text, nullable)
- resolution_notes (text, nullable)
- capa_id (FK → capa_actions, nullable)
- reported_at (timestamp)
- timestamps
```

### 3.6 Tabel `incident_reports`
```sql
- id, report_number (INC-YYYY-NNNNN)
- reporter_id (FK), victim_name, victim_employee_id
- work_area_id (FK), division_id (FK)
- incident_type (enum: 'accident','near_miss','first_aid','medical_treatment','lost_time','fatality')
- incident_date, incident_time
- title, description, immediate_cause, root_cause
- injuries_description (text, nullable)
- body_part_affected (string, nullable)
- property_damage_description (text, nullable)
- estimated_loss (decimal, nullable)
- witnesses (json, nullable) -- array of witness names
- photos (json)
- status (enum: 'draft','submitted','under_investigation','action_required','closed')
- severity_classification (enum: 'minor','moderate','serious','major','catastrophic')
- investigated_by (FK → users, nullable) -- hse_manager
- investigation_report (text, nullable)
- lost_time_days (integer, default: 0)
- corrective_actions (text, nullable)
- preventive_actions (text, nullable)
- capa_id (FK, nullable)
- submitted_at, closed_at, timestamps
```

### 3.7 Tabel `hiradc` (Master HIRADC)
```sql
- id, document_number (HRD-YYYY-NNN)
- title, work_area_id (FK), division_id (FK)
- prepared_by (FK → users), approved_by (FK → users, nullable)
- revision_number (integer, default: 0)
- status (enum: 'draft','review','approved','archived')
- valid_from (date), valid_until (date)
- approved_at (timestamp, nullable)
- timestamps
```

### 3.8 Tabel `hiradc_items`
```sql
- id, hiradc_id (FK)
- activity (string) -- tahapan kegiatan
- hazard_description (text) -- deskripsi bahaya
- hazard_type (enum: 'physical','chemical','biological','ergonomic','psychosocial','mechanical','electrical','fire','environmental')
- potential_incident (text)
-- Risk Assessment Before Control:
- severity_before (integer, 1-5)
- probability_before (integer, 1-5)
- risk_score_before (integer, computed: severity × probability)
- risk_level_before (enum: 'very_low','low','medium','high','very_high') -- computed
-- Control Measures:
- control_hierarchy (enum: 'elimination','substitution','engineering','administrative','ppe')
- control_measures (text)
- pic_control (string) -- person in charge
- target_date (date)
-- Risk Assessment After Control:
- severity_after (integer, 1-5)
- probability_after (integer, 1-5)
- risk_score_after (integer, computed)
- risk_level_after (enum)
- residual_risk_acceptable (boolean)
- timestamps
```

**Matriks Risiko (Risk Matrix 5×5):**
```
Risk Score = Severity × Probability
1–4   → Very Low (Hijau Tua)
5–9   → Low (Hijau)
10–14 → Medium (Kuning)
15–19 → High (Oranye)
20–25 → Very High / Critical (Merah)
```

### 3.9 Tabel `inspections`
```sql
- id, inspection_number (INS-YYYY-NNN)
- title, inspection_type (enum: 'daily','weekly','monthly','special','audit_follow_up')
- work_area_id (FK), division_id (FK)
- inspector_id (FK → users)
- scheduled_date, actual_date (nullable)
- status (enum: 'scheduled','in_progress','completed','overdue','cancelled')
- completion_percentage (decimal, default: 0)
- overall_notes (text, nullable)
- photos (json, nullable)
- completed_at (nullable), timestamps
```

### 3.10 Tabel `inspection_checklist_items`
```sql
- id, inspection_id (FK)
- category (string) -- e.g. "APD", "Mesin", "Listrik"
- item_description (text)
- standard_reference (string, nullable) -- e.g. "SNI 04-6629"
- status (enum: 'ok','not_ok','na','not_checked')
- notes (text, nullable)
- photo (string, nullable)
- finding_severity (enum: 'observation','minor','major','critical', nullable)
- requires_capa (boolean, default: false)
- capa_id (FK, nullable)
- checked_by (FK → users, nullable)
- checked_at (timestamp, nullable)
- timestamps
```

### 3.11 Tabel `capa_actions`
```sql
- id, capa_number (CPA-YYYY-NNN)
- source_type (enum: 'hazard_report','incident','inspection','audit')
- source_id (bigint) -- polymorphic reference
- title, description (text)
- action_type (enum: 'corrective','preventive','improvement')
- priority (enum: 'low','medium','high','critical')
- assigned_to (FK → users)
- assigned_by (FK → users)
- division_id (FK)
- due_date (date)
- status (enum: 'open','in_progress','pending_verification','closed','overdue')
- progress_notes (text, nullable)
- completion_evidence (json, nullable) -- foto/dokumen bukti
- completed_at (nullable)
- verified_by (FK, nullable), verified_at (nullable)
- effectiveness_rating (integer, 1-5, nullable)
- timestamps
```

### 3.12 Tabel `audits`
```sql
- id, audit_number (AUD-YYYY-NNN)
- title, audit_type (enum: 'internal','external','surveillance','certification')
- work_area_id (FK), division_id (FK)
- lead_auditor_id (FK → users)
- team_members (json) -- array of user_ids
- scheduled_start, scheduled_end
- actual_start (nullable), actual_end (nullable)
- status (enum: 'planned','in_progress','completed','report_issued')
- scope (text), criteria (text)
- summary_findings (text, nullable)
- total_findings (integer, default: 0)
- major_findings (integer, default: 0)
- minor_findings (integer, default: 0)
- observations (integer, default: 0)
- timestamps
```

### 3.13 Tabel `toolbox_meetings`
```sql
- id, meeting_number (TBM-YYYY-NNN)
- title, topic (text)
- work_area_id (FK), division_id (FK)
- facilitator_id (FK → users) -- supervisor
- meeting_date, start_time, end_time
- location (string)
- agenda (text)
- materials_presented (text, nullable)
- notes (text, nullable)
- attendance_photo (string, nullable)
- status (enum: 'scheduled','completed','cancelled')
- timestamps
```

### 3.14 Tabel `toolbox_attendances`
```sql
- id, meeting_id (FK), user_id (FK)
- attendance_status (enum: 'present','absent','excused')
- signature_path (string, nullable) -- digital signature
- timestamps
```

### 3.15 Tabel `apd_inventory`
```sql
- id, item_code, name, category
- (enum: 'helmet','vest','gloves','boots','goggles','mask','harness','earmuff','coverall','other')
- brand, model, size
- work_area_id (FK), division_id (FK)
- total_quantity, available_quantity, damaged_quantity
- standard_reference (string) -- SNI/ISO standard
- inspection_interval_days (integer) -- interval inspeksi berkala
- last_inspected_at (date, nullable)
- next_inspection_date (date, nullable) -- computed
- condition (enum: 'good','fair','poor','damaged')
- notes (text, nullable)
- timestamps
```

### 3.16 Tabel `certificates`
```sql
- id, user_id (FK), certificate_type
- (enum: 'k3_umum','k3_ahli','operator_forklift','operator_crane','welder','first_aid','fire_fighting','scaffolding','confined_space','other')
- certificate_number, issuing_body
- issued_date, expiry_date
- status (enum: 'active','expiring_soon','expired')
-- 'expiring_soon' jika <= 30 hari sebelum expiry
- document_path (string, nullable)
- reminder_sent_at (timestamp, nullable)
- notes (text, nullable)
- timestamps
```

### 3.17 Tabel `permits_to_work`
```sql
- id, permit_number (PTW-YYYY-NNN)
- work_type (enum: 'hot_work','confined_space','working_at_height','electrical','excavation','chemical_handling','crane_lifting','other')
- title, description (text)
- work_area_id (FK), division_id (FK)
- applicant_id (FK → users) -- yang mengajukan
- supervisor_id (FK → users)
- approved_by (FK → users, nullable) -- hse_manager
- start_datetime, end_datetime
- required_ppe (json) -- list APD yang wajib
- precautions (text)
- emergency_contacts (json)
- hazards_identified (text)
- control_measures (text)
- status (enum: 'draft','submitted','approved','active','completed','cancelled','expired')
- approved_at (nullable), completed_at (nullable)
- timestamps
```

### 3.18 Tabel `trainings`
```sql
- id, training_number (TRN-YYYY-NNN)
- title, type (enum: 'induction','refresher','specialist','emergency_drill','regulatory','on_the_job')
- description (text)
- provider (string) -- internal/nama lembaga
- trainer_name, trainer_credential (nullable)
- division_id (FK, nullable) -- null = semua divisi
- scheduled_date, end_date
- location, max_participants (integer)
- duration_hours (decimal)
- status (enum: 'planned','ongoing','completed','cancelled')
- materials_url (string, nullable)
- certificate_issued (boolean, default: false)
- timestamps
```

### 3.19 Tabel `training_participants`
```sql
- id, training_id (FK), user_id (FK)
- registration_status (enum: 'registered','attended','absent','passed','failed')
- pre_test_score (decimal, nullable)
- post_test_score (decimal, nullable)
- certificate_issued (boolean, default: false)
- certificate_path (string, nullable)
- notes (text, nullable)
- timestamps
```

### 3.20 Tabel `sops`
```sql
- id, document_number (SOP-YYYY-NNN)
- title, category
- (enum: 'work_procedure','emergency_response','chemical_handling','equipment_operation','housekeeping','fire_safety','first_aid','evacuation','other')
- content (longtext) -- HTML/Markdown
- work_area_id (FK, nullable) -- null = semua area
- division_id (FK, nullable)
- created_by (FK → users)
- approved_by (FK → users, nullable)
- version (string, default: '1.0')
- status (enum: 'draft','active','under_review','obsolete')
- effective_date (date, nullable)
- review_date (date, nullable)
- document_path (string, nullable) -- PDF attachment
- view_count (integer, default: 0)
- timestamps
```

### 3.21 Tabel `activity_logs`
```sql
- id, user_id (FK), action (string)
- module (string), record_id (bigint, nullable)
- description (text)
- old_values (json, nullable), new_values (json, nullable)
- ip_address, user_agent
- created_at
```

### 3.22 Tabel `notifications` (Database Notification)
```sql
- id (uuid), type, notifiable_type, notifiable_id
- data (json), read_at (nullable)
- created_at, updated_at
```

---

## 4. PERAN & HAK AKSES (RBAC)

### 4.1 Definisi Peran

| Kode Peran | Nama Tampilan | Level |
|---|---|---|
| `super_admin` | Super Admin / Direktur | 1 (Tertinggi) |
| `hse_manager` | Manajer HSE | 2 |
| `supervisor` | Pengawas / Supervisor | 3 |
| `worker` | Pekerja / Staf Lapangan | 4 (Terendah) |

### 4.2 Hak Akses Per Modul

#### SUPER ADMIN
```
✅ Dashboard Analitik Makro (semua perusahaan/site)
✅ Manajemen User & Peran
✅ Manajemen Perusahaan & Site
✅ Konfigurasi Sistem
✅ Semua Laporan (download eksekutif)
✅ Audit Trail & Activity Log
✅ Statistik & KPI Perusahaan
✅ Manajemen Divisi & Area Kerja
❌ Input operasional harian (inspeksi, CAPA harian)
```

#### HSE MANAGER
```
✅ Dashboard HSE lengkap (semua divisi)
✅ Buat & setujui HIRADC
✅ Investigasi insiden tingkat tinggi
✅ Buat & kelola jadwal audit
✅ Kelola matriks kepatuhan
✅ Kelola CAPA (assign, verifikasi, tutup)
✅ Manajemen dokumen SOP & Izin Kerja
✅ Manajemen Pelatihan
✅ Laporan K3 lengkap
✅ Verifikasi laporan bahaya eskalasi
✅ Kelola sertifikat karyawan
✅ Buat inspeksi & checklist template
✅ Notifikasi & eskalasi
❌ Manajemen User & Sistem
```

#### SUPERVISOR
```
✅ Dashboard divisi/area sendiri
✅ Verifikasi laporan bahaya dari pekerja
✅ Isi checklist inspeksi harian
✅ Buat & catat toolbox meeting
✅ Pantau APD divisinya
✅ Tambah temuan lapangan ke CAPA
✅ Update status work order
✅ Lihat HIRADC area kerjanya
✅ Catat absensi toolbox meeting
✅ Validasi penyelesaian CAPA divisinya
✅ Lihat SOP relevan
❌ Buat/setujui HIRADC
❌ Investigasi insiden
❌ Audit
```

#### WORKER
```
✅ Kirim laporan bahaya (foto + deskripsi + lokasi)
✅ Kirim laporan insiden ringan
✅ Lihat SOP relevan area kerjanya
✅ Panic button (tombol darurat)
✅ Lihat pengumuman keselamatan
✅ Lihat status laporan yang pernah dikirim (milik sendiri)
✅ Daftar & lihat jadwal pelatihan
❌ Semua fitur manajemen lainnya
```

### 4.3 Implementasi Middleware

```php
// app/Http/Middleware/CheckRole.php
class CheckRole {
    public function handle($request, Closure $next, ...$roles) {
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            abort(403, 'Akses Ditolak');
        }
        return $next($request);
    }
}

// Registrasi di bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => CheckRole::class,
        'division.access' => CheckDivisionAccess::class,
        'log.activity' => LogActivity::class,
    ]);
})
```

### 4.4 Aturan Akses Data
- **Supervisor** hanya dapat melihat data dari `work_area` yang menjadi tanggung jawabnya
- **Worker** hanya dapat melihat laporan yang dia sendiri buat
- **HSE Manager** dapat melihat data seluruh divisi dalam perusahaannya
- **Super Admin** dapat melihat semua data semua perusahaan
- Filtering data berdasarkan `company_id` pada setiap query (multi-tenant)

---

## 5. MODUL & FITUR SISTEM

### 5.1 Modul Pelaporan Bahaya (Hazard Report)

**Rules:**
- `report_number` digenerate otomatis: `HAZ-{YEAR}-{5_DIGIT_SEQUENCE}`
- Foto wajib minimal 1, maksimal 5 foto per laporan
- `severity` default: `medium`
- Laporan baru otomatis masuk status `open`
- `priority` ditentukan dari `severity`:
  - `critical` → `emergency`
  - `high` → `urgent`
  - `low/medium` → `normal`
- SLA penanganan berdasarkan priority:
  - `emergency`: wajib direspons ≤ 1 jam
  - `urgent`: wajib direspons ≤ 4 jam
  - `normal`: wajib direspons ≤ 24 jam
- Jika melewati SLA, sistem mengirim notifikasi eskalasi ke HSE Manager

**Status Flow:**
```
open → in_review (Supervisor verify) → in_progress (Work Order dibuat) → resolved (bukti upload) → closed (Supervisor/HSE tutup)
```

### 5.2 Modul Laporan Insiden (Incident Report)

**Rules:**
- `report_number`: `INC-{YEAR}-{5_DIGIT_SEQUENCE}`
- Untuk insiden `fatality` atau `major`: wajib eskalasi ke HSE Manager dan Super Admin dalam 15 menit
- Worker hanya bisa report `minor` dan `first_aid`
- Insiden `lost_time`, `medical_treatment`, `major`, `fatality` hanya bisa dibuat oleh Supervisor/HSE
- Form multi-step: Detail Insiden → Data Korban → Analisis Penyebab → Tindakan Awal → Submit
- Setelah submit, status `under_investigation` otomatis di-assign ke HSE Manager
- `lost_time_days` dihitung otomatis dari tanggal insiden hingga pekerja kembali bekerja

### 5.3 Modul HIRADC

**Rules:**
- `document_number`: `HRD-{YEAR}-{3_DIGIT_SEQUENCE}`
- Wajib minimal 3 item bahaya per dokumen
- Risk Score = Severity (1-5) × Probability (1-5)
- Risk Level dihitung otomatis oleh `RiskMatrixService`
- Dokumen draft hanya bisa dilihat oleh pembuat dan HSE Manager
- Setelah approved, dokumen tidak bisa diedit (harus buat revisi baru)
- Revisi dokumen = increment `revision_number`, dokumen lama diarsipkan
- Masa berlaku maksimal: 1 tahun. Sistem kirim reminder 30 hari sebelum expired

**Hirarki Kontrol (Control Hierarchy) Enforcement:**
```
Eliminasi > Substitusi > Rekayasa Teknik > Administratif > APD
```
Skor residual risk setelah kontrol harus < skor sebelum kontrol (validasi wajib)

### 5.4 Modul Inspeksi & Checklist

**Rules:**
- `inspection_number`: `INS-{YEAR}-{3_DIGIT_SEQUENCE}`
- Checklist template dapat dibuat oleh HSE Manager dan direuse
- `completion_percentage` dihitung: `(item_checked / total_items) * 100`
- Item dengan status `not_ok` dan `finding_severity` = `major`/`critical` wajib generate CAPA otomatis
- Inspeksi overdue = jadwal terlewat dan belum selesai (sistem ubah status otomatis via Cron)
- Foto wajib untuk setiap temuan `major` dan `critical`

### 5.5 Modul CAPA (Corrective & Preventive Action)

**Rules:**
- `capa_number`: `CPA-{YEAR}-{3_DIGIT_SEQUENCE}`
- CAPA dapat dibuat dari: hazard report, incident report, inspection finding, audit finding
- `due_date` wajib diisi, tidak boleh di masa lalu
- Status otomatis berubah ke `overdue` jika `due_date` terlewat (via Cron)
- Penyelesaian CAPA wajib upload minimal 1 foto/dokumen bukti
- Verifikasi dilakukan oleh HSE Manager atau Supervisor (sesuai level CAPA)
- `effectiveness_rating` diisi saat verifikasi (1=sangat tidak efektif, 5=sangat efektif)

**Status Flow:**
```
open → in_progress → pending_verification → closed
                                          ↘ open (jika ditolak)
```

### 5.6 Modul Audit

**Rules:**
- `audit_number`: `AUD-{YEAR}-{3_DIGIT_SEQUENCE}`
- Audit internal hanya bisa dibuat oleh HSE Manager
- Lead Auditor tidak boleh mengaudit divisi yang menjadi tanggung jawabnya (independence)
- Setiap temuan audit wajib masuk ke CAPA
- Laporan audit wajib diterbitkan maksimal 7 hari setelah audit selesai

### 5.7 Modul Toolbox Meeting

**Rules:**
- `meeting_number`: `TBM-{YEAR}-{3_DIGIT_SEQUENCE}`
- Hanya Supervisor yang bisa membuat toolbox meeting
- Absensi digital wajib dicatat untuk setiap meeting
- Meeting berlangsung minimal 10 menit, maksimal 60 menit
- Topik meeting harus berkaitan dengan temuan bahaya/insiden terbaru di area tersebut (rekomendasi sistem)

### 5.8 Modul APD

**Rules:**
- `available_quantity` tidak boleh minus
- Jadwal inspeksi APD wajib diikuti (sistem kirim reminder H-3)
- APD dengan kondisi `damaged` otomatis dicatat dan dikirim notifikasi ke Supervisor
- Catatan penggunaan APD dapat dilacak per shift/hari

### 5.9 Modul Sertifikat Kompetensi

**Rules:**
- Status `expiring_soon` jika sisa masa berlaku ≤ 30 hari
- Status `expired` jika tanggal kadaluarsa sudah lewat (otomatis via Cron harian)
- Reminder email dikirim pada H-30, H-14, H-7, H-1 sebelum expired
- Sertifikat yang expired → pemilik tidak diizinkan memegang izin kerja terkait
- Wajib upload scan sertifikat saat input data

### 5.10 Modul Izin Kerja (Permit to Work)

**Rules:**
- `permit_number`: `PTW-{YYYY}-{3_DIGIT_SEQUENCE}`
- Izin kerja memiliki masa berlaku (start_datetime sampai end_datetime)
- Wajib disetujui oleh HSE Manager sebelum pekerjaan dimulai
- Pekerja yang terlibat wajib memiliki sertifikat yang masih aktif dan relevan
- Izin kadaluarsa otomatis diubah status ke `expired` via Cron
- Pekerjaan berisiko tinggi (hot work, confined space, heights) wajib memiliki izin kerja aktif

### 5.11 Modul Pelatihan

**Rules:**
- `training_number`: `TRN-{YEAR}-{3_DIGIT_SEQUENCE}`
- Kapasitas peserta diikuti: tidak bisa mendaftar jika `current_participants >= max_participants`
- Absensi dicatat: `attended` jika hadir, `absent` jika tidak
- Nilai lulus minimal: 70 (dari skala 100)
- Sertifikat pelatihan digenerate otomatis jika peserta `passed`

### 5.12 Modul SOP

**Rules:**
- `document_number`: `SOP-{YEAR}-{3_DIGIT_SEQUENCE}`
- SOP aktif bisa diakses oleh semua peran
- SOP dapat di-filter berdasarkan area kerja dan divisi pekerja
- `view_count` di-increment setiap kali SOP dibuka
- SOP wajib direview setiap 1 tahun sekali
- Sistem kirim reminder review H-30 sebelum `review_date`

### 5.13 Modul Panic Button

**Rules:**
- Tersedia di antarmuka Worker sebagai tombol merah besar dan mencolok
- Menekan panic button → trigger Event `PanicButtonPressed`
- Notifikasi real-time dikirim ke: Supervisor area, HSE Manager, dan Super Admin
- Notifikasi berisi: nama pekerja, waktu, area kerja, koordinat (jika tersedia)
- Setiap aktivasi panic button dicatat di log darurat tersendiri
- Supervisor wajib merespons dalam 5 menit atau sistem eskalasi otomatis

### 5.14 Modul Dashboard & Analitik

**KPI yang Ditampilkan:**
- **LTIFR** (Lost Time Injury Frequency Rate): `(Jumlah LTI × 1.000.000) / Jam Kerja`
- **TRIFR** (Total Recordable Injury Frequency Rate)
- **Jam Kerja Aman Tanpa Kecelakaan** (Zero Accident Days)
- **Hazard Closure Rate** (% laporan bahaya tertutup)
- **CAPA Completion Rate**
- **Inspection Completion Rate**
- **Near Miss Reporting Rate**

**Chart yang Ditampilkan:**
- Tren insiden per bulan (Line Chart)
- Distribusi jenis bahaya (Doughnut Chart)
- Perbandingan risiko per area kerja (Bar Chart)
- Status CAPA (Stacked Bar / Horizontal Bar)
- Heatmap area bahaya (tabel dengan color coding)
- Progress KPI vs target (Gauge / Progress Bar)

---

## 6. ALUR KERJA SISTEM (WORKFLOW)

### 6.1 Alur Laporan Bahaya

```
WORKER: Temukan bahaya
    ↓
[Form Laporan Bahaya: foto + deskripsi + lokasi + kategori]
    ↓
SISTEM: Generate HAZ-YYYY-NNNNN
    ↓
SISTEM: Kirim notifikasi real-time ke Supervisor area
    ↓
SUPERVISOR: Terima notifikasi → datangi lokasi → verifikasi
    ↓
[Verifikasi: konfirmasi temuan + catatan teknis + amankan area]
    ↓
SUPERVISOR: Buat Work Order ke tim maintenance/terkait
    ↓
CAPA otomatis dibuat (jika severity High/Critical)
    ↓
TIM TERKAIT: Kerjakan perbaikan + upload bukti penyelesaian
    ↓
SUPERVISOR: Verifikasi akhir → tutup tiket
    ↓
SISTEM: Catat response time + update statistik
    ↓
DATA → riwayat lokasi → pertimbangan HIRADC berikutnya
```

### 6.2 Alur Insiden Serius (Major/Fatality)

```
PEKERJA/SUPERVISOR: Lapor insiden
    ↓
SISTEM: Klasifikasi → Major/Fatality
    ↓
SISTEM: Eskalasi otomatis (15 menit) ke HSE Manager + Super Admin
    ↓
HSE MANAGER: Ambil alih investigasi
    ↓
[Investigasi: penyebab langsung + penyebab dasar + faktor berkontribusi]
    ↓
HSE MANAGER: Buat laporan investigasi resmi
    ↓
SISTEM: Generate CAPA wajib
    ↓
[CAPA: tindakan korektif + tindakan preventif + deadline]
    ↓
HSE MANAGER: Monitoring penyelesaian CAPA
    ↓
SUPER ADMIN: Menerima laporan eksekutif insiden
    ↓
SISTEM: Update statistik insiden & KPI
```

### 6.3 Alur Sertifikat Kadaluarsa

```
CRON JOB (Harian 06:00 WIB):
    ↓
CEK semua sertifikat yang akan expired dalam 30 hari
    ↓
H-30: Email reminder ke pemilik sertifikat & HSE Manager
H-14: Email + notifikasi in-app
H-7: Email + notifikasi in-app + laporan ke Supervisor
H-1: Email darurat + notifikasi merah
H+0 (expired): Status ubah ke 'expired' + notifikasi ke Supervisor & HSE
    ↓
Pemilik sertifikat expired DILARANG mengakses Izin Kerja terkait
    ↓
Setelah pembaruan sertifikat di-upload → status kembali 'active'
```

---

## 7. NOTIFIKASI & OTOMASI

### 7.1 Database Notifications (Laravel)
Semua notifikasi disimpan di tabel `notifications` dan dapat dibaca via API endpoint `/notifications`.

### 7.2 Queue Configuration
```php
// .env
QUEUE_CONNECTION=database
// atau gunakan Redis jika tersedia
QUEUE_CONNECTION=redis
```

### 7.3 Scheduled Tasks (Cron Jobs)
```php
// routes/console.php atau app/Console/Kernel.php

// Setiap hari jam 06:00 WIB
Schedule::command('k3:check-certificate-expiry')->dailyAt('06:00');

// Setiap jam — cek SLA laporan bahaya
Schedule::command('k3:check-hazard-sla')->hourly();

// Setiap hari jam 07:00 WIB — ubah status CAPA overdue
Schedule::command('k3:update-overdue-capa')->dailyAt('07:00');

// Setiap hari jam 00:01 WIB — ubah status inspeksi overdue
Schedule::command('k3:update-overdue-inspections')->dailyAt('00:01');

// Hari pertama tiap bulan — generate laporan bulanan
Schedule::command('k3:generate-monthly-report')->monthlyOn(1, '08:00');

// Setiap minggu Jumat jam 15:00 — reminder toolbox meeting
Schedule::command('k3:reminder-toolbox-meeting')->weeklyOn(5, '15:00');

// Setiap hari jam 23:55 WIB — update status sertifikat expired
Schedule::command('k3:update-certificate-status')->dailyAt('23:55');

// Setiap hari jam 08:00 — reminder review SOP
Schedule::command('k3:check-sop-review-due')->dailyAt('08:00');

// Setiap hari jam 07:30 — reminder inspeksi APD
Schedule::command('k3:check-apd-inspection-due')->dailyAt('07:30');
```

### 7.4 Trigger Notifikasi Per Event

| Event | Penerima | Channel |
|---|---|---|
| Laporan bahaya baru | Supervisor area | In-app + Email |
| Laporan bahaya emergency | Supervisor + HSE Manager | In-app + Email |
| Insiden major/fatality | HSE Manager + Super Admin | In-app + Email + SMS* |
| Panic button ditekan | Supervisor + HSE Manager + Admin | In-app (real-time) |
| CAPA mendekati deadline (H-3) | PIC CAPA | In-app + Email |
| CAPA overdue | PIC + HSE Manager | In-app + Email |
| Sertifikat hampir expired | Pemilik + HSE Manager | Email |
| Izin kerja disetujui/ditolak | Pemohon | In-app + Email |
| Laporan bahaya diselesaikan | Reporter | In-app |
| Jadwal pelatihan baru | Peserta terdaftar | In-app + Email |

---

## 8. KEAMANAN SISTEM

### 8.1 Autentikasi
- Laravel Breeze / Fortify sebagai fondasi auth
- Session-based authentication (bukan API token untuk web)
- `remember_me` maksimal 30 hari
- Session timeout: 8 jam (1 shift kerja)
- Deteksi login dari IP berbeda → kirim notifikasi email

### 8.2 Authorization
- Gates & Policies Laravel untuk resource-level authorization
- Middleware `role` untuk route-level access control
- Middleware `division.access` untuk data-level access control

### 8.3 Keamanan Data
- CSRF Protection aktif di semua form (bawaan Laravel)
- XSS Protection melalui `htmlspecialchars` di Blade (`{{ }}`)
- SQL Injection protection melalui Eloquent ORM
- File upload validation ketat (MIME type + extension + size)
- File upload path tidak boleh dapat ditebak (gunakan `Str::uuid()`)
- Sensitive data (password) tidak pernah di-log

### 8.4 Audit Trail
- Middleware `LogActivity` mencatat semua aksi CRUD ke tabel `activity_logs`
- Data yang dicatat: user, action, module, record_id, old_values, new_values, IP, user_agent, timestamp
- Log tidak dapat dihapus oleh siapapun kecuali Super Admin dengan konfirmasi ganda

---

## 9. ATURAN VALIDASI DATA

### 9.1 Validasi Form Hazard Report
```php
'title'        => 'required|string|min:10|max:200',
'description'  => 'required|string|min:20',
'work_area_id' => 'required|exists:work_areas,id',
'hazard_type'  => 'required|in:unsafe_condition,unsafe_act,near_miss',
'category'     => 'required|in:electrical,mechanical,chemical,...',
'severity'     => 'required|in:low,medium,high,critical',
'photos'       => 'required|array|min:1|max:5',
'photos.*'     => 'image|mimes:jpg,jpeg,png,webp|max:5120', // 5MB
'location_detail' => 'required|string|max:200',
```

### 9.2 Validasi HIRADC Item
```php
'severity_before'   => 'required|integer|between:1,5',
'probability_before'=> 'required|integer|between:1,5',
'severity_after'    => 'required|integer|between:1,5',
'probability_after' => 'required|integer|between:1,5',
// Custom Rule: risk_score_after < risk_score_before
```

### 9.3 Validasi Tanggal
- `start_date` tidak boleh lebih besar dari `end_date`
- `expiry_date` tidak boleh lebih kecil dari `issued_date`
- `due_date` CAPA tidak boleh di masa lalu saat dibuat

---

## 10. API & INTEGRASI

### 10.1 Internal API Endpoints
```
GET  /api/notifications         -- Ambil notifikasi user
POST /api/notifications/read    -- Tandai dibaca
GET  /api/dashboard/stats       -- Data statistik dashboard (JSON untuk Chart.js)
GET  /api/hazards/status/{id}   -- Cek status laporan (untuk worker)
POST /api/panic-button          -- Trigger panic button
GET  /api/work-areas            -- List area kerja (untuk select2/dropdown)
GET  /api/users/by-division/{id} -- User berdasarkan divisi
```

### 10.2 Response Format API
```json
{
  "status": "success|error",
  "message": "Pesan keterangan",
  "data": {},
  "meta": {
    "total": 100,
    "per_page": 15,
    "current_page": 1
  }
}
```

---

## 11. LAPORAN & EKSPOR

### 11.1 Jenis Laporan yang Tersedia
1. **Laporan Insiden Bulanan** (PDF) — ringkasan semua insiden dalam sebulan
2. **Laporan HIRADC per Area** (PDF) — dokumen HIRADC lengkap
3. **Laporan Status CAPA** (Excel/PDF) — semua CAPA beserta status terkini
4. **Laporan Statistik KPI** (PDF) — grafik dan angka KPI bulanan/tahunan
5. **Laporan Audit** (PDF) — laporan hasil audit resmi
6. **Laporan Sertifikat Karyawan** (Excel) — list sertifikat dengan status
7. **Laporan Kehadiran Toolbox Meeting** (PDF/Excel)
8. **Laporan Hazard Trend** (PDF) — tren laporan bahaya per area/periode

### 11.2 Aturan Ekspor
- Semua ekspor diproses via **Laravel Queue Job** (agar tidak timeout)
- PDF menggunakan library **DomPDF** atau **Snappy**
- Excel menggunakan **Maatwebsite/Excel**
- Setelah file siap, user mendapat notifikasi + link download
- File laporan disimpan sementara 24 jam lalu dihapus otomatis

---

## 12. KONFIGURASI TEKNIS LARAVEL

### 12.1 CDN yang Digunakan
```html
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
```

### 12.2 Konfigurasi SweetAlert2

```javascript
// Alert Sukses
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: 'Data berhasil disimpan',
    timer: 2000,
    showConfirmButton: false,
    toast: false,
});

// Alert Gagal
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: message,
    confirmButtonColor: '#d33',
    confirmButtonText: 'Tutup'
});

// Alert Konfirmasi Hapus
Swal.fire({
    title: 'Konfirmasi Hapus',
    text: 'Data yang dihapus tidak dapat dipulihkan!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal',
}).then((result) => {
    if (result.isConfirmed) {
        // Lanjutkan penghapusan
    }
});

// Flash message dari session (di layout)
@if(session('success'))
<script>
Swal.fire({ icon:'success', title:'Berhasil!', text:'{!! session("success") !!}', timer:2500, showConfirmButton:false });
</script>
@endif
@if(session('error'))
<script>
Swal.fire({ icon:'error', title:'Gagal!', text:'{!! session("error") !!}' });
</script>
@endif
```

### 12.3 Konfigurasi Chart.js

```javascript
// Global defaults
Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
Chart.defaults.color = '#6c757d';

// Warna palet PANDU K3
const K3_COLORS = {
    danger:  '#DC3545',
    warning: '#FFC107',
    success: '#198754',
    info:    '#0DCAF0',
    primary: '#1A5276',
    secondary:'#6C757D',
    orange:  '#FD7E14',
};
```

### 12.4 Helper Function Penting
```php
// app/Helpers/K3Helper.php
function generateDocumentNumber(string $prefix, string $model, string $column = 'report_number'): string {
    $year = now()->format('Y');
    $lastRecord = DB::table(app($model)->getTable())
        ->whereYear('created_at', $year)
        ->orderBy('id','desc')
        ->first();
    $sequence = $lastRecord ? (intval(substr($lastRecord->$column, -5)) + 1) : 1;
    return "{$prefix}-{$year}-" . str_pad($sequence, 5, '0', STR_PAD_LEFT);
}

function calculateRiskLevel(int $score): string {
    return match(true) {
        $score <= 4  => 'very_low',
        $score <= 9  => 'low',
        $score <= 14 => 'medium',
        $score <= 19 => 'high',
        default      => 'very_high',
    };
}

function getRiskBadgeClass(string $level): string {
    return match($level) {
        'very_low' => 'badge-risk-vlow',
        'low'      => 'badge-risk-low',
        'medium'   => 'badge-risk-medium',
        'high'     => 'badge-risk-high',
        'very_high'=> 'badge-risk-critical',
        default    => 'badge-secondary',
    };
}
```

### 12.5 Migrasi Prioritas (Urutan Jalankan)
```
1. companies
2. divisions
3. work_areas
4. users
5. sops
6. hazard_reports
7. incident_reports
8. hiradc + hiradc_items
9. capa_actions
10. inspections + inspection_checklist_items
11. audits + audit_findings
12. toolbox_meetings + toolbox_attendances
13. apd_inventory
14. certificates
15. permits_to_work
16. trainings + training_participants
17. activity_logs
18. notifications
```

---

*Rule-Pandu v1.0.0 — PANDU K3 System*
*Sistem ini dirancang untuk memenuhi standar SMK3 (PP No. 50 Tahun 2012) dan OHSAS 18001/ISO 45001*
