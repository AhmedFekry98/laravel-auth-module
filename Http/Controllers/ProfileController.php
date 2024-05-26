<?php

namespace Modules\Auth\Http\Controllers;

use Graphicode\Standard\Facades\TDOFacade;
use Graphicode\Standard\Traits\ApiResponses;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\UpProfileRequest;
use Modules\Auth\Services\ProfileServices;
use Modules\Auth\Transformers\UserResource;

class ProfileController extends Controller
{
  use ApiResponses;

  public function __construct(
    private ProfileServices $profileServices
  ) {
  }

  public function index()
  {
    $profiles = $this->profileServices->getAll();

    return $this->okResponse(
      data: UserResource::collection($profiles),
      message: __('success_messages.get_data')
    );
  }


  public function show(Request $request)
  {
    $profile = $this->profileServices->getOne();

    if ($profile->errorInfo ?? null || !$profile) {
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

    if ($profile->errorInfo ?? null || !$profile) {
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
