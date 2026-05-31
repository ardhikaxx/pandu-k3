<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Division;
use App\Models\WorkArea;
use App\Models\User;
use App\Models\HazardReport;
use App\Models\IncidentReport;
use App\Models\Hiradc;
use App\Models\HiradcItem;
use App\Models\Inspection;
use App\Models\InspectionChecklistItem;
use App\Models\CapaAction;
use App\Models\Audit;
use App\Models\ToolboxMeeting;
use App\Models\ToolboxAttendance;
use App\Models\ApdInventory;
use App\Models\Certificate;
use App\Models\PermitToWork;
use App\Models\Training;
use App\Models\TrainingParticipant;
use App\Models\Sop;
use App\Models\ActivityLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RealisticSystemSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // --- 1. COMPANIES ---
        $companies = [
            [
                'name' => 'PT. Pandu Logistik Utama',
                'code' => 'PLU',
                'address' => 'Kawasan Industri Jababeka, Bekasi',
                'industry_type' => 'Logistics',
            ],
            [
                'name' => 'PT. Pandu Konstruksi Indonesia',
                'code' => 'PKI',
                'address' => 'Jl. TB Simatupang No. 10, Jakarta Selatan',
                'industry_type' => 'Construction',
            ],
            [
                'name' => 'PT. Pandu Energi Nusantara',
                'code' => 'PEN',
                'address' => 'Gedung Wisma Mulia Lt. 25, Jakarta',
                'industry_type' => 'Energy',
            ],
        ];

        foreach ($companies as $compData) {
            $company = Company::create($compData);

            // --- 2. DIVISIONS PER COMPANY ---
            $divisionNames = ['Produksi', 'Maintenance', 'Warehouse', 'HSE', 'HRD', 'Operation'];
            $divs = [];
            foreach ($divisionNames as $name) {
                $divs[] = Division::create([
                    'company_id' => $company->id,
                    'name' => $name,
                    'code' => strtoupper(substr($name, 0, 4)),
                    'description' => "Divisi $name untuk {$company->name}",
                ]);
            }

            // --- 3. WORK AREAS PER DIVISION ---
            $workAreas = [];
            foreach ($divs as $div) {
                for ($i = 1; $i <= 3; $i++) {
                    $workAreas[] = WorkArea::create([
                        'company_id' => $company->id,
                        'division_id' => $div->id,
                        'name' => "Area {$div->name} Block " . chr(64 + $i),
                        'code' => "{$div->code}-" . chr(64 + $i),
                        'risk_level' => $faker->randomElement(['low', 'medium', 'high', 'critical']),
                    ]);
                }
            }

            // --- 4. USERS PER ROLE ---
            // Super Admin
            $superAdmin = User::create([
                'name' => "Admin " . $company->code,
                'email' => "admin." . strtolower($company->code) . "@pandu.com",
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'company_id' => $company->id,
                'employee_id' => "SA-" . $faker->unique()->numerify('#####'),
            ]);

            // HSE Manager
            $hseManager = User::create([
                'name' => "HSE Manager " . $company->code,
                'email' => "hse." . strtolower($company->code) . "@pandu.com",
                'password' => Hash::make('password'),
                'role' => 'hse_manager',
                'company_id' => $company->id,
                'division_id' => collect($divs)->where('name', 'HSE')->first()->id,
                'employee_id' => "HSE-" . $faker->unique()->numerify('#####'),
            ]);

            // Supervisors & Workers
            foreach ($divs as $div) {
                if ($div->name === 'HSE') continue;

                // Supervisor
                $supervisor = User::create([
                    'name' => $faker->name,
                    'email' => "spv." . strtolower(str_replace(' ', '', $div->name)) . "." . strtolower($company->code) . "@pandu.com",
                    'password' => Hash::make('password'),
                    'role' => 'supervisor',
                    'company_id' => $company->id,
                    'division_id' => $div->id,
                    'work_area_id' => collect($workAreas)->where('division_id', $div->id)->first()->id,
                    'employee_id' => "SPV-" . $faker->unique()->numerify('#####'),
                ]);
                $div->update(['supervisor_id' => $supervisor->id]);

                // Workers
                for ($w = 1; $w <= 10; $w++) {
                    $wa = collect($workAreas)->where('division_id', $div->id)->random();
                    $worker = User::create([
                        'name' => $faker->name,
                        'email' => "worker" . $w . "." . strtolower(str_replace(' ', '', $div->name)) . "." . strtolower($company->code) . "@pandu.com",
                        'password' => Hash::make('password'),
                        'role' => 'worker',
                        'company_id' => $company->id,
                        'division_id' => $div->id,
                        'work_area_id' => $wa->id,
                        'employee_id' => "WRK-" . $faker->unique()->numerify('#####'),
                    ]);

                    // --- 5. HAZARD REPORTS PER WORKER ---
                    if ($faker->boolean(70)) {
                        for ($h = 1; $h <= rand(1, 3); $h++) {
                            $sev = $faker->randomElement(['low', 'medium', 'high', 'critical']);
                            $hazard = HazardReport::create([
                                'report_number' => "HAZ-" . Carbon::now()->year . "-" . $faker->unique()->numerify('#####'),
                                'reporter_id' => $worker->id,
                                'work_area_id' => $wa->id,
                                'division_id' => $div->id,
                                'hazard_type' => $faker->randomElement(['unsafe_condition', 'unsafe_act', 'near_miss']),
                                'category' => $faker->randomElement(['electrical', 'mechanical', 'chemical', 'fire', 'ergonomic']),
                                'title' => $faker->sentence(6),
                                'description' => $faker->paragraph(3),
                                'location_detail' => $faker->streetAddress,
                                'severity' => $sev,
                                'priority' => match($sev) { 'critical' => 'emergency', 'high' => 'urgent', default => 'normal' },
                                'photos' => ['hazards/sample_hazard.jpg'],
                                'status' => $faker->randomElement(['open', 'in_review', 'in_progress', 'resolved', 'closed']),
                                'reported_at' => Carbon::now()->subDays(rand(1, 60)),
                            ]);

                            // Add Activity Log for Hazard
                            ActivityLog::create([
                                'user_id' => $worker->id,
                                'action' => 'create',
                                'module' => 'hazard_report',
                                'record_id' => $hazard->id,
                                'description' => "Melaporkan bahaya: {$hazard->title}",
                                'ip_address' => $faker->ipv4,
                                'user_agent' => $faker->userAgent,
                            ]);
                        }
                    }

                    // --- 6. INCIDENT REPORTS PER WORKER ---
                    if ($faker->boolean(30)) {
                        $inc = IncidentReport::create([
                            'report_number' => "INC-" . Carbon::now()->year . "-" . $faker->unique()->numerify('#####'),
                            'reporter_id' => $worker->id,
                            'work_area_id' => $wa->id,
                            'division_id' => $div->id,
                            'incident_type' => $faker->randomElement(['accident', 'near_miss', 'first_aid']),
                            'incident_date' => Carbon::now()->subDays(rand(1, 30)),
                            'incident_time' => $faker->time('H:i'),
                            'title' => "Kejadian " . $faker->sentence(4),
                            'description' => $faker->paragraph(5),
                            'victim_name' => $faker->boolean(50) ? $faker->name : null,
                            'photos' => ['incidents/sample_incident.jpg'],
                            'status' => $faker->randomElement(['submitted', 'under_investigation', 'closed']),
                            'severity_classification' => $faker->randomElement(['minor', 'moderate', 'serious']),
                            'submitted_at' => Carbon::now()->subDays(rand(1, 30)),
                        ]);
                    }

                    // --- 7. CERTIFICATES PER WORKER ---
                    if ($faker->boolean(40)) {
                        Certificate::create([
                            'user_id' => $worker->id,
                            'certificate_type' => $faker->randomElement(['k3_umum', 'first_aid', 'fire_fighting', 'operator_forklift']),
                            'certificate_number' => "CERT-" . $faker->unique()->numerify('########'),
                            'issuing_body' => 'Kemnaker RI',
                            'issued_date' => Carbon::now()->subYears(1),
                            'expiry_date' => Carbon::now()->addYears(rand(-1, 2)),
                            'status' => 'active',
                        ]);
                    }
                }

                // --- 8. HIRADC PER DIVISION ---
                $hiradc = Hiradc::create([
                    'document_number' => "HRD-" . Carbon::now()->year . "-" . $faker->unique()->numerify('###'),
                    'title' => "HIRADC " . $div->name . " - Ver 1.0",
                    'work_area_id' => collect($workAreas)->where('division_id', $div->id)->random()->id,
                    'division_id' => $div->id,
                    'prepared_by' => $hseManager->id,
                    'status' => 'approved',
                    'valid_from' => Carbon::now()->startOfYear(),
                    'valid_until' => Carbon::now()->endOfYear(),
                    'approved_at' => Carbon::now()->subMonths(5),
                ]);

                for ($hi = 1; $hi <= 5; $hi++) {
                    $sb = rand(1, 5); $pb = rand(1, 5);
                    $sa = rand(1, min($sb, 3)); $pa = rand(1, min($pb, 2));
                    HiradcItem::create([
                        'hiradc_id' => $hiradc->id,
                        'activity' => $faker->randomElement(['Pengelasan', 'Bongkar Muat', 'Pengecatan', 'Kelistrikan', 'Bekerja di Ketinggian']),
                        'hazard_description' => $faker->sentence(10),
                        'hazard_type' => $faker->randomElement(['physical', 'chemical', 'mechanical', 'electrical']),
                        'potential_incident' => $faker->sentence(8),
                        'severity_before' => $sb,
                        'probability_before' => $pb,
                        'risk_score_before' => $sb * $pb,
                        'risk_level_before' => calculateRiskLevel($sb * $pb),
                        'control_hierarchy' => $faker->randomElement(['engineering', 'administrative', 'ppe']),
                        'control_measures' => $faker->paragraph(2),
                        'pic_control' => $supervisor->name,
                        'target_date' => Carbon::now()->addMonths(2),
                        'severity_after' => $sa,
                        'probability_after' => $pa,
                        'risk_score_after' => $sa * $pa,
                        'risk_level_after' => calculateRiskLevel($sa * $pa),
                        'residual_risk_acceptable' => ($sa * $pa) <= 4,
                    ]);
                }

                // --- 9. INSPECTIONS PER DIVISION ---
                $inspection = Inspection::create([
                    'inspection_number' => "INS-" . Carbon::now()->year . "-" . $faker->unique()->numerify('###'),
                    'title' => "Inspeksi K3 " . $div->name,
                    'inspection_type' => $faker->randomElement(['daily', 'weekly', 'monthly']),
                    'work_area_id' => collect($workAreas)->where('division_id', $div->id)->random()->id,
                    'division_id' => $div->id,
                    'inspector_id' => $supervisor->id,
                    'scheduled_date' => Carbon::now()->subDays(rand(1, 10)),
                    'status' => 'completed',
                    'completion_percentage' => 100,
                    'actual_date' => Carbon::now()->subDays(rand(1, 5)),
                ]);

                $categories = ['APD', 'Lantai Kerja', 'Peralatan', 'Lampu', 'Kabel'];
                foreach ($categories as $cat) {
                    InspectionChecklistItem::create([
                        'inspection_id' => $inspection->id,
                        'category' => $cat,
                        'item_description' => "Cek kondisi $cat di area " . $div->name,
                        'status' => $faker->randomElement(['ok', 'ok', 'not_ok']),
                        'notes' => $faker->boolean(20) ? 'Perlu perbaikan ringan' : null,
                        'checked_by' => $supervisor->id,
                        'checked_at' => Carbon::now(),
                    ]);
                }

                // --- 10. TBM PER DIVISION ---
                ToolboxMeeting::create([
                    'meeting_number' => "TBM-" . Carbon::now()->year . "-" . $faker->unique()->numerify('###'),
                    'title' => "Safety Briefing " . $div->name,
                    'topic' => $faker->randomElement(['Penggunaan Masker', 'Jalur Evakuasi', 'Manual Handling']),
                    'work_area_id' => collect($workAreas)->where('division_id', $div->id)->random()->id,
                    'division_id' => $div->id,
                    'facilitator_id' => $supervisor->id,
                    'meeting_date' => Carbon::now()->subDays(rand(1, 7)),
                    'start_time' => '08:00',
                    'end_time' => '08:15',
                    'location' => 'Area ' . $div->name,
                    'agenda' => 'Pengecekan kesiapan tim dan pengingat K3 harian.',
                    'status' => 'completed',
                ]);

                // --- 11. APD PER DIVISION ---
                ApdInventory::create([
                    'item_code' => "APD-" . $div->code . "-" . $faker->unique()->numerify('###'),
                    'name' => "Safety Gear " . $div->name,
                    'category' => $faker->randomElement(['helmet', 'vest', 'gloves', 'boots']),
                    'work_area_id' => collect($workAreas)->where('division_id', $div->id)->random()->id,
                    'division_id' => $div->id,
                    'total_quantity' => rand(50, 100),
                    'available_quantity' => rand(40, 50),
                    'damaged_quantity' => rand(1, 10),
                    'condition' => 'good',
                ]);
            }

            // --- 12. SOPS PER COMPANY ---
            $sopCats = ['work_procedure', 'emergency_response', 'first_aid'];
            foreach ($sopCats as $cat) {
                Sop::create([
                    'document_number' => "SOP-" . strtoupper($company->code) . "-" . $faker->unique()->numerify('###'),
                    'title' => "Prosedur " . ucfirst(str_replace('_', ' ', $cat)),
                    'category' => $cat,
                    'content' => $faker->paragraphs(10, true),
                    'created_by' => $hseManager->id,
                    'status' => 'active',
                    'effective_date' => Carbon::now()->subYear(),
                ]);
            }
        }
    }
}
