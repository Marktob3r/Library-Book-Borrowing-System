<x-guest-layout>
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 mb-4 ring-8 ring-blue-50/50">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Student Registration</h2>
        <p class="text-sm text-gray-500 mt-2">Join our library community to start borrowing books.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name Row -->
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus autocomplete="given-name" 
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm text-sm"
                    placeholder="First name">
                <x-input-error :messages="$errors->get('first_name')" class="mt-1 text-xs text-red-600" />
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name" 
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm text-sm"
                    placeholder="Last name">
                <x-input-error :messages="$errors->get('last_name')" class="mt-1 text-xs text-red-600" />
            </div>
        </div>

        <!-- Student ID Row -->
        <div>
            <label for="student_id_number" class="block text-sm font-medium text-gray-700">Student ID Number</label>
            <input id="student_id_number" type="text" name="student_id_number" value="{{ old('student_id_number') }}" required autocomplete="username" 
                inputmode="numeric" pattern="[0-9]*" maxlength="9"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm text-sm"
                placeholder="e.g., 202422105">
            <x-input-error :messages="$errors->get('student_id_number')" class="mt-1 text-xs text-red-600" />
        </div>

        <!-- Course, Year, Block Row -->
        <div class="grid grid-cols-3 gap-3">
            <div>
                <label for="course" class="block text-sm font-medium text-gray-700">Course</label>
                <select id="course" name="course" required
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm text-sm">
                    <option value="">Select</option>
                    <option value="BSIT" {{ old('course') === 'BSIT' ? 'selected' : '' }}>BSIT</option>
                    <option value="BSCS" {{ old('course') === 'BSCS' ? 'selected' : '' }}>BSCS</option>
                    <option value="BSEMC" {{ old('course') === 'BSEMC' ? 'selected' : '' }}>BSEMC</option>
                </select>
                <x-input-error :messages="$errors->get('course')" class="mt-1 text-xs text-red-600" />
            </div>
            <div>
                <label for="year_level" class="block text-sm font-medium text-gray-700">Year</label>
                <select id="year_level" name="year_level" required
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm text-sm">
                    <option value="">Select</option>
                    <option value="1" {{ old('year_level') === '1' ? 'selected' : '' }}>1st</option>
                    <option value="2" {{ old('year_level') === '2' ? 'selected' : '' }}>2nd</option>
                    <option value="3" {{ old('year_level') === '3' ? 'selected' : '' }}>3rd</option>
                    <option value="4" {{ old('year_level') === '4' ? 'selected' : '' }}>4th</option>
                </select>
                <x-input-error :messages="$errors->get('year_level')" class="mt-1 text-xs text-red-600" />
            </div>
            <div>
                <label for="block" class="block text-sm font-medium text-gray-700">Block</label>
                <input id="block" type="text" name="block" value="{{ old('block') }}" required 
                    inputmode="text" pattern="[A-Za-z]" maxlength="1"
                    oninput="this.value = this.value.replace(/[^A-Za-z]/g, '').toUpperCase()"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm text-sm uppercase"
                    placeholder="A-Z">
                <x-input-error :messages="$errors->get('block')" class="mt-1 text-xs text-red-600" />
            </div>
        </div>

        <!-- Email Row -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm text-sm"
                placeholder="student@gmail.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-600" />
        </div>

        <!-- Password Row -->
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required autocomplete="new-password" 
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm text-sm"
                        placeholder="••••••••">
                    <button type="button" onclick="toggleBothPasswords()" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors">
                        <svg id="password-eye" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-600" />
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm text-sm"
                        placeholder="••••••••">
                    <button type="button" onclick="toggleBothPasswords()" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors">
                        <svg id="password_confirmation-eye" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-600" />
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                Create Account
            </button>
        </div>
    </form>

    <div class="mt-8 text-center text-sm text-gray-600 border-t border-gray-100 pt-6">
        Already have an account? 
        <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-500 transition-colors">
            Sign in instead
        </a>
    </div>
</x-guest-layout>

<script>
    function toggleBothPasswords() {
        const passwordField = document.getElementById('password');
        const confirmField = document.getElementById('password_confirmation');
        const eyeIcon = document.getElementById('password-eye');
        const confirmEyeIcon = document.getElementById('password_confirmation-eye');
        
        const isPassword = passwordField.type === 'password';
        
        if (isPassword) {
            passwordField.type = 'text';
            confirmField.type = 'text';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            confirmEyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
        } else {
            passwordField.type = 'password';
            confirmField.type = 'password';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            confirmEyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
        }
    }
</script>