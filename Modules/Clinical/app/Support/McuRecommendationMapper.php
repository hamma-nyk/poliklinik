<?php

namespace Modules\Clinical\App\Support;

use Illuminate\Support\Collection;
use Modules\MasterData\App\Models\McuType;

class McuRecommendationMapper
{
    /**
     * Map patient medical records into grouped MCU department recommendations
     * using database MCU mappings first, with keyword fallback for unmapped diagnoses.
     */
    public static function summarize(Collection $records): Collection
    {
        $dbMap = self::buildDatabaseMap();
        $rules = self::rules();
        $grouped = [];

        foreach ($records as $record) {
            $diagId = $record->diagnosis_id;
            $diagName = trim((string) ($record->diagnosis->name ?? $record->diagnosa ?? ''));
            if ($diagName === '' && !$diagId) {
                continue;
            }

            $targets = [];

            if ($diagId && isset($dbMap[$diagId])) {
                $targets = $dbMap[$diagId];
            } else {
                $normalized = mb_strtolower($diagName);
                foreach ($rules as $rule) {
                    foreach ($rule['keywords'] as $kw) {
                        if (str_contains($normalized, $kw)) {
                            $targets[] = [
                                'category' => $rule['category'],
                                'exams' => $rule['exams'],
                            ];
                            break 2;
                        }
                    }
                }
            }

            if (empty($targets)) {
                $targets[] = [
                    'category' => 'Pemeriksaan Umum (General Check-Up)',
                    'exams' => 'Pemeriksaan Fisik Umum & Konsultasi Dokter',
                ];
            }

            $label = $diagName !== '' ? $diagName : 'Diagnosa #' . $diagId;

            foreach ($targets as $target) {
                $key = $target['category'];
                if (!isset($grouped[$key])) {
                    $grouped[$key] = [
                        'category' => $target['category'],
                        'exams' => $target['exams'] ?? '-',
                        'count' => 0,
                        'diagnoses' => [],
                    ];
                }

                $grouped[$key]['count']++;
                $grouped[$key]['diagnoses'][$label] = ($grouped[$key]['diagnoses'][$label] ?? 0) + 1;
            }
        }

        return collect($grouped)
            ->sortByDesc('count')
            ->values();
    }

    protected static function buildDatabaseMap(): array
    {
        $map = [];
        $mcuTypes = McuType::with('diagnoses:id')->get(['id', 'name', 'recommended_exams']);

        foreach ($mcuTypes as $mcu) {
            foreach ($mcu->diagnoses as $diag) {
                $map[$diag->id][] = [
                    'category' => $mcu->name,
                    'exams' => $mcu->recommended_exams ?: '-',
                ];
            }
        }

        return $map;
    }

    protected static function rules(): array
    {
        return [
            [
                'category' => 'Paru & Pernapasan (Pulmonologi)',
                'exams' => 'Rontgen Thorax (Foto Dada), Spirometri, Tes Sputum/BTA (bila indikasi TB)',
                'keywords' => ['ispa', 'paru', 'sesak', 'tb', 'asma', 'bronkitis', 'pneumonia'],
            ],
            [
                'category' => 'THT (Telinga, Hidung & Tenggorokan)',
                'exams' => 'Pemeriksaan THT-KL, Audiometri (kesehatan kerja), Evaluasi Saluran Napas Atas',
                'keywords' => ['telinga', 'epistaksis', 'faringitis', 'pharyngitis', 'tenggorokan', 'rhinitis', 'flu', 'commond cold', 'common cold', 'sinusitis', 'tonsilitis'],
            ],
            [
                'category' => 'Jantung & Pembuluh Darah (Kardiologi)',
                'exams' => 'EKG (Elektrokardiogram), Monitoring Tekanan Darah Berkala, Profil Risiko Kardiovaskular',
                'keywords' => ['hipertensi', 'hiperternis', 'tekanan darah tinggi', 'tensi darah rendah', 'nyeri dada', 'chf', 'pembesaran pembuluh darah', 'jantung'],
            ],
            [
                'category' => 'Metabolik & Penyakit Dalam (Interna)',
                'exams' => 'Lab Darah Lengkap, Profil Lipid (Kolesterol & Trigliserida), Asam Urat, Gula Darah Puasa',
                'keywords' => ['kolesterol', 'trigliserid', 'asam urat', 'gout', 'anemia', 'febris', 'demam', 'typoid', 'rat bite fever', 'diabetes'],
            ],
            [
                'category' => 'Saluran Cerna (Gastroenterologi)',
                'exams' => 'USG Abdomen, Pemeriksaan Fungsi Hati/Pencernaan, Konsultasi Penyakit Dalam / Bedah',
                'keywords' => ['asam lambung', 'gastritis', 'dyspepsia', 'dispepsia', 'diare', 'geads', 'perut', 'colic abdomen', 'abdominal pain', 'mual', 'ambeien', 'hemoroid', 'hernia'],
            ],
            [
                'category' => 'Otot, Tulang & Sendi (Ortopedi / Okupasi)',
                'exams' => 'Rontgen Tulang/Tulang Belakang, Evaluasi Ergonomi Kerja, Fisioterapi',
                'keywords' => ['nyeri otot', 'myalgia', 'kaku sendi', 'sprain', 'neck strain', 'lbp', 'post kll', 'kecelakaan kerja'],
            ],
            [
                'category' => 'Saraf (Neurologi)',
                'exams' => 'Pemeriksaan Neurologis, Tes Keseimbangan (Vestibular), Evaluasi Tekanan Darah',
                'keywords' => ['sakit kepala', 'pusing', 'chepalgia', 'cefalgia', 'vertigo', 'migrain'],
            ],
            [
                'category' => 'Mata (Oftalmologi)',
                'exams' => 'Tes Visus (Ketajaman Penglihatan), Tes Buta Warna, Pemeriksaan Slit Lamp',
                'keywords' => ['mata', 'conjungtivitis', 'konjungtivitis', 'visus'],
            ],
            [
                'category' => 'Gigi & Mulut (Dental)',
                'exams' => 'Pemeriksaan Gigi & Mulut (Odontogram), Scaling / Rontgen Panoramik',
                'keywords' => ['gigi', 'gusi', 'gingivitis', 'impaksi', 'sariawan'],
            ],
            [
                'category' => 'Saluran Kemih & Reproduksi (Urologi / Obgyn)',
                'exams' => 'Urinalisis Lengkap, USG Urologi / Kandungan',
                'keywords' => ['isk', 'nyeri haid', 'disminore', 'dismenore'],
            ],
            [
                'category' => 'Kulit & Bedah Minor (Dermatologi)',
                'exams' => 'Pemeriksaan Dermatologi, Evaluasi Alergi/Paparan Bahan Kerja, Perawatan Luka',
                'keywords' => ['ruam', 'kulit', 'gatal', 'dermatitis', 'herpes', 'cacar', 'bisul', 'furunkel', 'abses', 'cutaneus larva', 'cantengan', 'luka', 'lecet', 'memar', 'hematoma', 'combustio', 'vl'],
            ],
        ];
    }
}
