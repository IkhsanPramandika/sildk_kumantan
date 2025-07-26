<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Resident;

class DataImport implements ToCollection, WithHeadingRow
{
    private function formatDate($date)
    {
        try {
            return Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        } catch (\Exception $e) {
            try {
                return Carbon::parse($date)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }
    }

    private function mapGender($gender)
    {
        return strtolower($gender) === 'perempuan' ? 'female' : 'male';
    }

    private function mapReligion($religion)
    {
        $map = [
            'ISLAM' => 'islam',
            'KRISTEN' => 'christian',
            'KATOLIK' => 'catholic',
            'HINDU' => 'hindu',
            'BUDDHA' => 'buddhist',
            'KONGHUCU' => 'confucian',
            'LAINNYA' => 'other'
        ];
        return $map[strtoupper($religion)] ?? 'other';
    }

    private function mapMaritalStatus($status)
    {
        $map = [
            'KAWIN' => 'married',
            'BELUM KAWIN' => 'single',
            'CERAI HIDUP' => 'divorced',
            'CERAI MATI' => 'widowed'
        ];
        return $map[strtoupper($status)] ?? 'single';
    }

    private function mapEducation($education)
    {
        $map = [
            'TIDAK / BELUM SEKOLAH' => 'none',
            'BELUM TAMAT SD/SEDERAJAT' => 'elementary',
            'TAMAT SD / SEDERAJAT' => 'elementary',
            'SLTP/SEDERAJAT' => 'junior_high',
            'SLTA / SEDERAJAT' => 'senior_high',
            'DIPLOMA I / II' => 'd2',
            'AKADEMI/ DIPLOMA III/S. MUDA' => 'd3',
            'DIPLOMA IV/ STRATA I' => 's1',
            'STRATA II' => 's2',
            'STRATA III' => 's3'
        ];
        return $map[strtoupper($education)] ?? 'none';
    }

    private function mapBloodType($bloodType)
    {
        $map = [
            'A' => 'A',
            'B' => 'B',
            'AB' => 'AB',
            'O' => 'O',
            'TIDAK TAHU' => 'Unknown',
            '-' => 'Unknown'
        ];
        return $map[strtoupper($bloodType)] ?? 'Unknown';
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                Resident::create([
                    'nik' => $row['nik'],
                    'family_card_number' => $row['nokk'],
                    'full_name' => $row['nama_lgkp'],
                    'address' => $row['alamat'],
                    'rt' => str_pad($row['rt'], 3, '0', STR_PAD_LEFT),
                    'rw' => str_pad($row['rw'], 3, '0', STR_PAD_LEFT),
                    'birth_place' => $row['tmpt_lhr'],
                    'birth_date' => $this->formatDate($row['tgl_lhr']),
                    'gender' => $this->mapGender($row['jenis_klmin']),
                    'religion' => $this->mapReligion($row['agama']),
                    'marital_status' => $this->mapMaritalStatus($row['stat_kwn']),
                    'occupation' => $row['jenis_pkrjn'],
                    'last_education' => $this->mapEducation($row['pddk_akh']),
                    'blood_type' => $this->mapBloodType($row['gol_drh']),
                    'citizenship' => 'wni',
                    'life_status' => 'alive',
                    'mother_name' => $row['nama_lgkp_ibu'] ?? null,
                    'father_name' => $row['nama_lgkp_ayah'],
                    'family_relationship_status' => strtolower($row['stat_hbkel']),
                    'disability_type' => $row['pnydg_cacat'] === '-' ? null : $row['pnydg_cacat'],
                    'hamlet' => null,
                ]);
            } catch (\Exception $e) {
                \Log::error('Error importing row: ' . json_encode($row));
                \Log::error('Error message: ' . $e->getMessage());
                continue;
            }
        }
    }
}
