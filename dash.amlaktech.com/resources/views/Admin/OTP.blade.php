<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>OTP Form</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        cairo: ['Cairo', 'sans-serif'],
                    },
                },
            },
        };
    </script>
</head>

<body class="relative font-cairo antialiased">

<main class="relative min-h-screen flex flex-col justify-center overflow-hidden" style="background-color: #dde5f4">
    <div class="w-full max-w-6xl mx-auto px-4 md:px-6 py-24">
        <div class="flex justify-center flex-direction-column" style="align-items: center;flex-direction: column;">

            <a href="{{url('/')}}" class="logo-wrapper">
                <img class="logo" src="{{asset('assets/images/logo.png')}}" alt="" style="max-width: 150px"/>
            </a>

            <div class="max-w-md mx-auto text-center bg-white px-4 sm:px-8 py-10 rounded-xl shadow">

                <header class="mb-8">

                    @if(session()->has('errors'))
                        <div class="container mx-auto p-4" x-data="{ showAlert: true }">

                            <div x-show="showAlert"
                                 class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                 role="alert">
                                <strong class="font-bold">خطأ!</strong>
                                <span class="block sm:inline">برجاء التأكد من ادخال كود التحقق المرسل بشكل صحيح.</span>
                            </div>
                        </div>
                    @endif

                    <h1 class="text-2xl font-bold mb-1">التأكد من رقم الجوال</h1>
                    <p class="text-[15px] text-slate-500">برجاء ادخال رمز التحقق المكون من 4 أرقام الذي تم إرساله إلى
                        رقم هاتفك.</p>
                </header>
                <form id="otp-form" action="{{dashboard_route('login.otp.post')}}" method="post">
                    @csrf

                    <div class="flex items-center justify-center gap-3">
                        <input
                            type="text"
                            name="otp[]"
                            class="w-14 h-14 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                            pattern="\d*" maxlength="1"/>
                        <input
                            type="text"
                            name="otp[]"
                            class="w-14 h-14 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                            maxlength="1"/>
                        <input
                            type="text"
                            name="otp[]"
                            class="w-14 h-14 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                            maxlength="1"/>
                        <input
                            type="text"
                            name="otp[]"
                            class="w-14 h-14 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                            maxlength="1"/>
                    </div>
                </form>
                <div class="text-sm text-slate-500 mt-4">لك تحصل على الكود؟<a
                        class="font-medium text-indigo-500 hover:text-indigo-600" href="#0">إعادة الارسال</a></div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const form = document.getElementById('otp-form')
                    const inputs = [...form.querySelectorAll('input[type=text]')]
                    const submit = form.querySelector('button[type=submit]')

                    inputs[0].focus();

                    const handleKeyDown = (e) => {
                        if (
                            !/^[0-9]{1}$/.test(e.key)
                            && e.key !== 'Backspace'
                            && e.key !== 'Delete'
                            && e.key !== 'Tab'
                            && !e.metaKey
                        ) {
                            e.preventDefault()
                        }

                        if (e.key === 'Delete' || e.key === 'Backspace') {
                            const index = inputs.indexOf(e.target);
                            if (index > 0) {
                                inputs[index - 1].value = '';
                                inputs[index - 1].focus();
                            }
                        }
                    }

                    const handleInput = (e) => {
                        const {target} = e
                        const index = inputs.indexOf(target)
                        if (target.value) {
                            if (index < inputs.length - 1) {
                                inputs[index + 1].focus()
                            } else {
                                // submit.focus()
                                document.getElementById('otp-form').submit()
                                // Disable all input elements
                                inputs.forEach(input => input.disabled = true);
                            }
                        }
                    }

                    const handleFocus = (e) => {
                        e.target.select()
                    }

                    const handlePaste = (e) => {
                        e.preventDefault()
                        const text = e.clipboardData.getData('text')
                        if (!new RegExp(`^[0-9]{${inputs.length}}$`).test(text)) {
                            return
                        }
                        const digits = text.split('')
                        inputs.forEach((input, index) => input.value = digits[index])
                        document.getElementById('otp-form').focus()
                    }

                    inputs.forEach((input) => {
                        input.addEventListener('input', handleInput)
                        input.addEventListener('keydown', handleKeyDown)
                        input.addEventListener('focus', handleFocus)
                        input.addEventListener('paste', handlePaste)
                    })
                })
            </script>

        </div>
    </div>
</main>

<!-- Page footer -->
<footer class="absolute left-6 right-6 md:left-12 md:right-auto bottom-4 md:bottom-8 text-center md:text-left">
    <a class="text-xs text-slate-500 hover:underline" href="https://cruip.com">&copy;Cruip - Tailwind CSS
        templates</a>
</footer>

</body>

</html>
