<?php

namespace App\Services;

use App\Http\Requests\ActivateRequest;
use App\Models\Certificate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

/**
 * Service performing activation of a certificate
 */
class ActivationService
{
    /**
     * @param ActivateRequest $activateRequest
     * @return Application|RedirectResponse|Redirector|string
     *
     * Activates a certificate
     */
    public function activate(ActivateRequest $activateRequest)
    {
        $activation_key = $activateRequest->activation_key;

        $certificate = Certificate::where('activation_key', $activation_key)->get();

        foreach ($certificate as $item) {
            if ($item) {
                $item->update([
                    'status' => 1
                ]);
            }
        }

        return 'Unable to locate certificate with provided key';
    }
}
