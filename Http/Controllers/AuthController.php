<?php

namespace Modules\Auth\Http\Controllers;

use Graphicode\Standard\Facades\TDOFacade;
use Graphicode\Standard\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Enums\ErrorCode;
use Modules\Auth\Http\Requests\ChangePasswordRequest;
use Modules\Auth\Http\Requests\CheckOtpRequest;
use Modules\Auth\Http\Requests\ForgotPasswordRequest;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Http\Requests\ResetPasswordRequest;
use Modules\Auth\Services\ChangePasswordService;
use Modules\Auth\Services\CheckOtpService;
use Modules\Auth\Services\ForgotPasswordService;
use Modules\Auth\Services\LoginService;
use Modules\Auth\Services\LogoutService;
use Modules\Auth\Services\RegisterService;
use Modules\Auth\Services\ResetPasswordService;
use Modules\Auth\Transformers\UserResource;
use PharIo\Manifest\Email;

class AuthController extends Controller
{
  use ApiResponses;


  public function __construct(
    private RegisterService $registerService,
    private LoginService $loginService,
    private LogoutService $logoutService,
    private ForgotPasswordService  $forgotPasswordService,
    private CheckOtpService   $CheckOtpService,
    private ResetPasswordService $resetPasswordService,
    private ChangePasswordService $changePasswordService

  ) {
  }

  # Function Register
  public function register(RegisterRequest $request)
  {
 
    $user = $this->registerService->register((TDOFacade::make($request)));

    if ($user->errorInfo ?? null) {
      return $this->badResponse(
        $message = __("error_messages.user_register")
      );
    }

    $deviceName = $request->post("device_name", $request->userAgent());
    $token = $user->createToken($deviceName);

    return $this->okResponse(
      [
        'token' => $token->plainTextToken,
        'user'  => UserResource::make($user)
      ],
      $message = __("success_messages.user_register")
    );
  }

  # Fanction Login
  public function login(LoginRequest $request)
  {
    $user =  $this->loginService->login((TDOFacade::make($request)));

    if ($user->errorInfo ?? null || !$user) {
      return $this->badResponse(
        $message = __("error_messages.user_login")
      );
    }

    $deviceName = $request->post("device_name", $request->userAgent());
    $token = $user->createToken($deviceName)->plainTextToken;

    return $this->okResponse(
      [
        'token' => $token,
        'user'  => UserResource::make($user)
      ],
      $message = __("success_messages.user_login")
    );
  }

  # Function Logout
  public function logout(Request $request)
  {

    $user =  $this->logoutService->logout($request->user());
    if ($user) {
      return $this->okResponse(
        data: (object) [],
        message: __('success_messages.user_logout')
      );
    }

    return $this->badResponse(
      $message = __("error_messages.user_logout")
    );
  }

  # Function forgot-password
  public function forgotPassword(ForgotPasswordRequest $request)
  {
    $user = $this->forgotPasswordService->forgotPassword((TDOFacade::make($request)));
    if ($user->errorInfo ?? null || !$user) {
      return $this->badResponse(
        $message = __("error_messages.user_forgotpassword", [
          'email_otp_forgot' => $user,
        ])
      );
    }

    return $this->okResponse(
      $message = __('success_messages.user_forgotpassword', [
        'email_otp_forgot' => $user,
      ])
    );
  }

  // # Function check-otp
  public function checkOtp(CheckOtpRequest $request)
  {
    $otpToken = $this->CheckOtpService->checkOtp(TDOFacade::make($request));
    
    if ( isset($otpToken['error']) ) {
      return $this->badResponse(
        message: $otpToken['error']
      );
    }
    return $this->okResponse(
      data: [
        'otpToken' => $otpToken
      ],
      message: 'Get OTP Token successfuly'
    );
  }

  # reset-password
  public function resetPassword(ResetPasswordRequest $request)
  {
    $user = $this->resetPasswordService->resetPassword(TDOFacade::make($request));

    if ( isset($user['error']) ) {
      return $this->badResponse(
        message: $user['error']
      );
    }

    $deviceName = $request->post("device_name", $request->userAgent());
    $token = $user->createToken($deviceName)->plainTextToken;

    return $this->okResponse(
      data: [
        'token' => $token,
        'user'  => UserResource::make($user)
      ],
      message: __('success_messages.user_resetpassword')
    );
  }

  # change-password

  public function changePassword(ChangePasswordRequest $request)
  {
    $user = $this->changePasswordService->changePassword(TDOFacade::make($request));

    if ($user->errorInfo ?? null || !$user) {
      return $this->badResponse(
        $message = __("error_messages.change_password")
      );
    }
    return $this->okResponse(
      $user,
      $message = __('success_messages.change_password')
    );
  }
}
