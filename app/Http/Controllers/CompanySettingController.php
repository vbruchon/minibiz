<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanySettingController extends Controller
{

    public function index()
    {
        $company = CompanySetting::first();
        $initialType = ($company && !$company->vat_number) ? 'auto' : 'company';

        return view('dashboard.company-settings.index', compact('company', 'initialType'));
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'company_name'      => 'required|string|max:255',
            'company_email'     => 'required|email|max:255',
            'company_phone'     => 'nullable|string|max:50',
            'address_line1'     => 'required|string|max:255',
            'address_line2'     => 'nullable|string|max:255',
            'postal_code'       => 'required|string|max:20',
            'city'              => 'required|string|max:100',
            'country'           => 'required|string|max:100',
            'siren'             => 'nullable|string|size:9',
            'siret'             => 'required|string|size:14',
            'ape_code'          => 'nullable|string|max:10',
            'vat_number'        => 'nullable|string|max:50',
            'website'           => 'nullable|string|max:255',
            'logo_file'         => 'nullable|image|max:2048',
            'logo_path'         => 'nullable|string|max:255',
            'currency'          => 'nullable|string|size:3',
            'default_tax_rate'  => 'nullable|numeric|min:0|max:100',
            'footer_note'       => 'nullable|string',
            'business_type'     => 'required|in:company,auto',
        ]);

        $company = CompanySetting::first();
        $data['logo_path'] = $this->handleLogoUpload($request, $company);

        $data['currency'] = $data['currency'] ?? 'EUR';
        $data['default_tax_rate'] = $data['default_tax_rate'] ?? 20.00;

        if ($data['business_type'] === 'auto') {
            $this->normalizeAutoEntrepreneurData($data);
        }

        CompanySetting::updateOrCreate(['id' => 1], $data);

        return redirect()
            ->route('dashboard.company-settings.index')
            ->with('success', 'Les informations de l’entreprise ont été enregistrées avec succès !');
    }

    private function handleLogoUpload(Request $request, ?CompanySetting $existing): ?string
    {
        if ($request->hasFile('logo_file')) {
            if ($existing && str_starts_with($existing->logo_path, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $existing->logo_path));
            }
            $path = $request->file('logo_file')->store('logo', 'public');
            return 'storage/' . $path;
        }

        return $request->filled('logo_path') ? $request->input('logo_path') : null;
    }

    private function normalizeAutoEntrepreneurData(array &$data): void
    {
        $data['vat_number'] = null;
        $data['default_tax_rate'] = 0;
        $data['footer_note'] = 'TVA non applicable, article 293 B du CGI.';
    }
}
