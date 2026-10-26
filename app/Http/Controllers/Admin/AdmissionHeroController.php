<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdmissionHeroRequest;
use App\Models\AdmissionHero;
use Illuminate\Http\Request;

class AdmissionHeroController extends Controller
{
    /**
     * [READ] Display Admission Hero section management form.
     */
    public function index()
    {
        $hero = AdmissionHero::first() ?? new AdmissionHero([
            'location_tag'  => 'NARAPALLY, HYDERABAD',
            'title'         => 'Admission Open For',
            'academic_year' => '2026 – 2027',
            'description'   => 'Give your child the right foundation for a brighter future. Apply early for personalized guidance, campus tour, and direct interaction with academic mentors.',
            'phone'         => '+91 915740 43210',
            'email'         => 'info@jrsinternationalschool.com',
            'features'      => [
                [
                    'title'    => 'CBSE Curriculum',
                    'subtitle' => 'National standards',
                    'icon'     => 'bi bi-mortarboard-fill',
                ],
                [
                    'title'    => 'Holistic Growth',
                    'subtitle' => 'Arts, sports & STEM',
                    'icon'     => 'bi bi-stars',
                ],
                [
                    'title'    => 'Top Faculty',
                    'subtitle' => 'Caring mentorship',
                    'icon'     => 'bi bi-award-fill',
                ],
            ],
            'trust_badges'  => [
                '100% Confidential',
                'Quick 24-hr Response',
            ],
            'enquiry_academic_years' => [
                '2026-2027',
                '2027-2028',
            ],
            'enquiry_admission_types'=> [
                'DAY SCHOLAR',
                'DAY BOARDING',
                'RESIDENTIAL',
            ],
        ]);

        return view('admin.admission-hero.index', compact('hero'));
    }

    /**
     * [UPDATE] Update Admission Hero details.
     */
    public function update(AdmissionHeroRequest $request)
    {
        $hero = AdmissionHero::first();

        if ($hero) {
            $hero->update($request->validated());
        } else {
            $hero = AdmissionHero::create($request->validated());
        }

        return redirect()->route('admin.admission-hero.index')
            ->with('success', 'Admission Open hero section updated successfully.');
    }
}
