<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Aunion – Sign In</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * {
            margin: 0; padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
            text-decoration: none;
            list-style: none;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: radial-gradient(ellipse at top left, #e8c4c4 0%, #f5e6d0 40%, #fdf5e8 100%);
        }

        .container {
            position: relative;
            width: 860px;
            height: 540px;
            background: #fff;
            margin: 20px;
            border-radius: 30px;
            box-shadow: 0 8px 40px rgba(128,0,32,0.13), 0 2px 8px rgba(0,0,0,0.06);
            overflow: hidden;
        }

        /* ── Form Boxes ── */
        .form-box {
            position: absolute;
            right: 0;
            width: 50%;
            height: 100%;
            background: #fff;
            display: flex;
            align-items: center;
            color: #333;
            text-align: center;
            padding: 40px 44px;
            z-index: 1;
            transition: 0.6s ease-in-out 1.2s, visibility 0s 1s;
        }

        .container.active .form-box { right: 50%; }

        .form-box.register { visibility: hidden; }
        .container.active .form-box.register { visibility: visible; }

        .form-box form { width: 100%; }

        .form-box h1 {
            font-size: 26px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 6px;
        }

        .form-box .subtitle {
            font-size: 13px;
            color: #717182;
            margin-bottom: 22px;
        }

        /* ── Logo ── */
        .logo-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 18px;
        }
        .logo-wrap img {
            height: 64px;
            width: auto;
            object-fit: contain;
        }

        /* ── Inputs ── */
        .input-box {
            position: relative;
            margin: 14px 0;
            text-align: left;
        }

        .input-box input {
            width: 100%;
            padding: 11px 44px 11px 16px;
            background: #f8f8f8;
            border-radius: 10px;
            border: 1.5px solid rgba(128,0,32,0.15);
            outline: none;
            font-size: 13.5px;
            color: #1a1a1a;
            transition: border-color 0.18s, box-shadow 0.18s;
        }
        .input-box input:focus {
            border-color: rgba(128,0,32,0.45);
            box-shadow: 0 0 0 3px rgba(128,0,32,0.08);
            background: #fff;
        }
        .input-box input::placeholder { color: #b0b0b8; }

        .input-box i.icon-static {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #800020;
            pointer-events: none;
        }

        .input-box i.toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #800020;
            cursor: pointer;
            user-select: none;
            transition: color 0.15s;
        }
        .input-box i.toggle-pw:hover { color: #6b001b; }

        /* ── Forgot ── */
        .forgot-link {
            text-align: right;
            margin: -8px 0 14px;
        }
        .forgot-link a {
            font-size: 12.5px;
            color: #800020;
            font-weight: 600;
        }

        /* ── Error box ── */
        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 9px 14px;
            margin-bottom: 12px;
            font-size: 12.5px;
            color: #dc2626;
            text-align: left;
        }

        /* ── Buttons ── */
        .btn-submit {
            width: 100%;
            height: 46px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            background: #800020;
            transition: background 0.18s, transform 0.1s;
            margin-top: 4px;
        }
        .btn-submit:hover { background: #6b001b; transform: translateY(-1px); }

        .form-box .register-note {
            font-size: 12.5px;
            color: #717182;
            margin-top: 16px;
        }
        .form-box .register-note a {
            color: #800020;
            font-weight: 700;
        }

        /* ── Toggle panel ── */
        .toggle-box {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .toggle-box::before {
            content: "";
            position: absolute;
            left: -250%;
            width: 300%;
            height: 100%;
            background: #800020;
            border-radius: 150px;
            z-index: 2;
            transition: 1.8s ease-in-out;
        }

        .container.active .toggle-box::before { left: 50%; }

        .toggle-panel {
            position: absolute;
            width: 50%;
            height: 100%;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 2;
            transition: 0.6s ease-in-out;
            padding: 40px;
            text-align: center;
        }

        .toggle-panel.toggle-left {
            left: 0;
            transition-delay: 1.2s;
        }
        .container.active .toggle-panel.toggle-left {
            left: -50%;
            transition-delay: 0.6s;
        }

        .toggle-panel.toggle-right {
            right: -50%;
            transition-delay: 0.6s;
        }
        .container.active .toggle-panel.toggle-right {
            right: 0;
            transition-delay: 1.2s;
        }

        .toggle-panel .logo-badge {
            width: 68px;
            height: 68px;
            background: rgba(255,255,255,0.12);
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .toggle-panel h1 {
            font-size: 24px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 10px;
        }

        .toggle-panel p {
            font-size: 13.5px;
            color: rgba(255,255,255,0.78);
            margin-bottom: 26px;
            line-height: 1.6;
        }

        .btn-outline {
            width: 150px;
            height: 44px;
            background: transparent;
            border: 2px solid rgba(255,255,255,0.7);
            border-radius: 10px;
            cursor: pointer;
            font-size: 13.5px;
            font-weight: 700;
            color: #fff;
            transition: background 0.18s, border-color 0.18s;
        }
        .btn-outline:hover {
            background: rgba(255,255,255,0.12);
            border-color: #fff;
        }

        .gold-pill {
            display: inline-block;
            background: #FDB813;
            color: #5c3700;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 12px;
            border-radius: 20px;
            margin-bottom: 16px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        /* Student ID feedback */
        .id-feedback {
            font-size: 12px;
            margin-top: 5px;
            padding: 5px 10px;
            border-radius: 8px;
            display: none;
        }
        .id-feedback.found {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            display: block;
        }
        .id-feedback.not-found {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            display: block;
        }

        /* ══════════════════════════════════════
           MOBILE — single-column stacked layout
           The sliding side-panel becomes a
           compact maroon header bar on top.
        ══════════════════════════════════════ */
        @media screen and (max-width: 680px) {

            body { align-items: flex-start; padding: 16px 0; }

            .container {
                width: 100%;
                height: auto;
                min-height: 100%;
                border-radius: 20px;
                margin: 0 16px;
                /* let height grow with content */
                overflow: visible;
            }

            /* ── Form boxes stack vertically, full width ── */
            .form-box {
                position: relative;   /* out of absolute flow */
                right: auto;
                width: 100%;
                height: auto;
                padding: 28px 24px 32px;
                display: none;        /* hidden by default; JS shows active one */
                align-items: flex-start;
                transition: none;
                visibility: visible !important;
            }

            /* Show the login form by default */
            .form-box.login  { display: flex; }
            .form-box.register { display: none; }

            /* When container is active, flip visibility */
            .container.active .form-box.login    { display: none; }
            .container.active .form-box.register { display: flex; }

            /* Slide animation is desktop-only; on mobile just instant swap */
            .container.active .form-box { right: auto; }

            .form-box form { width: 100%; }

            /* Smaller logo on mobile */
            .logo-wrap img { height: 52px; }

            .form-box h1   { font-size: 22px; }
            .form-box .subtitle { margin-bottom: 16px; }

            /* Tighten input spacing */
            .input-box { margin: 10px 0; }

            /* ── Toggle panel becomes a maroon pill-bar above the form ── */
            .toggle-box {
                position: relative;
                width: 100%;
                height: auto;
                /* sits above the form */
                order: -1;
            }

            /* Hide the morphing blob — not needed on mobile */
            .toggle-box::before { display: none; }

            /* Both panels stacked; only the active one is visible */
            .toggle-panel {
                position: relative;
                width: 100%;
                height: auto;
                padding: 24px 24px 20px;
                border-radius: 20px 20px 0 0;
                background: #800020;
                display: none;
                flex-direction: column;
                align-items: center;
                text-align: center;
                transition: none;
            }

            /* Show toggle-left (login panel) by default */
            .toggle-panel.toggle-left  { display: flex; }
            .toggle-panel.toggle-right { display: none; }

            .container.active .toggle-panel.toggle-left  { display: none; }
            .container.active .toggle-panel.toggle-right { display: flex; }

            /* Override desktop transition delays */
            .toggle-panel.toggle-left,
            .toggle-panel.toggle-right,
            .container.active .toggle-panel.toggle-left,
            .container.active .toggle-panel.toggle-right {
                left: auto; right: auto; top: auto; bottom: auto;
                transition-delay: 0s;
            }

            /* Smaller logo badge */
            .toggle-panel .logo-badge {
                width: 52px; height: 52px;
                margin-bottom: 12px;
            }

            .toggle-panel h1  { font-size: 19px; margin-bottom: 6px; }
            .toggle-panel p   { font-size: 13px; margin-bottom: 16px; }

            .btn-outline {
                width: 130px;
                height: 40px;
                font-size: 13px;
            }

            /* Make container a flex column so toggle sits on top */
            .container {
                display: flex;
                flex-direction: column;
                overflow: hidden;
                border-radius: 20px;
            }
        }

        /* Very small screens (≤380px) */
        @media screen and (max-width: 380px) {
            .container { margin: 0 10px; }
            .form-box  { padding: 22px 16px 28px; }
            .toggle-panel { padding: 20px 16px 16px; }
            .form-box h1 { font-size: 20px; }
        }
    </style>
</head>
<body>

<div class="container" id="authContainer">

    {{-- Toggle panel rendered FIRST so it sits on top in flex-column on mobile --}}
    <div class="toggle-box">

        <div class="toggle-panel toggle-left">
            <div class="logo-badge">
                <svg width="30" height="30" viewBox="0 0 28 28" fill="none">
                    <path d="M14 4C14 4 8 10 8 15C8 18.314 10.686 21 14 21C17.314 21 20 18.314 20 15C20 10 14 4 14 4Z" fill="#FDB813"/>
                    <circle cx="14" cy="15" r="3.5" fill="#ffffff"/>
                </svg>
            </div>
            <span class="gold-pill">Aunion Alumni</span>
            <h1>Hello, Alumni!</h1>
            <p>New here? Create an account and join the community of graduates.</p>
            <button class="btn-outline register-btn">Register Now</button>
        </div>

        <div class="toggle-panel toggle-right">
            <div class="logo-badge">
                <svg width="30" height="30" viewBox="0 0 28 28" fill="none">
                    <path d="M14 4C14 4 8 10 8 15C8 18.314 10.686 21 14 21C17.314 21 20 18.314 20 15C20 10 14 4 14 4Z" fill="#FDB813"/>
                    <circle cx="14" cy="15" r="3.5" fill="#ffffff"/>
                </svg>
            </div>
            <span class="gold-pill">Welcome Back</span>
            <h1>Already a Member?</h1>
            <p>Sign in with your existing account to access your alumni portal.</p>
            <button class="btn-outline login-btn">Sign In</button>
        </div>

    </div>

    {{-- ══════════════ LOGIN FORM ══════════════ --}}
    <div class="form-box login">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="role" value="alumni"/>

            <div class="logo-wrap">
                <img src="{{ asset('images/AUNIONLOGO.png') }}" alt="Aunion Logo">
            </div>

            <h1>Welcome Back</h1>
            <p class="subtitle">Sign in to your alumni account</p>

            @if (session('status'))
                <div class="error-box" style="background:#f0fdf4;border-color:#bbf7d0;color:#16a34a;">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-box">{{ $errors->first() }}</div>
            @endif

            <div class="input-box">
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="Email address" required autocomplete="email"/>
                <i class='bx bxs-envelope icon-static'></i>
            </div>

            <div class="input-box">
                <input type="password" id="loginPassword" name="password"
                       placeholder="Password" required autocomplete="current-password"/>
                <i class='bx bxs-hide toggle-pw' id="toggleLoginPw" title="Show/hide password"></i>
            </div>

            <div class="forgot-link">
                <a href="#">Forgot Password?</a>
            </div>

            <button type="submit" class="btn-submit">Sign In</button>

        </form>
    </div>

    {{-- ══════════════ REGISTER FORM ══════════════ --}}
    <div class="form-box register">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="logo-wrap">
                <img src="{{ asset('images/AUNIONLOGO.png') }}" alt="Aunion Logo">
            </div>

            <h1>Create Account</h1>
            <p class="subtitle">Join the Aunion alumni network</p>

            <div class="input-box" id="studentIdBox">
                <input type="text" id="studentIdInput" name="student_id"
                       value="{{ old('student_id') }}"
                       placeholder="Student ID (e.g. JD2018)" required
                       autocomplete="off"/>
                <i class='bx bxs-id-card icon-static'></i>
            </div>

            <div class="input-box">
                <input type="text" id="registerName" name="name"
                       value="{{ old('name') }}"
                       placeholder="Full name" required/>
                <i class='bx bxs-user icon-static'></i>
            </div>

            <div class="input-box">
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="Email address (optional)"/>
                <i class='bx bxs-envelope icon-static'></i>
            </div>

            <div class="input-box">
                <input type="password" id="registerPassword" name="password"
                       placeholder="Password" required/>
                <i class='bx bxs-hide toggle-pw' id="toggleRegisterPw"></i>
            </div>

            <div class="input-box">
                <input type="password" id="registerPasswordConfirm" name="password_confirmation"
                       placeholder="Confirm password" required/>
                <i class='bx bxs-hide toggle-pw' id="toggleRegisterConfirmPw"></i>
            </div>

            @if ($errors->any())
                <div class="error-box">{{ $errors->first() }}</div>
            @endif

            <button type="submit" class="btn-submit">Register</button>

        </form>
    </div>

</div>

<script>
    const container   = document.getElementById('authContainer');
    const registerBtn = document.querySelector('.register-btn');
    const loginBtn    = document.querySelector('.login-btn');

    registerBtn.addEventListener('click', () => container.classList.add('active'));
    loginBtn.addEventListener('click',    () => container.classList.remove('active'));

    function bindPasswordToggle(toggleId, inputId) {
        const toggle = document.getElementById(toggleId);
        const input  = document.getElementById(inputId);
        if (!toggle || !input) return;
        toggle.addEventListener('click', () => {
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            toggle.classList.toggle('bxs-hide', !isHidden);
            toggle.classList.toggle('bxs-show',  isHidden);
        });
    }

    bindPasswordToggle('toggleLoginPw',          'loginPassword');
    bindPasswordToggle('toggleRegisterPw',        'registerPassword');
    bindPasswordToggle('toggleRegisterConfirmPw', 'registerPasswordConfirm');

    // Student ID live lookup
    const studentIdInput = document.getElementById('studentIdInput');
    const registerName   = document.getElementById('registerName');

    const feedback = document.createElement('div');
    feedback.className = 'id-feedback';
    studentIdInput.parentNode.appendChild(feedback);

    let lookupTimer;
    studentIdInput.addEventListener('input', function () {
        clearTimeout(lookupTimer);
        const val = this.value.trim();
        if (!val) {
            feedback.className = 'id-feedback';
            feedback.textContent = '';
            registerName.value = '';
            registerName.readOnly = false;
            return;
        }
        lookupTimer = setTimeout(() => {
            fetch(`/lookup-alumni?student_id=${encodeURIComponent(val)}`)
                .then(r => r.json())
                .then(data => {
                    if (data.found) {
                        registerName.value    = data.name;
                        registerName.readOnly = true;
                        feedback.className    = 'id-feedback found';
                        feedback.textContent  = `✓ Found: ${data.name} — ${data.course} (${data.batch_year})`;
                    } else {
                        registerName.value    = '';
                        registerName.readOnly = false;
                        feedback.className    = 'id-feedback not-found';
                        feedback.textContent  = '✗ Student ID not found in our records.';
                    }
                })
                .catch(() => {});
        }, 500);
    });

    @if ($errors->any() && old('student_id'))
        document.getElementById('authContainer').classList.add('active');
    @endif
</script>

</body>
</html>