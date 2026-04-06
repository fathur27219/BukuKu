<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BISMILLAH- Login</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Custom CSS -->
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .custom-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        }

        .login-container {
            height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .time-font {
            font-variant-numeric: tabular-nums;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="login-container flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Header with Logo and Time -->
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">LIBRAFLOW</h1>
                <div class="text-gray-600">
                    <div id="current-date" class="text-lg font-medium time-font">WEDNESDAY, FEB 4, 2026</div>
                    <div id="current-time" class="text-lg font-medium time-font">10:32:59 AM WIB</div>
                </div>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-2xl custom-shadow p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">LOGIN</h2>
                    <p class="text-gray-600 mt-2">Welcome Back!</p>
                </div>

                <!-- Admin Indicator -->
                <div class="flex items-center justify-center mb-6">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-indigo-50 text-indigo-700">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">Login Admin</span>
                    </div>
                </div>
                @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ $errors->first() }}
                </div>
                @endif
                <!-- Login Form -->
                <form action="{{ route('login.process') }}" method="POST"> @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    id="username"
                                    name="username"
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                    placeholder="Enter your username">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                    placeholder="Enter your password">
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg id="eyeIcon" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <button
                                type="submit"
                                id="loginButton"
                                class="w-full py-3 px-4 bg-gradient-primary text-white font-semibold rounded-xl hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                                LOG IN
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Welcome Back Section -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 text-center">Welcome Back!</h3>
                    <p class="text-gray-600 text-center mt-2" id="dynamic-text-1">Your secure portal to manage the system</p>
                    <p class="text-gray-600 text-center" id="dynamic-text-2">Access your dashboard and tools</p>

                    <!-- Login/Reset Toggle -->
                    <div class="mt-4 flex justify-center space-x-4">
                        <button id="loginToggle" class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg transition">
                            Login
                        </button>
                        <button id="resetToggle" class="px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                            Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <!-- <script>
        // Update real-time clock and date
        function updateDateTime() {
            const now = new Date();

            // Format day
            const days = ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'];
            const day = days[now.getDay()];

            // Format month
            const months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
            const month = months[now.getMonth()];

            // Format date
            const date = now.getDate();
            const year = now.getFullYear();

            // Format time
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let seconds = now.getSeconds();
            const ampm = hours >= 12 ? 'PM' : 'AM';

            hours = hours % 12;
            hours = hours ? hours : 12;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            // Update DOM
            document.getElementById('current-date').textContent = `${day}, ${month} ${date}, ${year}`;
            document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds} ${ampm} WIB`;
        }

        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        });

        // Login/Reset toggle functionality
        document.getElementById('loginToggle').addEventListener('click', function() {
            this.classList.add('bg-indigo-600', 'text-white');
            this.classList.remove('bg-gray-200', 'text-gray-700');

            document.getElementById('resetToggle').classList.add('bg-gray-200', 'text-gray-700');
            document.getElementById('resetToggle').classList.remove('bg-indigo-600', 'text-white');

            // In a real app, this would switch the form mode
            document.getElementById('dynamic-text-1').textContent = 'Your secure portal to manage the system';
            document.getElementById('dynamic-text-2').textContent = 'Access your dashboard and tools';
        });

        document.getElementById('resetToggle').addEventListener('click', function() {
            this.classList.add('bg-indigo-600', 'text-white');
            this.classList.remove('bg-gray-200', 'text-gray-700');

            document.getElementById('loginToggle').classList.add('bg-gray-200', 'text-gray-700');
            document.getElementById('loginToggle').classList.remove('bg-indigo-600', 'text-white');

            // In a real app, this would switch to password reset mode
            document.getElementById('dynamic-text-1').textContent = 'Reset your password securely';
            document.getElementById('dynamic-text-2').textContent = 'Enter your email to receive reset instructions';
        });


        // Initialize real-time clock
        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Focus on username field on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('username').focus();
        });
    </script> -->
</body>

</html>