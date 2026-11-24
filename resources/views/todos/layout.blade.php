
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Todo App')</title>

    <!-- Tailwind CSS CDN (for learning and development) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="bg-slate-100 font-sans text-slate-800">

    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-slate-900 text-white flex-shrink-0">

            <div class="p-6 border-b border-slate-700">
                <h1 class="text-2xl font-extrabold tracking-tight">
                    <span class="text-indigo-400">✓</span> TaskFlow
                </h1>
                <p class="text-slate-400 text-sm mt-1">Manage your daily tasks</p>
            </div>

            <nav class="p-4 space-y-2">

                <a href="{{ route('todos.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('todos.create') ? 'text-slate-300 hover:bg-slate-800 hover:text-white' : 'bg-indigo-600 text-white' }}">
                    <span>📋</span>
                    <span class="font-medium">All Tasks</span>
                </a>

                <a href="{{ route('todos.create') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('todos.create') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span>➕</span>
                    <span class="font-medium">Add New Task</span>
                </a>

                <div class="pt-6">
                    <p class="text-xs uppercase tracking-wider text-slate-500 px-4 mb-3">
                        Workspace
                    </p>

                    <a href="#"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800">
                        <span>⚙️</span>
                        <span>Settings</span>
                    </a>
                </div>

            </nav>

            <div class="p-5 mt-4 border-t border-slate-700">
                <p class="text-sm text-slate-400">Stay productive!</p>
                <p class="text-xs text-slate-500 mt-1">Your personal task manager</p>
            </div>

        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-w-0">

            <!-- Top Navbar -->
            <header class="bg-white border-b border-slate-200 px-6 py-4 flex justify-between items-center">

                <div>
                    <h2 class="text-lg font-bold text-slate-800">
                        @yield('page-heading', 'Dashboard')
                    </h2>
                    <p class="text-sm text-slate-500">
                        Welcome back! Manage your work.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                        U
                    </div>
                </div>

            </header>

            <!-- Page Content -->
            <div class="p-4 sm:p-6 lg:p-8">

                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')

            </div>

            <!-- Footer -->
            <footer class="px-6 py-5 text-center text-sm text-slate-500">
                © {{ date('Y') }} TaskFlow. Built with Laravel & Tailwind CSS.
            </footer>

        </main>

    </div>

</body>
</html>
