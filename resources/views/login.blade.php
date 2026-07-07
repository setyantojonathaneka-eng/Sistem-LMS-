<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    @vite(['resources/css/login.css', 'resources/js/login.js'])
    <!-- font: Arial, sans-serif -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .pw-wrap { position: relative; width: 100%; }
        .pw-wrap input { width: 100%; padding-right: 40px !important; }
        .pw-toggle {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            cursor: pointer; color: #999; font-size: 16px; line-height: 1;
        }
        .pw-toggle:hover { color: #555; }
    </style>
  </head>
  <body>
    <div class="card">
      <div class="card-bg"></div>
      <div class="hero signup active">
        <h2>Welcome Back!</h2>
        <p>Sign in to review your latest profit from investments.</p>
        <button type="button" onclick="toggleView()">SIGN IN</button>
      </div>
      <div class="form signup active">
  <h2>Create Account</h2>
  <div class="sso">
  </div>
  <p style="margin-bottom:1cm;">Or use your email address</p>
  <form id="register-form">
    <input type="text" name="name" placeholder="Full name" required />
    <input type="email" name="email" placeholder="Email address" required />
    <div class="pw-wrap"><input type="password" name="password" placeholder="Password" required /><span class="pw-toggle" onclick="togglePw(this)"><i class="far fa-eye"></i></span></div>
    <div class="pw-wrap"><input type="password" name="password_confirmation" placeholder="Confirm password" required /><span class="pw-toggle" onclick="togglePw(this)"><i class="far fa-eye"></i></span></div>
    <span class="error" id="register-error"></span>
    <button type="submit">SIGN UP</button>
  </form>

  {{-- OTP Section (tersembunyi dulu) --}}
  <div id="otp-section" style="display:none; flex-direction:column; align-items:center; gap:12px; width:100%;">
    <p style="text-align:center; opacity:0.7; font-size:13px;">Masukkan kode OTP yang dikirim ke email kamu</p>
    <form id="otp-form" style="width:100%; display:flex; flex-direction:column; align-items:center; gap:12px;">
      <input type="text" name="otp" placeholder="6-digit OTP" maxlength="6" required style="text-align:center; letter-spacing:8px; font-size:18px;" />
      <span class="error" id="otp-error"></span>
      <button type="submit">VERIFY</button>
    </form>
    <a id="resend-otp" style="font-size:13px; cursor:pointer; opacity:0.6;">Kirim ulang OTP</a>
  </div>
</div>

      <div class="hero signin">
        <h2>Hey There!</h2>
        <p>Begin your journey using this software, and start earning now.</p>
        <button type="button" onclick="toggleView()">SIGN UP</button>
      </div>

      <div class="form signin">
        <h2>Sign In</h2>
        <div class="sso">
        </div>
        <p style="margin-bottom:1cm;">Or use your email address</p>
        <form id="login-form" method="POST" action="{{ route('login.post') }}">
          @csrf
          <input type="email" name="email" placeholder="Email address" value="{{ old('email') }}" required />
          <div class="pw-wrap"><input type="password" name="password" placeholder="Password" required /><span class="pw-toggle" onclick="togglePw(this)"><i class="far fa-eye"></i></span></div>
          <a href="#">Forgot password?</a>
          @if ($errors->any())
            <span class="error" id="login-error">{{ $errors->first() }}</span>
          @else
            <span class="error" id="login-error"></span>
          @endif
          <button type="submit">SIGN IN</button>
        </form>
      </div>
    </div>
    <script>
        function togglePw(btn) {
            const input = btn.previousElementSibling;
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'far fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'far fa-eye';
            }
        }
    </script>
  </body>
</html>
