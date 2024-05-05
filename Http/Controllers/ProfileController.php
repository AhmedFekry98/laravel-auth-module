<?php

namespace Modules\Auth\Http\Controllers;

use Graphicode\Standard\Facades\TDOFacade;
use Graphicode\Standard\Traits\ApiResponses;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\UpProfileRequest;
use Modules\Auth\Services\ProfileServices;

class ProfileController extends Controller
{
    use ApiResponses;

    public function __construct(
        private ProfileServices $profileServices
    )
    {}


    public function edit(Request $request)
    {
        $profile = $this->profileServices->getOne();

        if($profile->errorInfo ?? null || !$profile){
            return $this->badResponse(
              $message = __("error_messages.profile")
            );
          }

        return $this->okResponse(
            $profile,
            $messge = __('success_messages.profile')
        );
    }

    public function update(UpProfileRequest $request)
    {
        $profile = $this->profileServices->update(TDOFacade::make($request));

        if($profile->errorInfo ?? null || !$profile){
            return $this->badResponse(
              $message = __("error_messages.up_profile")
            );
          }

        return $this->okResponse(
            $profile,
            $messge = __('success_messages.up_profile')
        );

    }


}
