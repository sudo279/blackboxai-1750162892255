<?php

namespace App\Http\Controllers\Tools\Osint;

use App\Http\Controllers\Controller;
use App\Models\AdhaarInfoData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdhaarInfoController extends Controller
{
    public function index()
    {
        try {
            $access = PlanChecker::check('adhaar-info');
            if ($access !== true) {
                return $access;
            }

            $adhaarInfoData = AdhaarInfoData::where('uid', Auth::user()->uid)
                                ->orderBy('created_at', 'desc')
                                ->get();

            return view('backend.users.pages.osint.adhaar-info', compact('adhaarInfoData'));
        } catch (\Exception $e) {
            Log::error('Error in AdhaarInfo index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load Aadhaar information. Please try again later.');
        }
    }

    public function check(Request $request)
    {
        try {
            $request->validate([
                'adhaar' => 'required|numeric|digits:12'
            ]);

            $adhaarInfo = AdhaarInfoData::create([
                'uid' => Auth::user()->uid,
                'adhaar' => $request->adhaar,
                'additional_info' => json_encode([
                    'status' => 'checked',
                    'timestamp' => now()
                ])
            ]);

            return redirect()->route('osint-tools.adhaar-info')
                           ->with('success', 'Aadhaar information has been processed successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                           ->withErrors($e->validator)
                           ->withInput();
        } catch (\Exception $e) {
            Log::error('Error in AdhaarInfo check: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Failed to process Aadhaar information. Please try again.')
                           ->withInput();
        }
    }
}
