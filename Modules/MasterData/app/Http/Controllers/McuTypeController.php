<?php

namespace Modules\MasterData\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\MasterData\App\Models\Diagnosis;
use Modules\MasterData\App\Models\McuType;

class McuTypeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $mcuTypes = McuType::with(['diagnoses' => function ($q) {
            $q->orderBy('name');
        }])
            ->withCount('diagnoses')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('recommended_exams', 'ilike', "%{$search}%")
                  ->orWhereHas('diagnoses', function ($dq) use ($search) {
                      $dq->where('name', 'ilike', "%{$search}%")
                         ->orWhere('code', 'ilike', "%{$search}%");
                  });
            })
            ->orderBy('name')
            ->paginate($perPage);

        return view('masterdata::mcu_types.index', compact('mcuTypes'));
    }

    public function create()
    {
        $diagnoses = Diagnosis::orderBy('name')->get(['id', 'code', 'name']);
        return view('masterdata::mcu_types.create', compact('diagnoses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('pgsql.sc_master.mcu_types', 'name')],
            'recommended_exams' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'diagnosis_ids' => ['nullable', 'array'],
            'diagnosis_ids.*' => ['integer', 'exists:pgsql.sc_master.diagnoses,id'],
        ]);

        $mcuType = McuType::create([
            'name' => $validated['name'],
            'recommended_exams' => $validated['recommended_exams'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        $mcuType->diagnoses()->sync($validated['diagnosis_ids'] ?? []);

        return redirect()->route('master.mcu-types.index')->with('success', 'Tipe MCU dan mapping diagnosa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mcuType = McuType::with('diagnoses:id')->findOrFail($id);
        $diagnoses = Diagnosis::orderBy('name')->get(['id', 'code', 'name']);
        $selectedIds = $mcuType->diagnoses->pluck('id')->all();

        return view('masterdata::mcu_types.edit', compact('mcuType', 'diagnoses', 'selectedIds'));
    }

    public function update(Request $request, $id)
    {
        $mcuType = McuType::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('pgsql.sc_master.mcu_types', 'name')->ignore($mcuType->id)],
            'recommended_exams' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'diagnosis_ids' => ['nullable', 'array'],
            'diagnosis_ids.*' => ['integer', 'exists:pgsql.sc_master.diagnoses,id'],
        ]);

        $mcuType->update([
            'name' => $validated['name'],
            'recommended_exams' => $validated['recommended_exams'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        $mcuType->diagnoses()->sync($validated['diagnosis_ids'] ?? []);

        return redirect()->route('master.mcu-types.index')->with('success', 'Mapping Tipe MCU berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mcuType = McuType::findOrFail($id);
        $mcuType->delete();

        return redirect()->route('master.mcu-types.index')->with('success', 'Tipe MCU berhasil dihapus.');
    }
}
